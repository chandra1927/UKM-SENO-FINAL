<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Bundle;
use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Tambahkan untuk Query Builder
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CustomerController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Gunakan true untuk production
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Validasi apakah server key ada
        if (empty(Config::$serverKey)) {
            Log::error('MIDTRANS_SERVER_KEY is not set in .env');
            throw new \Exception('Midtrans server key is not configured. Please check your .env file.');
        }
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

    public function order(Request $request)
    {
        $query = Order::where('user_id', Auth::id());

        // Pencarian berdasarkan kata kunci
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Pagination
        $orders = $query->latest()->paginate(5); // 5 item per halaman, sesuaikan sesuai kebutuhan

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
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;
        $orderId = str_replace('ORDER-', '', $notification->order_id);
        $paymentType = $notification->payment_type;
        $transactionTime = $notification->transaction_time;
        $amount = $notification->gross_amount;

        Log::info('Midtrans Notification Received', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraudStatus' => $fraudStatus,
            'payment_type' => $paymentType,
            'transaction_time' => $transactionTime,
            'amount' => $amount,
        ]);

        $order = Order::find($orderId);

        if ($order) {
            if ($transactionStatus == 'capture' && $fraudStatus == 'accept') {
                $order->status = 'success';
                $order->midtrans_transaction_time = $transactionTime;
                $order->save();

                // Catat transaksi keuangan sebagai pemasukan
                FinancialTransaction::create([
                    'user_id' => 1, // Ganti dengan ID pengguna keuangan atau logika otomatis
                    'date' => now()->toDateString(),
                    'description' => 'Pembayaran Pesanan #' . $order->id,
                    'type' => 'pemasukan',
                    'amount' => $amount,
                    'midtrans_transaction_id' => $notification->order_id,
                ]);

                Log::info('Order ' . $orderId . ' updated to success and recorded as financial transaction');
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                $order->status = 'cancel';
                $order->save();
                Log::info('Order ' . $orderId . ' updated to cancel');
            } else {
                $order->status = 'pending';
                $order->save();
                Log::info('Order ' . $orderId . ' remains pending');
            }
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

        // Ambil semua tanggal yang sudah dipesan untuk bundle ini
        $bookedDates = Order::where('bundle_id', $bundleId)
            ->where('status', '!=', 'failed') // Hanya tanggal yang belum gagal
            ->pluck('tanggal_acara')
            ->toArray();

        return view('customer.order-create', compact('bundle', 'bookedDates'));
    }

    public function storeOrder(Request $request)
    {
        // Log input untuk debugging
        Log::info('storeOrder Request Data', $request->all());

        try {
            // Validasi input
            $validatedData = $request->validate([
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

            // Periksa pesanan yang sudah ada untuk semua pengguna
            $existingOrder = Order::where('bundle_id', $request->bundle_id)
                ->where('tanggal_acara', $request->tanggal_acara)
                ->where('status', '!=', 'failed') // Hanya tanggal yang belum gagal
                ->exists();

            if ($existingOrder) {
                return response()->json(['success' => false, 'message' => 'Tanggal ini sudah dipesan oleh pengguna lain. Silakan pilih tanggal lain.'], 400);
            }

            // Ambil data bundle
            $bundle = Bundle::findOrFail($request->bundle_id);
            $totalHarga = $bundle->harga;

            // Simpan pesanan
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

            // Konfigurasi Midtrans
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

            // Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();

            Log::info('Snap token generated for order ' . $order->id . ': ' . $snapToken);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'snap_token' => $snapToken
            ]);
        } catch (\ValidationException $e) {
            Log::error('Validation Error in storeOrder', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validasi gagal: ' . json_encode($e->errors())], 400);
        } catch (\Exception $e) {
            Log::error('Error in storeOrder: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $order = Order::where('id', str_replace('ORDER-', '', $request->order_id))->first();

                if ($order) {
                    $order->update(['status' => 'success']);
                    return response()->json(['message' => 'Payment status updated to success.']);
                }
            } elseif (in_array($request->transaction_status, ['deny', 'cancel', 'expire', 'failure'])) {
                $order = Order::where('id', str_replace('ORDER-', '', $request->order_id))->first();

                if ($order) {
                    $order->update(['status' => 'cancel']);
                    return response()->json(['message' => 'Payment status updated to cancel.']);
                }
            }
        }

        return response()->json(['message' => 'Invalid signature or transaction status.'], 400);
    }

    public function handleMidtransNotification(Request $request)
    {
        echo 'test notification handler';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result, true);

        if ($result && isset($result['order_id']) && isset($result['status_code'])) {
            $orderId = str_replace('ORDER-', '', $result['order_id']);
            $data = [
                'status_code' => $result['status_code']
            ];

            // Perbarui status di tabel orders berdasarkan status_code
            $order = Order::find($orderId);
            if ($order) {
                if ($result['status_code'] == 200) {
                    $order->status = 'success';
                    $order->save();
                    Log::info('Order ' . $orderId . ' updated to success via notification');
                } else {
                    $order->status = 'pending';
                    $order->save();
                    Log::info('Order ' . $orderId . ' remains pending via notification');
                }
            } else {
                Log::warning('Order not found for notification', ['order_id' => $orderId]);
            }

            return response()->json(['status' => 'Notification handled']);
        }

        return response()->json(['message' => 'Invalid notification data'], 400);
    }
}