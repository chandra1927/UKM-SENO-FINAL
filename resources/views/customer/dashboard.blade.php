@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-xl font-bold">Selamat datang, {{ auth()->user()->name }}</h1>
    <p class="text-gray-600">Anda login sebagai <strong>{{ auth()->user()->role }}</strong></p>
</div>
@endsection
