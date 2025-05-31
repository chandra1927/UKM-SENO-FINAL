<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Biodata</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Buat Biodata</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if (session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                    {{ session('warning') }}
                </div>
            @endif
            <form method="POST" action="{{ route('anggota.biodata.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="mt-1 p-2 border rounded w-full" required>
                    @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" name="nim" id="nim" class="mt-1 p-2 border rounded w-full" required>
                    @error('nim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                    <input type="text" name="divisi" id="divisi" class="mt-1 p-2 border rounded w-full" required>
                    @error('divisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                    <input type="text" name="angkatan" id="angkatan" class="mt-1 p-2 border rounded w-full" required>
                    @error('angkatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label for="posisi" class="block text-sm font-medium text-gray-700">Posisi</label>
                    <input type="text" name="posisi" id="posisi" class="mt-1 p-2 border rounded w-full" required>
                    @error('posisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>