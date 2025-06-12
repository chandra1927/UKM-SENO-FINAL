<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Bundle;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;

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

public function storeOrder(Request $request)
{
    // Validasi request
    $request->validate([
        'bundle_id' => 'required|exists:bundles,id',
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email',
        'no_telepon' => 'required|string|max:20',
    ]);

    // Ambil harga dari Bundle
    $bundle = Bundle::findOrFail($request->bundle_id);
    $totalHarga = $bundle->harga;

    // Simpan order ke database
    $order = new Order();
    $order->bundle_id = $request->bundle_id;
    $order->user_id = auth()->id(); 
    $order->nama_lengkap = $request->nama_lengkap;
    $order->email = $request->email;
    $order->no_telepon = $request->no_telepon;
    $order->total_harga = $totalHarga;
    $order->status = 'pending';
    $order->save();

    // Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Siapkan data transaksi Midtrans
    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . $order->id,
            'gross_amount' => $order->total_harga,
        ],
        'customer_details' => [
            'first_name' => $order->nama_lengkap,
            'email' => $order->email,
            'phone' => $order->no_telepon,
        ],
        'enabled_payments' => ['gopay', 'bank_transfer', 'shopeepay'], // opsional
    ];

    try {
        $response = \Midtrans\Snap::createTransaction($params);
        $order->payment_url = $response->redirect_url;
        $order->save();

        return redirect($response->redirect_url);
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
    }
}
}