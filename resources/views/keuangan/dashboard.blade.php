<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Keuangan - UKM Seni</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen font-sans">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-blue-600">UKM Seni | Keuangan</div>
            <div>
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-blue-600 mr-4">Dashboard Umum</a>
                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    @method('POST')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto mt-10 px-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Selamat Datang, {{ Auth::user()->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-blue-600 mb-2">Total Pemasukan</h2>
                <p class="text-2xl font-bold text-gray-800">Rp 5.000.000</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-blue-600 mb-2">Total Pengeluaran</h2>
                <p class="text-2xl font-bold text-gray-800">Rp 3.200.000</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-blue-600 mb-2">Saldo Saat Ini</h2>
                <p class="text-2xl font-bold text-gray-800">Rp 1.800.000</p>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Transaksi</h2>
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
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">2025-04-01</td>
                        <td class="py-2 px-4">Donasi Mahasiswa</td>
                        <td class="py-2 px-4">Pemasukan</td>
                        <td class="py-2 px-4">Rp 1.000.000</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">2025-04-03</td>
                        <td class="py-2 px-4">Pembelian Alat Musik</td>
                        <td class="py-2 px-4">Pengeluaran</td>
                        <td class="py-2 px-4">Rp 1.200.000</td>
                    </tr>
                    <!-- Tambahkan data lainnya di sini -->
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
testing