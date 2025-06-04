@extends('layouts.superuser')

@section('title', 'Edit Bundle - Superuser Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Edit Bundle Ulang</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superuser.kelola-bundle.update', $bundle->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="nama_paket" class="block text-gray-700 font-semibold mb-2">Nama Paket</label>
                    <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket', $bundle->nama_paket) }}" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="mb-4">
                    <label for="isi_paket" class="block text-gray-700 font-semibold mb-2">Isi Paket (Pilih Musisi/Anggota)</label>
                    @if (empty($members) || $members->isEmpty())
                        <p class="text-red-500 text-sm">Belum ada anggota yang tersedia. Silakan tambahkan anggota terlebih dahulu.</p>
                    @else
                        <select name="isi_paket[]" id="isi_paket" multiple class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            @foreach ($members as $member)
                                <option value="{{ $member->name }}" {{ in_array($member->name, $bundle->isi_paket) ? 'selected' : '' }}>{{ $member->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-gray-500 text-sm mt-1">Tahan Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu musisi/anggota.</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $bundle->deskripsi) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="harga" class="block text-gray-700 font-semibold mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga', $bundle->harga) }}" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" step="0.01" required>
                </div>

                <div class="mb-4">
                    <label for="video" class="block text-gray-700 font-semibold mb-2">Video Review (MP4, maks 20MB)</label>
                    <input type="file" name="video" id="video" accept="video/mp4" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @if ($bundle->video_path)
                        <p class="text-gray-500 text-sm mt-1">Video saat ini:</p>
                        <video class="w-32 h-18 rounded mt-2" controls>
                            <source src="{{ asset('storage/' . $bundle->video_path) }}" type="video/mp4">
                            Browser Anda tidak mendukung pemutaran video.
                        </video>
                    @endif
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Simpan</button>
                    <a href="{{ route('superuser.kelola-bundle.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection