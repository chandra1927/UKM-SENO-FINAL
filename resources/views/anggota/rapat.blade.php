@extends('layouts.anggota')

@section('title', 'Jadwal Rapat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Jadwal Rapat</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border text-left">#</th>
                    <th class="px-4 py-3 border text-left">Agenda</th>
                    <th class="px-4 py-3 border text-left">Tanggal</th>
                    <th class="px-4 py-3 border text-left">Waktu</th>
                    <th class="px-4 py-3 border text-left">Tempat</th>
                    <th class="px-4 py-3 border text-left">Notulen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalRapats as $index => $jadwal)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->agenda }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->tanggal }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->waktu ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->tempat ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $jadwal->notulen ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center px-4 py-6 text-gray-500">Tidak ada data jadwal rapat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection