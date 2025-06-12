@extends('layouts.anggota')

@section('title', 'Jadwal Rapat')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-6xl mx-auto">
        <!-- Header with gradient background -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-6 text-white">
            <h1 class="text-2xl md:text-3xl font-bold">Jadwal Rapat Organisasi</h1>
            <p class="opacity-90 mt-1">Daftar lengkap agenda rapat yang akan datang</p>
        </div>
        
        <div class="p-6">
            @if($jadwalRapats->isEmpty())
                <!-- Empty state -->
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada jadwal rapat</h3>
                    <p class="mt-1 text-gray-500">Belum ada rapat yang dijadwalkan untuk saat ini.</p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agenda</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notulen</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($jadwalRapats as $index => $jadwal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">{{ $jadwal->agenda }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->tanggal }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->waktu ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->tempat ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jadwal->notulen ?? '-' }}</td>
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