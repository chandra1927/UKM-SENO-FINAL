@extends('layouts.customer')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    @auth
        <div class="bg-white shadow-xl rounded-2xl p-8 max-w-4xl mx-auto">
            <h1 class="text-3xl font-extrabold text-indigo-800 mb-4">
                Selamat Datang, {{ auth()->user()->name }}!
            </h1>
            <p class="text-gray-600 text-lg">
                Anda login sebagai <span class="font-semibold text-indigo-600">{{ auth()->user()->role ?? 'Customer' }}</span>
            </p>

            <!-- Bagian Pilih Paket -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Pilih Paket Anda</h2>
                @if($bundles->isEmpty())
                    <p class="text-gray-600">Belum ada paket tersedia saat ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($bundles as $bundle)
                            <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 hover:shadow-lg transition">
                                <h3 class="text-xl font-semibold text-indigo-600 mb-2">{{ $bundle->nama_paket }}</h3>
                                <p class="text-gray-600 mb-2"><strong>Deskripsi:</strong> {{ $bundle->deskripsi ?? '-' }}</p>
                                <p class="text-gray-600 mb-2"><strong>Isi Paket:</strong></p>
                                <ul class="list-disc list-inside mb-4 text-gray-600">
                                    @foreach($bundle->isi_paket as $musisi)
                                        <li>{{ $musisi }}</li>
                                    @endforeach
                                </ul>
                                <p class="text-gray-800 font-bold mb-4">Harga: Rp {{ number_format($bundle->harga, 0, ',', '.') }}</p>
                                
                                <!-- Video Review -->
                                @if ($bundle->video_path)
                                    <div class="mb-4">
                                        <video class="w-full rounded-lg" controls>
                                            <source src="{{ asset('storage/' . $bundle->video_path) }}" type="video/mp4">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic mb-4">Video review belum tersedia.</p>
                                @endif

                                <!-- Tombol Pemesanan -->
                                <a href="{{ route('customer.order.create', $bundle->id) }}"
                                   class="block bg-green-500 hover:bg-green-600 text-white font-semibold text-center py-3 rounded-lg transition">
                                    <i class="fas fa-shopping-cart mr-2"></i> Pesan Sekarang
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Bagian Navigasi Cepat -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Navigasi Cepat</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <a href="{{ route('customer.history') }}" class="block bg-indigo-100 hover:bg-indigo-200 text-indigo-900 font-semibold text-center py-4 rounded-xl shadow hover:shadow-md transition duration-300">
                        <i class="fas fa-history mr-2"></i> Riwayat Pemesanan
                    </a>
                    <a href="{{ route('customer.order') }}" class="block bg-green-100 hover:bg-green-200 text-green-900 font-semibold text-center py-4 rounded-xl shadow hover:shadow-md transition duration-300">
                        <i class="fas fa-shopping-cart mr-2"></i> Daftar Pesanan
                    </a>
                    <a href="{{ route('customer.payment') }}" class="block bg-yellow-100 hover:bg-yellow-200 text-yellow-900 font-semibold text-center py-4 rounded-xl shadow hover:shadow-md transition duration-300">
                        <i class="fas fa-credit-card mr-2"></i> Pembayaran
                    </a>
                    <a href="{{ route('customer.indexCustomer') }}" class="block bg-blue-100 hover:bg-blue-200 text-blue-900 font-semibold text-center py-4 rounded-xl shadow hover:shadow-md transition duration-300">
                        <i class="fas fa-user mr-2"></i> Profil Saya
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 max-w-2xl mx-auto mt-6 rounded-xl shadow">
            <p class="text-xl font-bold mb-2">Akses Ditolak</p>
            <p class="mb-3">Silakan login untuk mengakses dashboard pelanggan.</p>
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                Login sekarang
            </a>
        </div>
    @endauth
</div>
@endsection