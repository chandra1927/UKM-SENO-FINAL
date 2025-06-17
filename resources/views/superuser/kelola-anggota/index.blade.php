@extends('layouts.superuser')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    :root {
        --purple-dark: #2d1b69;
        --purple-primary: #3730a3;
        --purple-light: #4c1d95;
        --purple-accent: #6366f1;
        --purple-glow: rgba(99, 102, 241, 0.3);
        --btn-red: #dc2626;
        --btn-red-hover: #b91c1c;
    }
    * {
        font-family: 'Inter', sans-serif;
    }
    .content-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .input-field {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    .input-field:focus {
        outline: none;
        border-color: var(--purple-accent);
        box-shadow: 0 0 10px var(--purple-glow);
    }
    .btn-primary {
        background: var(--purple-accent);
        color: white;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: var(--purple-light);
        transform: scale(1.05);
        box-shadow: 0 8px 25px var(--purple-glow);
    }
    .btn-blue {
        background: var(--purple-primary);
        color: white;
        transition: all 0.3s ease;
    }
    .btn-blue:hover {
        background: var(--purple-dark);
        transform: scale(1.05);
    }
    .btn-red {
        color: var(--btn-red);
        transition: all 0.3s ease;
    }
    .btn-red:hover {
        color: var(--btn-red-hover);
    }
    .text-glow {
        text-shadow: 0 0 15px var(--purple-glow);
    }
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 10px var(--purple-glow); }
        50% { box-shadow: 0 0 20px var(--purple-glow); }
    }
    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }
    [x-cloak] { display: none; }
</style>

<div class="max-w-7xl mx-auto py-10 px-6">
    <div class="content-card p-8" data-aos="fade-up" data-aos-duration="800">
        <h2 class="text-2xl md:text-3xl font-semibold mb-6 text-purple-dark text-glow">Data Anggota</h2>

        <!-- Form Pencarian -->
        <form action="{{ route('superuser.anggota.search') }}" method="GET" class="mb-6 flex items-center space-x-2" data-aos="fade-up" data-aos-duration="1000">
            <div class="relative flex-1 sm:w-1/3">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-light"></i>
                <input type="text" name="keyword" class="input-field w-full pl-10 pr-4 py-2 rounded-lg" placeholder="Cari anggota..." value="{{ request('keyword') }}">
            </div>
            <button type="submit" class="btn-primary px-4 py-2 rounded-lg font-semibold pulse-glow">Cari</button>
        </form>

        <!-- Tabel Anggota -->
        <div class="overflow-x-auto rounded-lg border border-gray-200" data-aos="fade-up" data-aos-duration="1200">
            <table class="min-w-full text-sm">
                <thead class="bg-purple-50 text-purple-dark">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">ID</th>
                        <th class="px-6 py-3 text-left font-semibold">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left font-semibold">NIM</th>
                        <th class="px-6 py-3 text-left font-semibold">Divisi</th>
                        <th class="px-6 py-3 text-left font-semibold">Angkatan</th>
                        <th class="px-6 py-3 text-left font-semibold">Posisi</th>
                        <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr class="hover:bg-purple-50 transition" x-data="{ showDetails: false }">
                        <td class="px-6 py-3 border-b">{{ $member->id }}</td>
                        <td class="px-6 py-3 border-b">{{ $member->biodata->nama_lengkap ?? 'Belum ada biodata' }}</td>
                        <td class="px-6 py-3 border-b">{{ $member->biodata->nim ?? '-' }}</td>
                        <td class="px-6 py-3 border-b">{{ $member->biodata->divisi ?? '-' }}</td>
                        <td class="px-6 py-3 border-b">{{ $member->biodata->angkatan ?? '-' }}</td>
                        <td class="px-6 py-3 border-b">{{ $member->biodata->posisi ?? '-' }}</td>
                        <td class="px-6 py-3 border-b text-center">
                            <div class="flex items-center justify-center gap-x-3">
                                <button @click="showDetails = !showDetails" class="text-purple-light hover:text-purple-accent transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('superuser.anggota.edit', $member->id) }}" class="btn-blue hover:underline">Edit</a>
                                <form action="{{ route('superuser.anggota.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-red hover:underline">Hapus</button>
                                </form>
                            </div>
                            <!-- Modal Details -->
                            <div x-show="showDetails" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
                                <div class="content-card p-6 max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold text-purple-dark">Detail Anggota: {{ $member->name }}</h3>
                                        <button @click="showDetails = false" class="text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-times w-6 h-6"></i>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Data anggota tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@endsection