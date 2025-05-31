@extends('layouts.superuser')

@section('title', 'Kelola Bundle')

@section('content')
<div class="container mx-auto p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3">
            <i class="fas fa-boxes text-indigo-500"></i>
            <span>Kelola Bundle</span>
        </h3>
        <a href="{{ route('superuser.kelola-bundle.create') }}"
           class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105 duration-200">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Bundle</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-indigo-50 text-indigo-900">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">#</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Bundle</th>
                        <th class="px-6 py-4 text-left font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bundles as $index => $bundle)
                    <tr class="border-b border-gray-100 hover:bg-indigo-50 transition duration-200">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-indigo-800">{{ $bundle->nama_bundle }}</td>
                        <td class="px-6 py-4">{{ $bundle->deskripsi }}</td>
                        <td class="px-6 py-4">{{ $bundle->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center flex justify-center space-x-3">
                            <!-- Tombol Lihat -->
                            <a href="{{ route('superuser.kelola-bundle.index', $bundle->id) }}"
                               class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition duration-200"
                               title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <!-- Tombol Edit -->
                            <a href="{{ route('superuser.kelola-bundle.edit', $bundle->id) }}"
                               class="text-yellow-500 hover:text-yellow-600 transform hover:scale-110 transition duration-200"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('superuser.kelola-bundle.destroy', $bundle->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus bundle ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-500 hover:text-red-700 transform hover:scale-110 transition duration-200"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 text-lg">
                            <i class="fas fa-exclamation-circle text-gray-400 mr-2"></i>
                            Tidak ada data bundle.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection