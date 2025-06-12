@extends('layouts.anggota')

@section('title', 'Jadwal Latihan')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold flex items-center space-x-3">
                        <i class="fas fa-dumbbell mr-2"></i>
                        <span>Jadwal Latihan</span>
                    </h1>
                    <p class="opacity-90 mt-1">Daftar jadwal latihan yang akan datang</p>
                </div>
                <a href="{{ route('anggota.jadwal.latihan') }}"
                   class="flex items-center space-x-2 bg-white text-indigo-600 font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105 duration-200 hover:bg-indigo-50">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Latihan</span>
                </a>
            </div>
        </div>
        
        <div class="p-6">
            @if($jadwalLatihans->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-dumbbell text-4xl text-gray-400 mb-4"></i>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada jadwal latihan</h3>
                    <p class="mt-1 text-gray-500">Tidak ada jadwal latihan yang tersedia saat ini.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Kegiatan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Waktu Mulai</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Waktu Selesai</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Tempat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Catatan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($jadwalLatihans as $index => $jadwal)
                                <tr class="hover:bg-indigo-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">{{ $jadwal->kegiatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->tanggal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->waktu_mulai ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->waktu_selesai ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->tempat ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->catatan ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('anggota.jadwal.latihan', $jadwal->id) }}"
                                               class="text-indigo-600 hover:text-indigo-900 transform hover:scale-110 transition duration-200"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('anggota.jadwal.latihan', $jadwal->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus latihan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transform hover:scale-110 transition duration-200"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection