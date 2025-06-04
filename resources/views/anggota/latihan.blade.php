@extends('layouts.anggota')

@section('title', 'Jadwal Latihan')

@section('content')
<!-- Container utama dengan padding -->
<div class="container mx-auto p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3">
            <i class="fas fa-dumbbell text-indigo-500"></i>
            <span>Jadwal Latihan</span>
        </h3>
        <a href="{{ route('anggota.jadwal.latihan') }}"
           class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105 duration-200">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Latihan</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-indigo-50 text-indigo-900">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">#</th>
                        <th class="px-6 py-4 text-left font-semibold">Kegiatan</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Waktu Mulai</th>
                        <th class="px-6 py-4 text-left font-semibold">Waktu Selesai</th>
                        <th class="px-6 py-4 text-left font-semibold">Tempat</th>
                        <th class="px-6 py-4 text-left font-semibold">Catatan</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalLatihans as $index => $jadwal)
                    <tr class="border-b border-gray-100 hover:bg-indigo-50 transition duration-200">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-indigo-800">{{ $jadwal->kegiatan }}</td>
                        <td class="px-6 py-4">{{ $jadwal->tanggal }}</td>
                        <td class="px-6 py-4">{{ $jadwal->waktu_mulai ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $jadwal->waktu_selesai ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $jadwal->tempat ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $jadwal->catatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center flex justify-center space-x-3">
                            <!-- Tombol Edit -->
                            <a href="{{ route('anggota.jadwal.latihan', $jadwal->id) }}"
                               class="text-yellow-500 hover:text-yellow-600 transform hover:scale-110 transition duration-200"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('anggota.jadwal.latihan', $jadwal->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus latihan ini?');">
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
                        <td colspan="8" class="px-6 py-6 text-center text-gray-500 text-lg">
                            <i class="fas fa-exclamation-circle text-gray-400 mr-2"></i>
                            Tidak ada data jadwal latihan.
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