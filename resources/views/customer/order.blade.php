@extends('layouts.customer')

@section('title', 'Pesanan Pelanggan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-xl rounded-lg p-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-extrabold text-purple-900 mb-6">Daftar Pesanan</h1>

        <!-- Display success or warning messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @elseif (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg">
                <p class="font-semibold">{{ session('warning') }}</p>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-purple-50 p-4 rounded-lg text-center">
                <p class="text-purple-700 font-semibold">Belum ada pesanan.</p>
                <a href="{{ route('customer.index') }}" class="mt-4 inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i> Buat Pesanan Baru
                </a>
            </div>
        @else
            <div class="bg-purple-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-purple-700 mb-4">Riwayat Pesanan Anda</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-purple-200 rounded-lg text-sm">
                        <thead>
                            <tr class="bg-purple-600 text-white">
                                <th class="py-3 px-4 text-center font-semibold">ID Pesanan</th>
                                <th class="py-3 px-4 text-center font-semibold">Bundle</th>
                                <th class="py-3 px-4 text-center font-semibold">Total Harga</th>
                                <th class="py-3 px-4 text-center font-semibold">Nama Lengkap</th>
                                <th class="py-3 px-4 text-center font-semibold">Tanggal Acara</th>
                                <th class="py-3 px-4 text-center font-semibold">Status</th>
                                <th class="py-3 px-4 text-center font-semibold">Midtrans Order ID</th>
                                <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($orders as $order)
                                <tr class="border-b hover:bg-purple-50">
                                    <td class="py-2 px-4 text-center">{{ $order->id }}</td>
                                    <td class="py-2 px-4 text-center">{{ $order->bundle->nama_paket ?? 'Bundle Tidak Ditemukan' }}</td>
                                    <td class="py-2 px-4 text-center">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 text-center">{{ $order->nama_lengkap ?? '-' }}</td>
                                    <td class="py-2 px-4 text-center">{{ $order->tanggal_acara ? \Carbon\Carbon::parse($order->tanggal_acara)->format('d/m/Y') : '-' }}</td>
                                    <td class="py-2 px-4 text-center">
                                        <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold
                                            {{ $order->status === 'pending' 
                                                ? 'bg-yellow-100 text-yellow-700' 
                                                : ($order->status === 'success' 
                                                    ? 'bg-green-100 text-green-700' 
                                                    : 'bg-red-100 text-red-700') }}">
                                            @switch($order->status)
                                                @case('pending')
                                                    Menunggu Pembayaran
                                                    @break
                                                @case('success')
                                                    Pembayaran Berhasil
                                                    @break
                                                @case('failed')
                                                    Pembayaran Gagal
                                                    @break
                                                @default
                                                    {{ ucfirst($order->status) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 text-center">{{ $order->midtrans_order_id ?? '-' }}</td>
                                    <td class="py-2 px-4 space-y-1 text-center">
                                        @if($order->status === 'pending' && $order->payment_url)
                                            <a href="{{ $order->payment_url }}" 
                                               class="block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-1.5 px-3 rounded-lg transition transform hover:scale-105 mb-1">
                                                <i class="fas fa-credit-card mr-1"></i> Bayar
                                            </a>
                                        @endif
                                        
                                        @if(Route::has('customer.order.show'))
                                            <a href="{{ route('customer.order.show', $order->id) }}"
                                               class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 px-3 rounded-lg transition transform hover:scale-105">
                                               <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                        @else
                                            <a href="{{ url('/customer/order/' . $order->id) }}"
                                               class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 px-3 rounded-lg transition transform hover:scale-105">
                                               <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection