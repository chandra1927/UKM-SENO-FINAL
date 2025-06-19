@extends('layouts.customer')

@section('title', 'Checkout Pesanan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-xl rounded-lg p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-extrabold text-purple-900 mb-6">Checkout Pesanan</h1>
        <p class="text-gray-700 mb-4">Silakan lakukan pembayaran untuk pesanan dengan ID: {{ $order->id }}</p>
        <button id="pay-button" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
            <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
        </button>

        <!-- Midtrans Snap Script -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        alert('Pembayaran berhasil! Silakan cek status pesanan.');
                        window.location.href = "{{ route('customer.order') }}";
                    },
                    onPending: function(result) {
                        alert('Pembayaran menunggu konfirmasi. Silakan cek status pesanan nanti.');
                        window.location.href = "{{ route('customer.order') }}";
                    },
                    onError: function(result) {
                        alert('Terjadi kesalahan saat pembayaran. Silakan coba lagi.');
                        window.location.href = "{{ route('customer.order') }}";
                    },
                    onClose: function() {
                        alert('Pembayaran dibatalkan.');
                        window.location.href = "{{ route('customer.order') }}";
                    }
                });
            };
        </script>
    </div>
</div>
@endsection