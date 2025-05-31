@extends('layouts.anggota')

@section('title', 'Dashboard Anggota')

@section('content')
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600">Silakan pilih menu di sidebar untuk melihat jadwal kegiatan UKM Seni.</p>
    </div>
@endsection
