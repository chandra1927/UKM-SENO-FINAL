<!-- resources/views/superuser/sidebar.blade.php -->

<aside class="w-64 bg-white shadow h-screen sticky top-0">
    <div class="p-6">
        <h2 class="text-lg font-bold text-blue-600 mb-6">Super User</h2>
        <nav class="flex flex-col space-y-4">
            <a href="{{ route('superuser.anggota') }}" class="text-gray-700 hover:text-blue-600">Kelola Anggota</a>
            <a href="{{ route('superuser.bundle') }}" class="text-gray-700 hover:text-blue-600">Kelola Bundle</a>
            <a href="{{ route('superuser.password') }}" class="text-gray-700 hover:text-blue-600">Password Anggota</a>
            <a href="{{ route('superuser.jadwal') }}" class="text-gray-700 hover:text-blue-600">Kelola Jadwal</a>
            <a href="{{ route('superuser.paket') }}" class="text-gray-700 hover:text-blue-600">Kelola Paket</a>

            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit" 
                    class="text-left text-red-600 hover:text-red-800 w-full mt-4"
                >
                    Logout
                </button>
            </form>
        </nav>
    </div>
</aside>
