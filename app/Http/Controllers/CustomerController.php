<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Bundle;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CustomerController extends Controller
{
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

    public function payment()
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('customer.order')->with('warning', 'Tidak ada pesanan yang perlu dibayar.');
        }

        return view('customer.payment', compact('order'));
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
        $bundle = Bundle::select('id', 'nama_paket', 'isi_paket', 'deskripsi', 'harga', 'video_path')->findOrFail($bundleId);
        return view('customer.order-create', compact('bundle'));
    }

    public function show($id)
    {
        \Log::info('Accessing order show page', ['order_id' => $id, 'user_id' => Auth::id()]);
        $order = Order::with('bundle')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('customer.order.show', compact('order'));
    }

    public function showPaymentPage($id)
    {
        $order = Order::with('bundle')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('customer.payment', compact('order'));
    }

    public function handleCallback($orderId)
    {
        \Log::info('Handling Midtrans callback', ['order_id' => $orderId, 'user_id' => Auth::id()]);
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'success') {
            return redirect()->route('customer.order')->with('success', 'Pembayaran berhasil! Pesanan Anda telah dikonfirmasi.');
        }

        return redirect()->route('customer.order')->with('warning', 'Pembayaran belum berhasil dikonfirmasi.');
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

        $bundle = Bundle::findOrFail($request->bundle_id);
        $totalHarga = $bundle->harga;

        $order = new Order();
        $order->bundle_id = $request->bundle_id;
        $order->user_id = auth()->id();
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

        // Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Generate callback URLs with fallbacks
        try {
            $callbackUrl = route('customer.payment.callback', $order->id);
            \Log::info('Generated callback URL using route', ['url' => $callbackUrl, 'order_id' => $order->id]);
        } catch (\Exception $e) {
            \Log::warning('Route customer.payment.callback not found, using fallback URL', ['error' => $e->getMessage(), 'order_id' => $order->id]);
            $callbackUrl = url('/customer/payment/callback/' . $order->id);
            \Log::info('Fallback callback URL', ['url' => $callbackUrl, 'order_id' => $order->id]);
        }

        try {
            $notificationUrl = route('midtrans.notification');
            \Log::info('Generated notification URL using route', ['url' => $notificationUrl, 'order_id' => $order->id]);
        } catch (\Exception $e) {
            \Log::warning('Route midtrans.notification not found, using fallback URL', ['error' => $e->getMessage(), 'order_id' => $order->id]);
            $notificationUrl = url('/midtrans/notification');
            \Log::info('Fallback notification URL', ['url' => $notificationUrl, 'order_id' => $order->id]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->nama_lengkap,
                'email' => $order->email,
                'phone' => $order->no_telepon,
                'billing_address' => [
                    'address' => $order->alamat,
                ],
            ],
            'enabled_payments' => ['gopay', 'bank_transfer', 'shopeepay'],
            'callbacks' => [
                'finish' => $callbackUrl,
                'notification' => $notificationUrl,
            ],
        ];

        try {
            $response = Snap::createTransaction($params);
            $order->payment_url = $response->redirect_url;
            $order->midtrans_order_id = 'ORDER-' . $order->id;
            $order->save();

            \Log::info('Midtrans transaction created', ['order_id' => $order->id, 'redirect_url' => $response->redirect_url]);
            return redirect($response->redirect_url);
        } catch (\Exception $e) {
            \Log::error('Midtrans transaction error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function handleMidtransNotification(Request $request)
    {
        \Log::info('Received Midtrans notification', ['request' => $request->all()]);
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notif = new Notification();
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;

            // Extract actual order ID (remove 'ORDER-' prefix)
            $actualOrderId = str_replace('ORDER-', '', $orderId);
            $order = Order::findOrFail($actualOrderId);

            if ($transaction == 'capture' && $fraud == 'accept') {
                $order->status = 'success';
            } elseif ($transaction == 'settlement') {
                $order->status = 'success';
            } elseif ($transaction == 'pending') {
                $order->status = 'pending';
            } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
                $order->status = 'failed';
            }

            $order->save();

            \Log::info('Midtrans notification processed', ['order_id' => $actualOrderId, 'status' => $order->status]);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 400);
        }
    }
}