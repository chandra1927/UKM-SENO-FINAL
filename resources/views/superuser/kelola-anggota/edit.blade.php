<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Edit Data Anggota</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!$member)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    Anggota tidak ditemukan.
                </div>
            @else
                <form method="POST" action="{{ route('superuser.anggota.update', $member->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}" class="mt-1 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}" class="mt-1 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Nama Lengkap (dari Biodata) -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $member->biodata->nama_lengkap ?? '') }}" class="mt-1 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- NIM (dari Biodata) -->
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" name="nim" id="nim" value="{{ old('nim', $member->biodata->nim ?? '') }}" class="mt-1 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Divisi (dari Biodata) -->
                    <div>
                        <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                        <input type="text" name="divisi" id="divisi" value="{{ old('divisi', $member->biodata->divisi ?? '') }}" class="mt-1 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Angkatan (dari Biodata) -->
                    <div>
                        <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                        <input type="text" name="angkatan" id="angkatan" value="{{ old('angkatan', $member->biodata->angkatan ?? '') }}" class="mt-1 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Posisi (dari Biodata) -->
                    <div>
                        <label for="posisi" class="block text-sm font-medium text-gray-700">Posisi</label>
                        <input type="text" name="posisi" id="posisi" value="{{ old('posisi', $member->biodata->posisi ?? '') }}" class="mt-1 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Simpan Perubahan</button>
                        <a href="{{ route('superuser.kelola-anggota.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Kembali</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</body>
</html>