@extends('layouts.anggota')

@section('title', 'Jadwal Event')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-6 text-white">
            <h1 class="text-2xl md:text-3xl font-bold flex items-center space-x-3">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>Jadwal Event</span>
            </h1>
            <p class="opacity-90 mt-1">Daftar semua event yang akan datang</p>
        </div>
        
        <div class="p-6">
            @if($jadwalEvents->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-calendar-day text-4xl text-gray-400 mb-4"></i>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada jadwal event</h3>
                    <p class="mt-1 text-gray-500">Tidak ada jadwal event yang tersedia saat ini.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Judul</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Waktu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Tempat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($jadwalEvents as $index => $jadwal)
                                <tr class="hover:bg-indigo-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">{{ $jadwal->judul }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $jadwal->deskripsi ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->tanggal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->waktu ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->tempat ?? '-' }}</td>
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