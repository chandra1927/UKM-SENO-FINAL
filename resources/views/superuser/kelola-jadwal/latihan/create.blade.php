@extends('layouts.superuser')

@section('title', 'Tambah Jadwal Latihan')

@section('content')
<div class="container mx-auto p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h3 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3">
            <i class="fas fa-dumbbell text-indigo-500"></i>
            <span>Tambah Jadwal Latihan</span>
        </h3>
        <a href="{{ route('superuser.jadwal.latihan.index') }}"
           class="flex items-center space-x-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-transform transform hover:scale-105 duration-200">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('superuser.jadwal.latihan.store') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-2xl max-w-2xl mx-auto">
        @csrf
        <div class="space-y-6">
            <!-- Kegiatan -->
            <div>
                <label for="kegiatan" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-running text-indigo-500 mr-2"></i>Kegiatan
                </label>
                <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan') }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('kegiatan') ? 'border-red-500' : '' }}"
                       placeholder="Masukkan nama kegiatan" required>
                @error('kegiatan')
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
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('tanggal') ? 'border-red-500' : '' }}"
                       required>
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Waktu Mulai -->
            <div>
                <label for="waktu_mulai" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-clock text-indigo-500 mr-2"></i>Waktu Mulai
                </label>
                <input type="text" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('waktu_mulai') ? 'border-red-500' : '' }}"
                       placeholder="Contoh: 14:00">
                @error('waktu_mulai')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Waktu Selesai -->
            <div>
                <label for="waktu_selesai" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-clock text-indigo-500 mr-2"></i>Waktu Selesai
                </label>
                <input type="text" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('waktu_selesai') ? 'border-red-500' : '' }}"
                       placeholder="Contoh: 16:00">
                @error('waktu_selesai')
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
                <input type="text" name="tempat" id="tempat" value="{{ old('tempat') }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('tempat') ? 'border-red-500' : '' }}"
                       placeholder="Masukkan tempat latihan">
                @error('tempat')
                    <p class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Catatan -->
            <div>
                <label for="catatan" class="block text-indigo-900 font-semibold mb-2">
                    <i class="fas fa-align-left text-indigo-500 mr-2"></i>Catatan
                </label>
                <textarea name="catatan" id="catatan"
                          class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 {{ $errors->has('catatan') ? 'border-red-500' : '' }}"
                          placeholder="Masukkan catatan (opsional)" rows="5">{{ old('catatan') }}</textarea>
                @error('catatan')
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
                <a href="{{ route('superuser.jadwal.latihan.index') }}"
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