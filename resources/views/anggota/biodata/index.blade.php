@extends('layouts.superuser')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Data Anggota</h2>

    <!-- Form Pencarian -->
    <form action="{{ route('superuser.anggota.search') }}" method="GET" class="mb-6 flex items-center">
        <input type="text" name="keyword" class="p-2 border border-gray-300 rounded-l-md w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari anggota..." value="{{ request('keyword') }}">
        <button type="submit" class="p-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 transition">Cari</button>
    </form>

    <!-- Tabel Anggota -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border text-left font-medium">ID</th>
                    <th class="px-4 py-3 border text-left font-medium">Nama Lengkap</th>
                    <th class="px-4 py-3 border text-left font-medium">NIM</th>
                    <th class="px-4 py-3 border text-left font-medium">Divisi</th>
                    <th class="px-4 py-3 border text-left font-medium">Angkatan</th>
                    <th class="px-4 py-3 border text-left font-medium">Posisi</th>
                    <th class="px-4 py-3 border text-center font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr class="hover:bg-gray-50 transition" x-data="{ showDetails: false }">
                    <td class="px-4 py-3 border">{{ $member->id }}</td>
                    <td class="px-4 py-3 border">{{ $member->biodata->nama_lengkap ?? 'Belum ada biodata' }}</td>
                    <td class="px-4 py-3 border">{{ $member->biodata->nim ?? '-' }}</td>
                    <td class="px-4 py-3 border">{{ $member->biodata->divisi ?? '-' }}</td>
                    <td class="px-4 py-3 border">{{ $member->biodata->angkatan ?? '-' }}</td>
                    <td class="px-4 py-3 border">{{ $member->biodata->posisi ?? '-' }}</td>
                    <td class="px-4 py-3 border text-center">
                        <div class="flex items-center justify-center gap-x-2">
                            <!-- Eye Icon Toggle -->
                            <button @click="showDetails = !showDetails" class="text-gray-600 hover:text-gray-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <a href="{{ route('superuser.anggota.edit', $member->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('superuser.anggota.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>

                        <!-- Modal for Additional Details -->
                        <div x-show="showDetails" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
                            <div class="bg-white rounded-lg p-6 max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Detail Anggota: {{ $member->name }}</h3>
                                    <button @click="showDetails = false" class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p><strong>ID:</strong> {{ $member->id }}</p>
                                        <p><strong>Nama:</strong> {{ $member->name }}</p>
                                        <p><strong>Email:</strong> {{ $member->email }}</p>
                                        <p><strong>Created At:</strong> {{ $member->created_at }}</p>
                                        <p><strong>Updated At:</strong> {{ $member->updated_at }}</p>
                                    </div>
                                    <div>
                                        <p><strong>Nama Lengkap:</strong> {{ $member->biodata->nama_lengkap ?? 'Belum ada' }}</p>
                                        <p><strong>NIM:</strong> {{ $member->biodata->nim ?? '-' }}</p>
                                        <p><strong>Divisi:</strong> {{ $member->biodata->divisi ?? '-' }}</p>
                                        <p><strong>Angkatan:</strong> {{ $member->biodata->angkatan ?? '-' }}</p>
                                        <p><strong>Posisi:</strong> {{ $member->biodata->posisi ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">Data anggota tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Include Alpine.js for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
    [x-cloak] { display: none; }
</style>
@endsection