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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --purple-dark: #2d1b69;
            --purple-primary: #3730a3;
            --purple-light: #4c1d95;
            --purple-accent: #6366f1;
            --purple-glow: rgba(99, 102, 241, 0.3);
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar-gradient {
            background: linear-gradient(145deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);
            position: relative;
        }
        
        .sidebar-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(145deg, rgba(67, 56, 202, 0.1) 0%, rgba(79, 70, 229, 0.05) 100%);
            pointer-events: none;
        }
        
        .glassmorphism {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-item {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: left center;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }
        
        .nav-item:hover::before {
            left: 100%;
        }
        
        .nav-item:hover {
            transform: translateX(8px) scale(1.02);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
        }
        
        .nav-active {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.4);
            transform: translateX(4px);
        }
        
        .nav-active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: #ffffff;
            border-radius: 2px 0 0 2px;
        }
        
        .submenu-item {
            position: relative;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            border-left: 3px solid transparent;
        }
        
        .submenu-item:hover {
            background: rgba(99, 102, 241, 0.2);
            border-left-color: #ffffff;
            transform: translateX(6px);
        }
        
        .submenu-item.active {
            background: rgba(99, 102, 241, 0.3);
            border-left-color: #ffffff;
        }
        
        .text-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }
        
        .icon-glow {
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.6));
        }
        
        .sidebar-shadow {
            box-shadow: 
                8px 0 40px rgba(0, 0, 0, 0.3),
                inset -1px 0 0 rgba(255, 255, 255, 0.1);
        }
        
        .main-content {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
        }
        
        .main-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }
        
        .logout-btn:hover::before {
            left: 100%;
        }
        
        .logout-btn:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }
        
        .brand-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .chevron-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .submenu-border {
            border-left: 2px solid rgba(99, 102, 241, 0.3);
            background: linear-gradient(to bottom, rgba(99, 102, 241, 0.1), transparent);
        }
        
        /* Animation keyframes */
        @keyframes pulse-glow {
            0%, 100% { 
                filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.6)); 
            }
            50% { 
                filter: drop-shadow(0 0 16px rgba(255, 255, 255, 0.8)); 
            }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.6);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.8);
        }
    </style>
</head>
<body class="flex min-h-screen antialiased bg-slate-50">
    <!-- Sidebar -->
    <aside class="w-80 sidebar-gradient text-white sidebar-shadow flex flex-col transition-all duration-500 relative z-20">
        <!-- Brand Section -->
        <div class="brand-section p-6 text-center">
            <div class="flex items-center justify-center space-x-3 mb-2">
                <i class="fas fa-crown text-3xl text-yellow-300 pulse-glow"></i>
                <span class="text-2xl font-bold text-glow tracking-wide">Superuser</span>
            </div>
            <div class="text-sm text-purple-200 font-medium">Control Panel</div>
            <div class="mt-3 h-0.5 bg-gradient-to-r from-transparent via-white to-transparent opacity-30"></div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 p-6 space-y-4 overflow-y-auto" x-data="{
            openKelolaAnggota: false,
            openKelolaJadwal: false,
            openKelolaPaket: false
        }">
            <!-- Dashboard -->
            <a href="{{ route('superuser.dashboard') }}"
               class="flex items-center space-x-4 px-6 py-4 rounded-2xl nav-item text-lg font-semibold {{ request()->routeIs('superuser.dashboard') ? 'nav-active' : 'glassmorphism' }}">
                <i class="fas fa-tachometer-alt text-xl w-6 text-center icon-glow"></i>
                <span class="text-glow">Dashboard</span>
                <div class="ml-auto">
                    <i class="fas fa-chevron-right text-sm opacity-60"></i>
                </div>
            </a>
            
            <!-- Kelola Anggota with Submenu -->
            <div class="space-y-3">
                <button @click="openKelolaAnggota = !openKelolaAnggota"
                        class="w-full flex items-center justify-between px-6 py-4 rounded-2xl glassmorphism hover:bg-opacity-20 focus:outline-none nav-item text-lg font-semibold">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-users text-xl w-6 text-center icon-glow"></i>
                        <span class="text-glow">Kelola Anggota</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-300 text-purple-200 chevron-icon"
                       :class="{ 'rotate-180': openKelolaAnggota }"></i>
                </button>
                <div x-show="openKelolaAnggota" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="ml-4 pl-6 submenu-border space-y-2 rounded-lg p-2">
                    <a href="{{ route('superuser.kelola-anggota.index') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('superuser.kelola-anggota.*') ? 'active' : '' }}">
                        <i class="fas fa-list-ul text-lg w-6 text-center"></i>
                        <span class="font-medium">Data Anggota</span>
                    </a>
                    <a href="{{ route('superuser.kelola-password') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('superuser.kelola-password') ? 'active' : '' }}">
                        <i class="fas fa-key text-lg w-6 text-center"></i>
                        <span class="font-medium">Password Anggota</span>
                    </a>
                </div>
            </div>

            <!-- Kelola Bundle -->
            <a href="{{ route('superuser.kelola-bundle.index') }}"
               class="flex items-center space-x-4 px-6 py-4 rounded-2xl nav-item text-lg font-semibold {{ request()->routeIs('superuser.kelola-bundle.*') ? 'nav-active' : 'glassmorphism' }}">
                <i class="fas fa-box-open text-xl w-6 text-center icon-glow"></i>
                <span class="text-glow">Kelola Bundle</span>
                <div class="ml-auto">
                    <i class="fas fa-chevron-right text-sm opacity-60"></i>
                </div>
            </a>

            <!-- Kelola Order -->
            <a href="{{ route('superuser.kelola-order.index') }}"
               class="flex items-center space-x-4 px-6 py-4 rounded-2xl nav-item text-lg font-semibold {{ request()->routeIs('superuser.kelola-order.*') ? 'nav-active' : 'glassmorphism' }}">
                <i class="fas fa-shopping-cart text-xl w-6 text-center icon-glow"></i>
                <span class="text-glow">Kelola Pesanan</span>
                <div class="ml-auto">
                    <i class="fas fa-chevron-right text-sm opacity-60"></i>
                </div>
            </a>

            <!-- Kelola Jadwal with Submenu -->
            <div class="space-y-3">
                <button @click="openKelolaJadwal = !openKelolaJadwal"
                        class="w-full flex items-center justify-between px-6 py-4 rounded-2xl glassmorphism hover:bg-opacity-20 focus:outline-none nav-item text-lg font-semibold">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-calendar-alt text-xl w-6 text-center icon-glow"></i>
                        <span class="text-glow">Kelola Jadwal</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-300 text-purple-200 chevron-icon"
                       :class="{ 'rotate-180': openKelolaJadwal }"></i>
                </button>
                <div x-show="openKelolaJadwal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="ml-4 pl-6 submenu-border space-y-2 rounded-lg p-2">
                    <a href="{{ route('superuser.jadwal.event.index') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('superuser.jadwal.event.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check text-lg w-6 text-center"></i>
                        <span class="font-medium">Jadwal Event</span>
                    </a>
                    <a href="{{ route('superuser.jadwal.latihan.index') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('superuser.jadwal.latihan.*') ? 'active' : '' }}">
                        <i class="fas fa-dumbbell text-lg w-6 text-center"></i>
                        <span class="font-medium">Jadwal Latihan</span>
                    </a>
                    <a href="{{ route('superuser.jadwal.rapat.index') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('superuser.jadwal.rapat.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog text-lg w-6 text-center"></i>
                        <span class="font-medium">Jadwal Rapat</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Logout Button -->
        <div class="p-6 border-t border-purple-700/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="logout-btn flex items-center justify-center w-full space-x-4 text-white font-bold py-4 rounded-2xl transition-all duration-300 text-lg relative overflow-hidden">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 main-content overflow-auto relative z-10">
        <div class="content-card rounded-3xl p-10 min-h-full">
            @yield('content')
        </div>
    </main>
</body>
</html>