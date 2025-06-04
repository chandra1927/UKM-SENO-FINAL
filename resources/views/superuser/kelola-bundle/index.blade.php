@extends('layouts.superuser')

@section('title', 'Kelola Bundle - Superuser Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Kelola Bundle Ulang</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <a href="{{ route('superuser.kelola-bundle.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Tambah Bundle</a>
            </div>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if ($bundles->isEmpty())
                <p class="text-gray-500">Belum ada bundle yang terdaftar.</p>
            @else
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Nama Paket</th>
                            <th class="py-2 px-4 border-b">Isi Paket</th>
                            <th class="py-2 px-4 border-b">Deskripsi</th>
                            <th class="py-2 px-4 border-b">Harga</th>
                            <th class="py-2 px-4 border-b">Video</th>
                            <th class="py-2 px-4 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bundles as $bundle)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $bundle->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $bundle->nama_paket }}</td>
                                <td class="py-2 px-4 border-b">
                                    @foreach ($bundle->isi_paket as $musisi)
                                        {{ $musisi }}<br>
                                    @endforeach
                                </td>
                                <td class="py-2 px-4 border-b">{{ $bundle->deskripsi ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">Rp {{ number_format($bundle->harga, 2, ',', '.') }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if ($bundle->video_path)
                                        <video class="w-32 h-18 rounded" controls>
                                            <source src="{{ asset('storage/' . $bundle->video_path) }}" type="video/mp4">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @else
                                        <span class="text-gray-500">Tidak ada video</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('superuser.kelola-bundle.edit', $bundle->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('superuser.kelola-bundle.destroy', $bundle->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Apakah Anda yakin ingin menghapus bundle ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection