<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Superuser Dashboard - UKM Seni')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #4c1d95 0%, #5b21b6 100%);
        }
        .hover-scale {
            transition: all 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.03);
        }
        .main-content {
            background: #f9fafb;
        }
        .nav-active {
            background-color: #7e22ce;
            box-shadow: 0 4px 6px -1px rgba(126, 34, 206, 0.3);
        }
        .nav-item {
            transition: all 0.2s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .nav-item:hover {
            background-color: #7e22ce;
        }
        .submenu-item {
            transition: all 0.2s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .submenu-item:hover {
            background-color: #6b21a8;
            margin-left: 4px;
        }
        .sidebar-shadow {
            box-shadow: 6px 0 20px rgba(0, 0, 0, 0.15);
        }
        .text-glow {
            text-shadow: 0 0 8px rgba(216, 180, 254, 0.4);
        }
        .icon-glow {
            filter: drop-shadow(0 0 4px rgba(216, 180, 254, 0.6));
        }
    </style>
</head>
<body class="flex min-h-screen font-sans antialiased bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-72 sidebar-gradient text-white sidebar-shadow flex flex-col transition-all duration-300">
        <div class="p-6 text-2xl font-bold border-b border-purple-700 flex items-center space-x-3">
            <i class="fas fa-crown text-purple-300 icon-glow"></i>
            <span class="text-glow">Superuser Panel</span>
        </div>
        
        <nav class="flex-1 p-5 space-y-3" x-data="{
            openKelolaAnggota: false,
            openKelolaJadwal: false,
            openKelolaPaket: false
        }">
            <!-- Dashboard -->
            <a href="{{ route('superuser.dashboard') }}"
               class="flex items-center space-x-4 px-5 py-3.5 rounded-xl nav-item text-lg {{ request()->routeIs('superuser.dashboard') ? 'nav-active' : 'bg-purple-800/70' }}">
                <i class="fas fa-tachometer-alt text-purple-200 w-6 text-center icon-glow"></i>
                <span class="font-semibold text-glow">Dashboard</span>
            </a>
            
            <!-- Kelola Anggota with Submenu -->
            <div class="space-y-2">
                <button @click="openKelolaAnggota = !openKelolaAnggota"
                        class="w-full flex items-center justify-between px-5 py-3.5 rounded-xl bg-purple-800/70 hover:bg-purple-700 focus:outline-none nav-item text-lg">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-users text-purple-200 w-6 text-center icon-glow"></i>
                        <span class="font-semibold text-glow">Kelola Anggota</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200 text-purple-200 text-sm"
                       :class="{ 'rotate-180': openKelolaAnggota }"></i>
                </button>
                <div x-show="openKelolaAnggota" x-transition class="ml-3 pl-5 border-l-2 border-purple-600 space-y-2">
                    <a href="{{ route('superuser.kelola-anggota.index') }}"
                       class="flex items-center space-x-4 px-4 py-2.5 rounded-lg submenu-item text-base {{ request()->routeIs('superuser.kelola-anggota.*') ? 'bg-purple-700' : '' }}">
                        <i class="fas fa-list-ul text-purple-200 text-base w-6 text-center"></i>
                        <span class="text-glow">Data Anggota</span>
                    </a>
                    <a href="{{ route('superuser.kelola-password') }}"
                       class="flex items-center space-x-4 px-4 py-2.5 rounded-lg submenu-item text-base {{ request()->routeIs('superuser.kelola-password') ? 'bg-purple-700' : '' }}">
                        <i class="fas fa-key text-purple-200 text-base w-6 text-center"></i>
                        <span class="text-glow">Password Anggota</span>
                    </a>
                </div>
            </div>

            <!-- Kelola Bundle -->
            <a href="{{ route('superuser.kelola-bundle.index') }}"
               class="flex items-center space-x-4 px-5 py-3.5 rounded-xl nav-item text-lg {{ request()->routeIs('superuser.kelola-bundle.*') ? 'nav-active' : 'bg-purple-800/70' }}">
                <i class="fas fa-box-open text-purple-200 w-6 text-center icon-glow"></i>
                <span class="font-semibold text-glow">Kelola Bundle</span>
            </a>

            <!-- Kelola Order -->
            <a href="{{ route('superuser.kelola-order.index') }}"
               class="flex items-center space-x-4 px-5 py-3.5 rounded-xl nav-item text-lg {{ request()->routeIs('superuser.kelola-order.*') ? 'nav-active' : 'bg-purple-800/70' }}">
                <i class="fas fa-list-alt text-purple-200 w-6 text-center icon-glow"></i>
                <span class="font-semibold text-glow">Kelola Pesanan</span>
            </a>

            <!-- Kelola Jadwal with Submenu -->
            <div class="space-y-2">
                <button @click="openKelolaJadwal = !openKelolaJadwal"
                        class="w-full flex items-center justify-between px-5 py-3.5 rounded-xl bg-purple-800/70 hover:bg-purple-700 focus:outline-none nav-item text-lg">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-calendar-alt text-purple-200 w-6 text-center icon-glow"></i>
                        <span class="font-semibold text-glow">Kelola Jadwal</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200 text-purple-200 text-sm"
                       :class="{ 'rotate-180': openKelolaJadwal }"></i>
                </button>
                <div x-show="openKelolaJadwal" x-transition class="ml-3 pl-5 border-l-2 border-purple-600 space-y-2">
                    <a href="{{ route('superuser.jadwal.event.index') }}"
                       class="flex items-center space-x-4 px-4 py-2.5 rounded-lg submenu-item text-base {{ request()->routeIs('superuser.jadwal.event.*') ? 'bg-purple-700' : '' }}">
                        <i class="fas fa-calendar-check text-purple-200 text-base w-6 text-center"></i>
                        <span class="text-glow">Jadwal Event</span>
                    </a>
                    <a href="{{ route('superuser.jadwal.latihan.index') }}"
                       class="flex items-center space-x-4 px-4 py-2.5 rounded-lg submenu-item text-base {{ request()->routeIs('superuser.jadwal.latihan.*') ? 'bg-purple-700' : '' }}">
                        <i class="fas fa-dumbbell text-purple-200 text-base w-6 text-center"></i>
                        <span class="text-glow">Jadwal Latihan</span>
                    </a>
                    <a href="{{ route('superuser.jadwal.rapat.index') }}"
                       class="flex items-center space-x-4 px-4 py-2.5 rounded-lg submenu-item text-base {{ request()->routeIs('superuser.jadwal.rapat.*') ? 'bg-purple-700' : '' }}">
                        <i class="fas fa-users-cog text-purple-200 text-base w-6 text-center"></i>
                        <span class="text-glow">Jadwal Rapat</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Logout -->
        <div class="p-5 border-t border-purple-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center justify-center w-full space-x-4 bg-purple-700 hover:bg-purple-600 text-white font-semibold py-3 rounded-xl transition-colors duration-200 text-lg">
                    <i class="fas fa-sign-out-alt icon-glow"></i>
                    <span class="text-glow">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10 main-content overflow-auto">
        <div class="bg-white rounded-2xl shadow-md p-8 min-h-full">
            @yield('content')
        </div>
    </main>
</body>
</html>