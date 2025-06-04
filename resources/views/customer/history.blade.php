@extends('layouts.customer')

@section('title', 'Dashboard Pelanggan')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan</title>
    
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Riwayat Pemesanan</h1>
        @if (session('success'))
            <p class="text-green-500">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p class="text-red-500">{{ session('error') }}</p>
        @endif

        <table class="min-w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Nama Bundle</th>
                    <th class="border px-4 py-2">Harga</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="border px-4 py-2">{{ $order->bundle->nama_paket }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($order->total_harga, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $order->status }}</td>
                        <td class="border px-4 py-2">
                            @if ($order->status == 'pending')
                                <form action="{{ route('customer.cancel', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500">Batalkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('customer.order') }}" class="text-blue-500">Kembali</a>
    </div>
</body>
</html>