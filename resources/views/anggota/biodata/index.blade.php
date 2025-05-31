<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Biodata Anggota</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                    {{ session('warning') }}
                </div>
            @endif

            @if ($biodata)
                <div class="mt-4">
                    <p><strong>Nama Lengkap:</strong> {{ $biodata->nama_lengkap }}</p>
                    <p><strong>NIM:</strong> {{ $biodata->nim }}</p>
                    <p><strong>Divisi:</strong> {{ $biodata->divisi }}</p>
                    <p><strong>Angkatan:</strong> {{ $biodata->angkatan }}</p>
                    <p><strong>Posisi:</strong> {{ $biodata->posisi }}</p>
                    <a href="{{ route('anggota.biodata.edit', $biodata) }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit Biodata</a>
                </div>
            @else
                <p class="text-gray-600">Biodata belum diisi. <a href="{{ route('anggota.biodata.create') }}" class="text-indigo-600 hover:underline">Isi sekarang</a>.</p>
            @endif
        </div>
    </div>
</body>
</html>