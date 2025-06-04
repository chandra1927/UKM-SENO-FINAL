@extends('layouts.customer')

@section('title', 'Buat Pesanan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Buat Pesanan Baru</h1>
        
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-indigo-600">{{ $bundle->nama_paket }}</h2>
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
        </div>

        <form action="{{ route('customer.order.store') }}" method="POST">
            @csrf
            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}">
            
            <div class="mb-4">
                <label for="notes" class="block text-gray-700 font-semibold mb-2">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" class="w-full border border-gray-300 rounded-lg p-3" rows="4" placeholder="Masukkan catatan tambahan jika ada"></textarea>
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                <i class="fas fa-shopping-cart mr-2"></i> Buat Pesanan
            </button>
        </form>
    </div>
</div>
@endsection