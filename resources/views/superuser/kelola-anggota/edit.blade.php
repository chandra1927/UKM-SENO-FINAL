@extends('layouts.superuser')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Ubah Password: {{ $anggota->name }}</h1>

    <form action="{{ route('superuser.anggota.password.update', $anggota->id) }}" method="POST" class="w-1/2">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Password Baru</label>
            <input type="password" name="password" required class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Update Password</button>
        <a href="{{ route('superuser.anggota.index') }}" class="ml-2 text-blue-600">Kembali</a>
    </form>
@endsection


testing