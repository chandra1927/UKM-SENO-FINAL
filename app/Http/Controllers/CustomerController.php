<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Bundle;
use Illuminate\Support\Facades\Auth;

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

    public function storeOrder(Request $request)
    {
        $request->validate([
            'bundle_id' => 'required|exists:bundles,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $bundle = Bundle::findOrFail($request->bundle_id);

        $order = Order::create([
            'user_id' => Auth::id(),
            'bundle_id' => $bundle->id,
            'total_harga' => $bundle->harga,
            'status' => 'pending',
            'notes' => $request->notes,
            'bundle_details' => json_encode([
                'nama_paket' => $bundle->nama_paket,
                'isi_paket' => $bundle->isi_paket,
                'deskripsi' => $bundle->deskripsi,
                'harga' => $bundle->harga,
                'video_path' => $bundle->video_path,
            ]),
        ]);

        // Integrasi Midtrans (opsional, uncomment jika sudah diatur)
        /*
        $midtransResponse = // Panggil API Midtrans untuk mendapatkan payment URL
        $order->midtrans_payment_url = $midtransResponse->redirect_url;
        $order->midtrans_order_id = $midtransResponse->order_id;
        $order->save();
        */

        return redirect()->route('customer.payment')->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }
}