@extends('layouts.superuser')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, {{ Auth::user()->name }}</h1>
    <p class="text-gray-600">Silakan pilih menu di sidebar untuk mengelola data.</p>
@endsection
