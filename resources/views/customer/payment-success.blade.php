@extends('layouts.customer')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-6 rounded relative max-w-2xl mx-auto">
        <strong class="font-bold text-xl">Pembayaran Berhasil!</strong>
        <p class="block mt-2">Terima kasih telah melakukan pembayaran. Pesanan Anda sedang diproses.</p>
        <a href="{{ route('customer.order') }}"
           class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg">
            Lihat Riwayat Pesanan
        </a>
    </div>
</div>
@endsection
