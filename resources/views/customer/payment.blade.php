@extends('layouts.customer')

@section('title', 'Pembayaran Pesanan')

@section('content')
<!-- Midtrans Snap JS -->
<script type="text/javascript"
        src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-xl rounded-lg p-6 max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-extrabold text-purple-900">Pembayaran Pesanan #{{ $order->id }}</h1>
            <a href="{{ route('customer.order') }}"
               class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <!-- Detail Pesanan -->
        <div class="bg-purple-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold text-purple-700 mb-4">Detail Pesanan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-700"><strong>ID Pesanan:</strong> {{ $order->id }}</p>
                    <p class="text-gray-700"><strong>Bundle:</strong> {{ $order->bundle->nama_paket ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    <p class="text-gray-700"><strong>Status:</strong> 
                        @if ($order->status == 'paid')
                            <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">Sudah Dibayar</span>
                        @elseif ($order->status == 'failed')
                            <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">Gagal</span>
                        @else
                            <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">Menunggu Pembayaran</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-gray-700"><strong>Nama Lengkap:</strong> {{ $order->nama_lengkap ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>No. Telepon:</strong> {{ $order->no_telepon ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Tombol Bayar -->
        <div class="flex justify-end">
            @if ($order->snap_token && $order->status !== 'paid')
                <button id="pay-button"
                        class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                </button>
            @elseif ($order->status === 'paid')
                <p class="text-green-600 font-semibold">Pesanan ini sudah dibayar.</p>
            @else
                <p class="text-red-600 font-semibold">Token pembayaran belum tersedia. Silakan hubungi admin.</p>
            @endif
        </div>
    </div>
</div>

@if ($order->snap_token && $order->status !== 'paid')
<!-- Script untuk Snap -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function () {
                snap.pay('{{ $order->snap_token }}', {
                    onSuccess: function (result) {
                        alert('Pembayaran berhasil!');
                        window.location.href = '{{ route("customer.order") }}';
                    },
                    onPending: function (result) {
                        alert('Menunggu pembayaran selesai.');
                        window.location.href = '{{ route("customer.order") }}';
                    },
                    onError: function (result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        console.error(result);
                    },
                    onClose: function () {
                        alert('Anda menutup pop-up pembayaran.');
                    }
                });
            });
        }
    });
</script>
@endif
@endsection
