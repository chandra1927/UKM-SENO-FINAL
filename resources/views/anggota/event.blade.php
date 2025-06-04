@extends('layouts.anggota')

@section('title', 'Jadwal Event')

@section('content')
<!-- Container utama dengan padding -->
<div class="container mx-auto p-8">
    <!-- Header -->
    <h3 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3 mb-8">
        <i class="fas fa-calendar-alt text-indigo-500"></i>
        <span>Jadwal Event</span>
    </h3>

    <!-- Table -->
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-indigo-50 text-indigo-900">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">#</th>
                        <th class="px-6 py-4 text-left font-semibold">Judul</th>
                        <th class="px-6 py-4 text-left font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold">Waktu</th>
                        <th class="px-6 py-4 text-left font-semibold">Tempat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalEvents as $index => $jadwal)
                    <tr class="border-b border-gray-100 hover:bg-indigo-50 transition duration-200">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-indigo-800">{{ $jadwal->judul }}</td>
                        <td class="px-6 py-4">{{ $jadwal->deskripsi ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $jadwal->tanggal }}</td>
                        <td class="px-6 py-4">{{ $jadwal->waktu ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $jadwal->tempat ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-500 text-lg">
                            <i class="fas fa-exclamation-circle text-gray-400 mr-2"></i>
                            Tidak ada data jadwal event.
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