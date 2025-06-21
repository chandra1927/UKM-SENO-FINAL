@extends('layouts.customer')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container mx-auto mt-10 px-4 text-center">
    <h1 class="text-2xl font-bold text-green-600">✅ Pembayaran Berhasil</h1>
    <p class="mt-4">Terima kasih! Pesanan Anda sudah kami terima dan pembayaran berhasil.</p>
    <a href="{{ route('customer.order') }}" class="mt-6 inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">Lihat Pesanan</a>
</div>
@endsection
