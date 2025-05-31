@extends('layouts.app')

@section('title', 'Tambah Biodata')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Biodata Anggota</h1>

<form action="{{ route('biodata.store') }}" method="POST" class="bg-white shadow rounded p-6 space-y-4">
    @csrf
    @include('biodata.form')
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
