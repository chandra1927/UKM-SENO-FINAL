@extends('layouts.superuser')

@section('title', 'Kelola Order - Superuser Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Kelola Pesanan</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if ($orders->isEmpty())
                <p class="text-gray-500">Belum ada pesanan yang terdaftar.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Pelanggan</th>
                                <th class="py-2 px-4 border-b">Nama Paket</th>
                                <th class="py-2 px-4 border-b">Total Harga</th>
                                <th class="py-2 px-4 border-b">Tanggal Acara</th>
                                <th class="py-2 px-4 border-b">Lokasi Acara</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Catatan</th>
                                <th class="py-2 px-4 border-b">Tanggal Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->user->name ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->bundle->nama_paket ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">Rp {{ number_format($order->total_harga, 2, ',', '.') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->tanggal_acara ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->lokasi_acara ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">{{ ucfirst($order->status) }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->notes ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection