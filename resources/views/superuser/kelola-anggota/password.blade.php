@extends('layouts.superuser')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Kelola Password Anggota</h1>
    <p class="text-gray-700">Silakan pilih anggota dari daftar untuk mengubah password mereka.</p>
    <a href="{{ route('superuser.anggota.index') }}" class="text-blue-600 underline mt-4 inline-block">Lihat Daftar Anggota</a>
@endsection
