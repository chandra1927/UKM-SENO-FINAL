@extends('layouts.superuser')

@section('title', 'Edit Jadwal Rapat')

@section('content')
<div class="container mx-auto p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3">
            <i class="fas fa-users text-indigo-500"></i>
            <span>Edit Jadwal Rapat</span>
        </h3>
        <a href="{{ route('superuser.jadwal.rapat.index') }}"
           class="flex items-center space-x-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105 duration-200">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('superuser.jadwal.rapat.update', $jadwalRapat->id) }}" method="POST" class="bg-white p-8 rounded-2xl shadow-2xl max-w-2xl mx-auto">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <!-- Agenda -->
            <div>
                <label for="agenda" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-list text-indigo-500 mr-2"></i>Agenda
                </label>
                <input type="text" name="agenda" id="agenda" value="{{ old('agenda', $jadwalRapat->agenda) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('agenda') ? 'border-red-500' : '' }}"
                       placeholder="Masukkan agenda rapat" required>
                @error('agenda')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label for="tanggal" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>Tanggal
                </label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $jadwalRapat->tanggal) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('tanggal') ? 'border-red-500' : '' }}"
                       required>
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Waktu -->
            <div>
                <label for="waktu" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-clock text-indigo-500 mr-2"></i>Waktu
                </label>
                <input type="text" name="waktu" id="waktu" value="{{ old('waktu', $jadwalRapat->waktu) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('waktu') ? 'border-red-500' : '' }}"
                       placeholder="Contoh: 14:00">
                @error('waktu')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tempat -->
            <div>
                <label for="tempat" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>Tempat
                </label>
                <input type="text" name="tempat" id="tempat" value="{{ old('tempat', $jadwalRapat->tempat) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('tempat') ? 'border-red-500' : '' }}"
                       placeholder="Masukkan tempat rapat">
                @error('tempat')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Notulen -->
            <div>
                <label for="notulen" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-align-left text-indigo-500 mr-2"></i>Notulen
                </label>
                <textarea name="notulen" id="notulen"
                          class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('notulen') ? 'border-red-500' : '' }}"
                          placeholder="Masukkan notulen (opsional)" rows="5">{{ old('notulen', $jadwalRapat->notulen) }}</textarea>
                @error('notulen')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4 pt-4">
                <button type="submit"
                        class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-transform transform hover:scale-105 duration-200">
                    <i class="fas fa-save"></i>
                    <span>Simpan</span>
                </button>
                <a href="{{ route('superuser.jadwal.rapat.index') }}"
                   class="flex items-center space-x-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-transform transform hover:scale-105 duration-200">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
            </div>
        </div>
    </form>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection