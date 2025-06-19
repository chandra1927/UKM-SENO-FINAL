<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Bundle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CustomerController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $bundles = Bundle::select('id', 'nama_paket', 'isi_paket', 'deskripsi', 'harga', 'video_path')->get();
        return view('customer.dashboard', compact('bundles'));
    }

    public function history()
    {
        $orders = Order::with('bundle')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.history', compact('orders'));
    }

    public function order()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('customer.order', compact('orders'));
    }

    public function payment($orderId)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $orderId)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('customer.order')->with('warning', 'Pesanan tidak ditemukan atau sudah dibayar.');
        }

        return view('customer.payment', compact('order'));
    }

    public function handleNotification(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY'); // Pastikan server key diatur ulang di sini
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;
        $orderId = str_replace('ORDER-', '', $notification->order_id);
        $paymentType = $notification->payment_type;
        $transactionTime = $notification->transaction_time;

        Log::info('Midtrans Notification Received', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_type' => $paymentType,
            'transaction_time' => $transactionTime,
        ]);

        $order = Order::find($orderId);

        if ($order) {
            if ($transactionStatus == 'capture' && $fraudStatus == 'accept') {
                $order->status = 'success';
                $order->midtrans_transaction_time = $transactionTime;
                Log::info('Order ' . $orderId . ' updated to success');
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                $order->status = 'failed';
                Log::info('Order ' . $orderId . ' updated to failed');
            } else {
                $order->status = 'pending';
                Log::info('Order ' . $orderId . ' remains pending');
            }
            $order->save();

            // Opsional: Kirim notifikasi ke pengguna (misalnya via email)
        } else {
            Log::warning('Order not found for notification', ['order_id' => $orderId]);
        }

        return response()->json(['status' => 'Notification handled']);
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        Customer::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('customer.index')->with('success', 'Data pelanggan berhasil disimpan.');
    }

    public function edit(Customer $customer)
    {
        if ($customer->user_id !== Auth::id()) {
            abort(403, 'Tidak diizinkan.');
        }

        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if ($customer->user_id !== Auth::id()) {
            abort(403, 'Tidak diizinkan.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->user_id !== Auth::id()) {
            abort(403, 'Tidak diizinkan.');
        }

        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }

    public function indexCustomer()
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('customer.create')->with('warning', 'Data pelanggan belum ada. Silakan isi informasi pelanggan Anda.');
        }

        return view('customer.index', compact('customer'));
    }

    public function createOrder($bundleId)
    {
        $bundle = Bundle::select('id', 'nama_paket', 'isi_paket', 'deskripsi', 'harga', 'video_path')
            ->findOrFail($bundleId);
        return view('customer.order-create', compact('bundle'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'bundle_id' => 'required|exists:bundles,id',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'tanggal_acara' => 'required|date|after_or_equal:today',
            'waktu_acara' => 'required|date_format:H:i',
            'lokasi_acara' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $existingOrder = Order::where('bundle_id', $request->bundle_id)
            ->where('tanggal_acara', $request->tanggal_acara)
            ->where('status', '!=', 'failed')
            ->exists();

        if ($existingOrder) {
            return response()->json(['success' => false, 'message' => 'Paket ini sudah dipesan pada tanggal tersebut. Silakan pilih tanggal lain.'], 400);
        }

        $bundle = Bundle::findOrFail($request->bundle_id);
        $totalHarga = $bundle->harga;

        $order = new Order();
        $order->bundle_id = $request->bundle_id;
        $order->user_id = Auth::id();
        $order->nama_lengkap = $request->nama_lengkap;
        $order->email = $request->email;
        $order->no_telepon = $request->no_telepon;
        $order->alamat = $request->alamat;
        $order->tanggal_acara = $request->tanggal_acara;
        $order->waktu_acara = $request->waktu_acara;
        $order->lokasi_acara = $request->lokasi_acara;
        $order->notes = $request->notes;
        $order->total_harga = $totalHarga;
        $order->status = 'pending';
        $order->save();

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => $order->no_telepon,
                'billing_address' => [
                    'address' => $order->alamat,
                ],
            ],
            'enabled_payments' => ['gopay', 'bank_transfer', 'shopeepay', 'credit_card'],
            'callbacks' => [
                'finish' => route('customer.payment', $order->id),
                'notification' => route('midtrans.notification'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();

            Log::info('Snap token generated for order ' . $order->id . ': ' . $snapToken);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal membuat transaksi: ' . $e->getMessage()], 500);
        }
    }
}