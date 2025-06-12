@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-blue-500 p-6 text-white">
                <h1 class="text-2xl font-bold">Profil Anda</h1>
                <p class="opacity-90">Kelola informasi profil Anda</p>
            </div>
            
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/3 flex justify-center">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-4xl font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <button class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="md:w-2/3">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Alamat Email</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Bergabung Sejak</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ Auth::user()->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('customer.landing') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <i class="fas fa-edit mr-2"></i> Edit Profil
                            </a>
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-key mr-2"></i> Ganti Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gray-50 p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Riwayat Aktivitas</h2>
            </div>
            <div class="p-6">
                <div class="flex items-start pb-4 mb-4 border-b border-gray-100">
                    <div class="bg-purple-100 p-2 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Login terakhir</p>
                        <p class="text-sm text-gray-500">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Belum pernah login' }}</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-blue-100 p-2 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Total Pesanan</p>
                        <p class="text-sm text-gray-500">{{ Auth::user()->orders->count() }} pesanan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection