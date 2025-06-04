<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full mx-auto p-8">
        <h1 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3 mb-8">
            <i class="fas fa-user-edit text-indigo-500"></i>
            <span>Edit Biodata</span>
        </h1>
        <div class="bg-white shadow-2xl rounded-2xl p-8">
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-r-lg flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('anggota.biodata.update', $biodata) }}">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label for="nama_lengkap" class="block text-sm font-semibold text-indigo-900">Nama Lengkap</label>
                    <div class="mt-1 relative">
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $biodata->nama_lengkap) }}" class="p-3 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        <i class="fas fa-user absolute right-3 top-3 text-indigo-400"></i>
                    </div>
                    @error('nama_lengkap') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div class="mb-6">
                    <label for="nim" class="block text-sm font-semibold text-indigo-900">NIM</label>
                    <div class="mt-1 relative">
                        <input type="text" name="nim" id="nim" value="{{ old('nim', $biodata->nim) }}" class="p-3 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        <i class="fas fa-id-card absolute right-3 top-3 text-indigo-400"></i>
                    </div>
                    @error('nim') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div class="mb-6">
                    <label for="divisi" class="block text-sm font-semibold text-indigo-900">Divisi</label>
                    <div class="mt-1 relative">
                        <input type="text" name="divisi" id="divisi" value="{{ old('divisi', $biodata->divisi) }}" class="p-3 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        <i class="fas fa-users absolute right-3 top-3 text-indigo-400"></i>
                    </div>
                    @error('divisi') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div class="mb-6">
                    <label for="angkatan" class="block text-sm font-semibold text-indigo-900">Angkatan</label>
                    <div class="mt-1 relative">
                        <input type="text" name="angkatan" id="angkatan" value="{{ old('angkatan', $biodata->angkatan) }}" class="p-3 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        <i class="fas fa-graduation-cap absolute right-3 top-3 text-indigo-400"></i>
                    </div>
                    @error('angkatan') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div class="mb-6">
                    <label for="posisi" class="block text-sm font-semibold text-indigo-900">Posisi</label>
                    <div class="mt-1 relative">
                        <input type="text" name="posisi" id="posisi" value="{{ old('posisi', $biodata->posisi) }}" class="p-3 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        <i class="fas fa-briefcase absolute right-3 top-3 text-indigo-400"></i>
                    </div>
                    @error('posisi') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 duration-200">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </form>
        </div>
    </div>
</body>
</html>