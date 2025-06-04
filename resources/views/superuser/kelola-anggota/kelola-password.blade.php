@extends('layouts.superuser')

@section('title', 'Kelola Password Anggota - Superuser Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-indigo-900 mb-6">Kelola Password Anggota</h1>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (empty($members) || $members->isEmpty())
                <p class="text-gray-500">Belum ada anggota yang terdaftar.</p>
            @else
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Nama</th>
                            <th class="py-2 px-4 border-b">Email</th>
                            <th class="py-2 px-4 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $member->email }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('superuser.anggota.edit-password', $member->id) }}" class="text-blue-600 hover:underline">Edit Password</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="mt-4">
                <a href="{{ route('superuser.kelola-anggota.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Kembali</a>
            </div>
        </div>
    </div>
@endsection