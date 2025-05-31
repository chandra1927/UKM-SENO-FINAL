@extends('layouts.anggota')

@section('title', 'Isi Biodata')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Isi Biodata</h2>

    @if(session('warning'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
            {{ session('warning') }}
        </div>
    @endif

    <form action="{{ route('anggota.biodata.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="nama_lengkap" class="block text-gray-600 font-semibold">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}"
                       class="w-full border rounded px-3 py-2 mt-1 @error('nama_lengkap') border-red-500 @enderror">
                @error('nama_lengkap')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="nim" class="block text-gray-600 font-semibold">NIM</label>
                <input type="text" name="nim" id="nim" value="{{ old('nim') }}"
                       class="w-full border rounded px-3 py-2 mt-1 @error('nim') border-red-500 @enderror">
                @error('nim')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="divisi" class="block text-gray-600 font-semibold">Divisi</label>
                <input type="text" name="divisi" id="divisi" value="{{ old('divisi') }}"
                       class="w-full border rounded px-3 py-2 mt-1 @error('divisi') border-red-500 @enderror">
                @error('divisi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="angkatan" class="block text-gray-600 font-semibold">Angkatan</label>
                <input type="text" name="angkatan" id="angkatan" value="{{ old('angkatan') }}"
                       class="w-full border rounded px-3 py-2 mt-1 @error('angkatan') border-red-500 @enderror">
                @error('angkatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="posisi" class="block text-gray-600 font-semibold">Posisi</label>
                <input type="text" name="posisi" id="posisi" value="{{ old('posisi') }}"
                       class="w-full border rounded px-3 py-2 mt-1 @error('posisi') border-red-500 @enderror">
                @error('posisi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Simpan Biodata
            </button>
        </div>
    </form>
</div>
@endsection