@extends('layouts.superuser')

@section('title', 'Tambah Bundle')

@section('content')
<div class="max-w-2xl mx-auto p-8">
    <div class="bg-white shadow-2xl rounded-2xl p-8 transform transition-all duration-300 hover:shadow-xl">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-indigo-900 flex items-center space-x-3">
                <i class="fas fa-box-open text-indigo-500"></i>
                <span>Tambah Bundle Baru</span>
            </h2>
            <a href="{{ route('superuser.kelola-bundle.index') }}"
               class="text-gray-500 hover:text-gray-700 font-semibold flex items-center space-x-2 transition-transform transform hover:scale-105 duration-200">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center space-x-3">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('superuser.kelola-bundle.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Kolom ID -->
            <div>
                <label for="id" class="block mb-2 text-sm font-semibold text-indigo-900">ID Bundle</label>
                <div class="relative">
                    <input type="text" name="id" id="id"
                           class="w-full p-3 pl-10 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                           value="{{ old('id', uniqid('bundle_')) }}" disabled>
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-id-badge"></i>
                    </span>
                </div>
            </div>

            <!-- Nama Bundle -->
            <div>
                <label for="nama_bundle" class="block mb-2 text-sm font-semibold text-indigo-900">Nama Bundle</label>
                <div class="relative">
                    <input type="text" name="nama_bundle" id="nama_bundle"
                           class="w-full p-3 pl-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200"
                           value="{{ old('nama_bundle') }}" required>
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-tag"></i>
                    </span>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block mb-2 text-sm font-semibold text-indigo-900">Deskripsi</label>
                <div class="relative">
                    <textarea name="deskripsi" id="deskripsi"
                              class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 resize-y"
                              rows="5">{{ old('deskripsi') }}</textarea>
                    <span class="absolute left-3 top-4 text-gray-400">
                        <i class="fas fa-align-left"></i>
                    </span>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('superuser.kelola-bundle.index') }}"
                   class="flex items-center space-x-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-transform transform hover:scale-105 duration-200">
                    <i class="fas fa-ban"></i>
                    <span>Batal</span>
                </a>
                <button type="submit"
                        class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105 duration-200">
                    <i class="fas fa-save"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection