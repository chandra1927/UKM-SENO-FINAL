@extends('layouts.customer')

@section('title', 'Pesanan Pelanggan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Daftar Pesanan</h1>
        @if($orders->isEmpty())
            <p class="text-gray-600">Belum ada pesanan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border-b text-left text-gray-600">ID Pesanan</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Bundle ID</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Total Harga</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Status</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Midtrans Order ID</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $order->bundle_id }}</td>
                                <td class="py-2 px-4 border-b">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border-b">{{ $order->status }}</td>
                                <td class="py-2 px-4 border-b">{{ $order->midtrans_order_id ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if($order->midtrans_payment_url && $order->status == 'pending')
                                        <a href="{{ $order->midtrans_payment_url }}"
                                           class="text-blue-500 hover:underline" target="_blank">Bayar Sekarang</a>
                                    @else
                                        <span class="text-gray-600">Tidak ada aksi</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection