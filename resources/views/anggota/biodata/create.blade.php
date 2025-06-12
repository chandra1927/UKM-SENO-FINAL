<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Biodata</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-6 text-white">
                <h1 class="text-2xl md:text-3xl font-bold flex items-center space-x-3">
                    <i class="fas fa-user-plus mr-2"></i>
                    <span>Buat Biodata</span>
                </h1>
            </div>
            
            <div class="p-6">
                @if (session('warning'))
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-r-lg flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('warning') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('anggota.biodata.store') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 border-gray-300 rounded-md" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </div>
                            @error('nama_lengkap') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="nim" id="nim" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 border-gray-300 rounded-md" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                </div>
                            </div>
                            @error('nim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="divisi" id="divisi" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 border-gray-300 rounded-md" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-users text-gray-400"></i>
                                </div>
                            </div>
                            @error('divisi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="angkatan" id="angkatan" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 border-gray-300 rounded-md" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-graduation-cap text-gray-400"></i>
                                </div>
                            </div>
                            @error('angkatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="posisi" class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="posisi" id="posisi" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 pr-10 py-3 border-gray-300 rounded-md" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-briefcase text-gray-400"></i>
                                </div>
                            </div>
                            @error('posisi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105 duration-200">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Biodata
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>