@extends('layouts.superuser')

@section('content')
<div class="container mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-indigo-900 flex items-center space-x-3">
            <i class="fas fa-calendar-alt text-indigo-500"></i>
            <span>Kelola Jadwal</span>
        </h1>
    </div>
    <p class="text-gray-600 mb-6">Halaman ini digunakan untuk mengelola data jadwal UKM.</p>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection