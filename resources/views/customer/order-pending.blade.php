@extends('layouts.customer')

@section('title', 'Pembayaran Pending')

@section('content')
<div class="container mx-auto mt-10 px-4 text-center">
    <h1 class="text-2xl font-bold text-yellow-600">⏳ Pembayaran Menunggu</h1>
    <p class="mt-4">Pembayaran Anda sedang menunggu konfirmasi. Silakan cek status nanti.</p>
    <a href="{{ route('customer.order') }}" class="mt-6 inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg">Lihat Pesanan</a>
</div>
@endsection
