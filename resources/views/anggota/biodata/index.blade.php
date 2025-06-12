<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-2xl mx-auto">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-6 text-white">
                <h1 class="text-2xl md:text-3xl font-bold flex items-center space-x-3">
                    <i class="fas fa-user mr-2"></i>
                    <span>Biodata Anggota</span>
                </h1>
            </div>
            
            <div class="p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-r-lg flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('warning'))
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-r-lg flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('warning') }}
                    </div>
                @endif

                @if ($biodata)
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-indigo-600 mb-3 flex items-center">
                                <i class="fas fa-id-card mr-2"></i>
                                Informasi Pribadi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                                    <p class="font-medium">{{ $biodata->nama_lengkap }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">NIM</p>
                                    <p class="font-medium">{{ $biodata->nim }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Angkatan</p>
                                    <p class="font-medium">{{ $biodata->angkatan }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-indigo-600 mb-3 flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                Informasi Organisasi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Divisi</p>
                                    <p class="font-medium">{{ $biodata->divisi }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Posisi</p>
                                    <p class="font-medium">{{ $biodata->posisi }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <a href="{{ route('anggota.biodata.edit', $biodata) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Biodata
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-user-slash text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900">Biodata belum diisi</h3>
                        <p class="mt-2 text-gray-500 mb-6">Anda belum mengisi biodata. Silakan isi biodata Anda sekarang.</p>
                        <a href="{{ route('anggota.biodata.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 duration-200">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Isi Biodata
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>