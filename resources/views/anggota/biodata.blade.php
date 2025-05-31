<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Anggota - UKM Seni</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Biodata Anggota</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="text-lg text-gray-800">Selamat datang, {{ auth()->user()->name }}! Berikut adalah biodata Anda:</p>
            <div class="mt-4">
                <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <!-- Tambahkan field lain sesuai kebutuhan, misalnya NIM atau jurusan -->
                <p><strong>Status:</strong> Anggota Aktif</p>
            </div>
            <a href="{{ route('anggota.profile') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Kembali ke Profil</a>
        </div>
    </div>
</body>
</html>