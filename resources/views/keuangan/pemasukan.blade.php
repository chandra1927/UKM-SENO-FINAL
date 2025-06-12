@extends('layouts.keuangan')

@section('title', 'Pemasukan')

@section('content')
<main class="max-w-7xl mx-auto mt-10 px-6">
    <h1 class="text-3xl font-bold text-gray-700 mb-6">Pemasukan</h1>

    <!-- Form Tambah Pemasukan -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold text-blue-600 mb-4">Tambah Pemasukan</h2>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('keuangan.pemasukan.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <input type="text" name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                    <input type="number" name="amount" id="amount" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">Simpan</button>
        </form>
    </div>

    <!-- Tabel Pemasukan -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-blue-600 mb-4">Daftar Pemasukan</h2>
        <table class="w-full bg-white rounded-xl shadow overflow-hidden">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-left">Keterangan</th>
                    <th class="py-3 px-4 text-left">Jumlah</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($transactions as $transaction)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $transaction->date }}</td>
                        <td class="py-2 px-4">{{ $transaction->description }}</td>
                        <td class="py-2 px-4">Rp {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection