<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Anggota')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
        }
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .main-content {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }
    </style>
</head>
<body class="flex min-h-screen font-sans antialiased">
    <!-- Sidebar -->
    <aside class="w-72 sidebar-gradient text-white shadow-2xl flex flex-col transition-all duration-300">
        <!-- Header -->
        <div class="p-6 text-3xl font-extrabold border-b border-indigo-500 flex items-center space-x-3">
            <i class="fas fa-user text-yellow-300"></i>
            <span>Anggota</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-6 space-y-3" x-data="{ openJadwal: false }">
            <!-- Jadwal with Submenu -->
            <div>
                <button @click="openJadwal = !openJadwal"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-indigo-700/50 hover:bg-indigo-600 focus:outline-none transition-colors duration-200 hover-scale">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-calendar-alt text-yellow-300"></i>
                        <span class="font-semibold">Jadwal</span>
                    </div>
                    <i class="fas fa-chevron-right transition-transform duration-300 text-yellow-300"
                       :class="{ 'rotate-90': openJadwal }"></i>
                </button>
                <ul x-show="openJadwal" x-transition class="mt-3 ml-8 space-y-2">
                    <li>
                        <a href="{{ route('anggota.jadwal.event') }}"
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-indigo-500 transition-colors duration-200 hover-scale">
                            <i class="fas fa-calendar-check text-yellow-300"></i>
                            <span>Jadwal Event</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('anggota.jadwal.latihan') }}"
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-indigo-500 transition-colors duration-200 hover-scale">
                            <i class="fas fa-dumbbell text-yellow-300"></i>
                            <span>Jadwal Latihan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('anggota.jadwal.rapat') }}"
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-indigo-500 transition-colors duration-200 hover-scale">
                            <i class="fas fa-users-cog text-yellow-300"></i>
                            <span>Jadwal Rapat</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Biodata -->
            <a href="{{ route('anggota.biodata.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-indigo-700/50 hover:bg-indigo-600 transition-colors duration-200 hover-scale">
                <i class="fas fa-user text-yellow-300"></i>
                <span class="font-semibold">Biodata</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-6 border-t border-indigo-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center justify-center w-full space-x-3 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition-colors duration-200 hover-scale">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-12 main-content rounded-l-3xl shadow-2xl m-6 relative overflow-auto">
        <div class="absolute inset-0 bg-white/30 backdrop-blur-sm rounded-l-3xl"></div>
        <div class="relative z-10">
            @yield('content')
        </div>
    </main>
</body>
</html>