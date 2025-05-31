@extends('layouts.anggota')

@section('title', 'Jadwal Latihan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Jadwal Latihan</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border text-left">#</th>
                    <th class="px-4 py-3 border text-left">Kegiatan</th>
                    <th class="px-4 py-3 border text-left">Tanggal</th>
                    <th class="px-4 py-3 border text-left">Waktu Mulai</th>
                    <th class="px-4 py-3 border text-left">Waktu Selesai</th>
                    <th class="px-4 py-3 border text-left">Tempat</th>
                    <th class="px-4 py-3 border text-left">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalLatihans as $index => $jadwal)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->kegiatan }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->tanggal }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->waktu_mulai ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->waktu_selesai ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->tempat ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->catatan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center px-4 py-6 text-gray-500">Tidak ada data jadwal latihan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection