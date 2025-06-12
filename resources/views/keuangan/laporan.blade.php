@extends('layouts.keuangan')

@section('title', 'Laporan Keuangan')

@section('content')
<main class="max-w-7xl mx-auto mt-10 px-6">
    <h1 class="text-3xl font-bold text-gray-700 mb-6">Laporan Keuangan</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-blue-600 mb-2">Total Pemasukan</h2>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pemasukan, 2, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-blue-600 mb-2">Total Pengeluaran</h2>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pengeluaran, 2, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-blue-600 mb-2">Saldo Saat Ini</h2>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($saldo, 2, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-blue-600 mb-4">Riwayat Transaksi</h2>
        <table class="w-full bg-white rounded-xl shadow overflow-hidden">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-left">Keterangan</th>
                    <th class="py-3 px-4 text-left">Jenis</th>
                    <th class="py-3 px-4 text-left">Jumlah</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($transactions as $transaction)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $transaction->date }}</td>
                        <td class="py-2 px-4">{{ $transaction->description }}</td>
                        <td class="py-2 px-4">{{ ucfirst($transaction->type) }}</td>
                        <td class="py-2 px-4">Rp {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection