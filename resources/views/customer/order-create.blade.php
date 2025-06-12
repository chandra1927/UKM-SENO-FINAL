@extends('layouts.customer')

@section('title', 'Buat Pesanan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-xl rounded-lg p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-extrabold text-purple-900 mb-6">Buat Pesanan Baru</h1>
        
        <!-- Informasi Bundle -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-purple-600">{{ $bundle->nama_paket }}</h2>
            <p class="text-gray-600 mb-2"><strong>Deskripsi:</strong> {{ $bundle->deskripsi ?? '-' }}</p>
            <p class="text-gray-600 mb-2"><strong>Isi Paket:</strong></p>
            <ul class="list-disc list-inside mb-4 text-gray-600">
                @foreach($bundle->isi_paket as $musisi)
                    <li>{{ $musisi }}</li>
                @endforeach
            </ul>
            <p class="text-purple-800 font-bold mb-4">Harga: Rp {{ number_format($bundle->harga, 0, ',', '.') }}</p>
            
            <!-- Video Review -->
            @if ($bundle->video_path)
                <div class="mb-4">
                    <video class="w-full rounded-lg shadow-md" controls>
                        <source src="{{ asset('storage/' . $bundle->video_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                </div>
            @else
                <p class="text-gray-500 italic mb-4">Video review belum tersedia.</p>
            @endif
        </div>

        <!-- Formulir Pesanan -->
        <form action="{{ route('customer.order.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}">

            <!-- Data Pribadi -->
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-700 mb-4">Data Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-gray-700 font-semibold mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required>
                        @error('nama_lengkap')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Nomor Telepon -->
                    <div>
                        <label for="no_telepon" class="block text-gray-700 font-semibold mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required pattern="[0-9]{10,15}">
                        @error('no_telepon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-gray-700 font-semibold mb-1">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-gray-700 font-semibold mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" rows="3" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Detail Acara -->
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-700 mb-4">Detail Acara</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tanggal Acara -->
                    <div>
                        <label for="tanggal_acara" class="block text-gray-700 font-semibold mb-1">Tanggal Acara <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" value="{{ old('tanggal_acara') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required min="{{ date('Y-m-d') }}">
                        @error('tanggal_acara')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Waktu Acara -->
                    <div>
                        <label for="waktu_acara" class="block text-gray-700 font-semibold mb-1">Waktu Acara <span class="text-red-500">*</span></label>
                        <input type="time" name="waktu_acara" id="waktu_acara" value="{{ old('waktu_acara') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required>
                        @error('waktu_acara')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Lokasi Acara -->
                    <div class="md:col-span-2">
                        <label for="lokasi_acara" class="block text-gray-700 font-semibold mb-1">Lokasi Acara <span class="text-red-500">*</span></label>
                        <textarea name="lokasi_acara" id="lokasi_acara" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" rows="3" required>{{ old('lokasi_acara') }}</textarea>
                        @error('lokasi_acara')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-700 mb-4">Catatan Tambahan (Opsional)</h3>
                <textarea name="notes" id="notes" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" rows="4" placeholder="Masukkan catatan tambahan jika ada">{{ old('notes') }}</textarea>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-2"></i> Buat Pesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection