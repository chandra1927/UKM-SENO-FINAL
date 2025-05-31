{{-- resources/views/superuser/kelola-bundle/edit.blade.php --}}
@extends('layouts.superuser')

@section('title', 'Edit Bundle')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Edit Bundle</h2>

    <form action="{{ route('superuser.kelola-bundle.update', $bundle->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Bundle</label>
            <input type="text" name="nama_bundle" class="w-full border p-2 rounded" value="{{ $bundle->nama_bundle }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="deskripsi" class="w-full border p-2 rounded" rows="4">{{ $bundle->deskripsi }}</textarea>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('superuser.kelola-bundle.index') }}" class="text-gray-600">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
        </div>
    </form>
</div>
@endsection
