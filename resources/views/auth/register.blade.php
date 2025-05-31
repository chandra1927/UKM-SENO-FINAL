<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('title', 'Registrasi Anggota / Customer')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4">
    <div class="max-w-lg w-full bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Anggota / Customer</h2>

        <form method="POST" 
              action="{{ route('register.customer.submit') }}" 
              id="registerForm">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Nama Lengkap</label>
                <input id="name" type="text" name="name" required
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input id="email" type="email" name="email" required
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-medium">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="role" class="block text-gray-700 font-medium">Daftar sebagai:</label>
                <select name="role" id="role"
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="customer" selected>Customer</option>
                    <option value="anggota">Anggota</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-3 rounded-md hover:bg-blue-700 transition">
                Daftar Sekarang
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login di sini</a>
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect    = document.getElementById('role');
        const form          = document.getElementById('registerForm');
        // URL sesuai nama route di web.php
        const routeCustomer = "{{ route('register.customer.submit') }}";
        const routeAnggota  = "{{ route('register.anggota.submit') }}";

        // Set action awal
        form.action = routeCustomer;

        roleSelect.addEventListener('change', function () {
            form.action = this.value === 'anggota' ? routeAnggota : routeCustomer;
        });
    });
</script>
@endsection
