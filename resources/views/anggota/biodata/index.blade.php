<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full mx-auto p-8">
        <h1 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3 mb-8">
            <i class="fas fa-user text-indigo-500"></i>
            <span>Biodata Anggota</span>
        </h1>
        <div class="bg-white shadow-2xl rounded-2xl p-8">
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-r-lg flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-6 rounded-r-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('warning') }}
                </div>
            @endif

            @if ($biodata)
                <div class="space-y-4">
                    <p class="flex items-center text-gray-700"><i class="fas fa-user mr-2 text-indigo-500"></i><strong class="w-24">Nama Lengkap:</strong> {{ $biodata->nama_lengkap }}</p>
                    <p class="flex items-center text-gray-700"><i class="fas fa-id-card mr-2 text-indigo-500"></i><strong class="w-24">NIM:</strong> {{ $biodata->nim }}</p>
                    <p class="flex items-center text-gray-700"><i class="fas fa-users mr-2 text-indigo-500"></i><strong class="w-24">Divisi:</strong> {{ $biodata->divisi }}</p>
                    <p class="flex items-center text-gray-700"><i class="fas fa-graduation-cap mr-2 text-indigo-500"></i><strong class="w-24">Angkatan:</strong> {{ $biodata->angkatan }}</p>
                    <p class="flex items-center text-gray-700"><i class="fas fa-briefcase mr-2 text-indigo-500"></i><strong class="w-24">Posisi:</strong> {{ $biodata->posisi }}</p>
                    <a href="{{ route('anggota.biodata.edit', $biodata) }}" class="mt-6 inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 duration-200">
                        Edit Biodata
                    </a>
                </div>
            @else
                <p class="text-gray-600 text-center text-lg">
                    <i class="fas fa-exclamation-circle text-gray-400 mr-2"></i>
                    Biodata belum diisi. 
                    <a href="{{ route('anggota.biodata.create') }}" class="text-indigo-600 hover:underline">Isi sekarang</a>.
                </p>
            @endif
        </div>
    </div>
</body>
</html>