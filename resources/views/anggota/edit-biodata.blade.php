@extends('layouts.app')

@section('title', 'Edit Biodata')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Biodata Anggota</h1>

<form action="{{ route('biodata.update', $biodata->id) }}" method="POST" class="bg-white shadow rounded p-6 space-y-4">
    @csrf
    @method('PUT')
    @include('biodata.form', ['biodata' => $biodata])
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
