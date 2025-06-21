@extends('layouts.customer')

@section('title', 'Pembayaran Gagal')

@section('content')
<div class="container mx-auto mt-10 px-4 text-center">
    <h1 class="text-2xl font-bold text-red-600">❌ Pembayaran Gagal</h1>
    <p class="mt-4">Maaf, terjadi kesalahan saat pembayaran. Silakan coba lagi.</p>
    <a href="{{ route('customer.order') }}" class="mt-6 inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">Coba Lagi</a>
</div>
@endsection
