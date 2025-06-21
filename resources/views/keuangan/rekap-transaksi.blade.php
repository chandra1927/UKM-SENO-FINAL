<!-- resources/views/keuangan/rekap-transaksi.blade.php -->
@extends('layouts.keuangan')

@section('title', 'Rekap Transaksi & Order')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <div class="bg-white shadow-xl rounded-3xl p-6 max-w-6xl mx-auto glassmorphism">
        <h1 class="text-2xl font-extrabold text-purple-900 mb-6 text-glow">Rekap Transaksi & Order</h1>

        <!-- Transactions Table -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-purple-700 mb-4 text-glow">Daftar Transaksi</h3>
            @if($transactions->isEmpty())
                <div class="bg-purple-50 p-4 rounded-2xl text-center glassmorphism">
                    <p class="text-purple-700 font-semibold text-glow">Belum ada transaksi.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-purple-200 rounded-2xl text-sm glassmorphism">
                        <thead>
                            <tr class="bg-purple-600 text-white">
                                <th class="py-3 px-4 text-center font-semibold text-glow">Tanggal</th>
                                <th class="py-3 px-4 text-center font-semibold text-glow">Deskripsi</th>
                                <th class="py-3 px-4 text-center font-semibold text-glow">Jumlah</th>
                                <th class="py-3 px-4 text-center font-semibold text-glow">Tipe</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($transactions as $transaction)
                                <tr class="border-b hover:bg-purple-50 nav-item">
                                    <td class="py-2 px-4 text-center">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                                    <td class="py-2 px-4 text-center">{{ $transaction->description }}</td>
                                    <td class="py-2 px-4 text-center">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 text-center">{{ ucfirst($transaction->type) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Orders Table -->
        <div>
            <h3 class="text-lg font-semibold text-purple-700 mb-4 text-glow">Daftar Order</h3>
            @if($orders->isEmpty())
                <div class="bg-purple-50 p-4 rounded-2xl text-center glassmorphism">
                    <p class="text-purple-700 font-semibold text-glow">Belum ada order.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-purple-200 rounded-2xl text-sm glassmorphism">
                        <thead>
                            <tr class="bg-purple-600 text-white">
                                <th class="py-3 px-4 text-center font-semibold text-glow">ID</th>
                                <th class="py-3 px-4 text-center font-semibold text-glow">Nama Paket</th>
                                <th class="py-3 px-4 text-center font-semibold text-glow">Tanggal Acara</th>
                                <th class="py-3 px-4 text-center font-semibold text-glow">Status</th>
                                <th class="py-3 px-4 text-center font-semibold text-glow">Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($orders as $order)
                                <tr class="border-b hover:bg-purple-50 nav-item">
                                    <td class="py-2 px-4 text-center">{{ $order->id }}</td>
                                    <td class="py-2 px-4 text-center">{{ $order->bundle->nama_paket }}</td>
                                    <td class="py-2 px-4 text-center">{{ \Carbon\Carbon::parse($order->tanggal_acara)->format('d/m/Y') }}</td>
                                    <td class="py-2 px-4 text-center {{ $order->status == 'success' ? 'text-green-600' : ($order->status == 'cancel' ? 'text-red-600' : 'text-yellow-600') }}">{{ ucfirst($order->status) }}</td>
                                    <td class="py-2 px-4 text-center">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection