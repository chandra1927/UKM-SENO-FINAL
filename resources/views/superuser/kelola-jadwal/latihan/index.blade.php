@extends('layouts.superuser')

@section('title', 'Kelola Jadwal Latihan')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-500 p-6 text-white">
            <h1 class="text-2xl md:text-3xl font-bold">Kelola Jadwal Latihan</h1>
            <p class="opacity-90 mt-1">Daftar semua jadwal latihan yang tersedia</p>
        </div>
        
        <div class="p-6">
            <div class="mb-4">
                <a href="{{ route('superuser.jadwal.latihan.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Tambah Jadwal
                </a>
            </div>

            @if($jadwalLatihans->isEmpty())
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada jadwal latihan</h3>
                    <p class="mt-1 text-gray-500">Tidak ada jadwal latihan yang tersedia.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
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
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($jadwalLatihans as $index => $jadwal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-medium text-indigo-800">{{ $jadwal->kegiatan }}</td>
                                    <td class="px-6 py-4">{{ $jadwal->tanggal }}</td>
                                    <td class="px-6 py-4">{{ $jadwal->waktu_mulai ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $jadwal->waktu_selesai ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $jadwal->tempat ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $jadwal->catatan ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center flex justify-center space-x-3">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('superuser.jadwal.latihan.edit', $jadwal->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="{{ route('superuser.jadwal.latihan.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
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