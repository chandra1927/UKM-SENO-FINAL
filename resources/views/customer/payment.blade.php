<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Pembayaran Pemesanan</h1>
        <p>Total Harga: Rp {{ number_format($order->total_harga, 2, ',', '.') }}</p>
        <button id="pay-button" class="bg-blue-500 text-white px-4 py-2 rounded">Bayar Sekarang</button>
        <a href="{{ route('customer.history') }}" class="text-blue-500">Lihat Riwayat</a>

        <script>
            document.getElementById('pay-button').onclick = function () {
                snap.pay('{{ $order->midtrans_payment_url }}', {
                    onSuccess: function (result) {
                        alert('Pembayaran berhasil!');
                        window.location.href = '{{ route('customer.history') }}';
                    },
                    onPending: function (result) {
                        alert('Menunggu pembayaran.');
                        window.location.href = '{{ route('customer.history') }}';
                    },
                    onError: function (result) {
                        alert('Pembayaran gagal.');
                        window.location.href = '{{ route('customer.history') }}';
                    },
                    onClose: function () {
                        alert('Anda menutup popup pembayaran.');
                    }
                });
            };
        </script>
    </div>
</body>
</html>
