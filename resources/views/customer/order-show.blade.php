@extends('layouts.customer')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-xl rounded-lg p-6 max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-extrabold text-purple-900">Detail Pesanan #{{ $order->id }}</h1>
            <a href="{{ route('customer.order') }}"
               class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <!-- Informasi Pesanan -->
        <div class="bg-purple-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold text-purple-700 mb-4">Informasi Pesanan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-700"><strong>ID Pesanan:</strong> {{ $order->id }}</p>
                    <p class="text-gray-700"><strong>Bundle:</strong> {{ $order->bundle->nama_paket ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    <p class="text-gray-700"><strong>Status:</strong>
                        <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                               ($order->status === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p class="text-gray-700"><strong>Midtrans Order ID:</strong> {{ $order->midtrans_order_id ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-700"><strong>Nama Lengkap:</strong> {{ $order->nama_lengkap ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>No. Telepon:</strong> {{ $order->no_telepon ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Alamat:</strong> {{ $order->alamat ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Tanggal Acara:</strong> {{ $order->tanggal_acara ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Waktu Acara:</strong> {{ $order->waktu_acara ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Lokasi Acara:</strong> {{ $order->lokasi_acara ?? 'N/A' }}</p>
                </div>
            </div>
            @if($order->notes)
                <div class="mt-4">
                    <p class="text-gray-700"><strong>Catatan:</strong> {{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Aksi -->
        @if($order->status === 'pending')
            <div class="flex justify-end">
                <a href="{{ route('customer.payment', $order->id) }}"
                   class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                </a>
            </div>
        @endif
    </div>
</div>
@endsection