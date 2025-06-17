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
            border-left-color: #fbbf24;
            transform: translateX(6px);
        }
        
        .submenu-item.active {
            background: rgba(99, 102, 241, 0.3);
            border-left-color: #fbbf24;
        }
        
        .text-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }
        
        .icon-glow {
            filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.8));
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
        
        .content-wrapper {
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
            border-left: 2px solid rgba(251, 191, 36, 0.4);
            background: linear-gradient(to bottom, rgba(251, 191, 36, 0.1), transparent);
        }
        
        /* Member badge styles */
        .member-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #1e1b4b;
            font-weight: 700;
            text-shadow: none;
        }
        
        /* Animation keyframes */
        @keyframes pulse-glow {
            0%, 100% { 
                filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.8)); 
            }
            50% { 
                filter: drop-shadow(0 0 16px rgba(251, 191, 36, 1)); 
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
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
        
        /* Special user icon styling */
        .user-icon {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            padding: 8px;
            border-radius: 50%;
            color: #1e1b4b;
            font-size: 1.2rem;
        }
    </style>
</head>
<body class="flex min-h-screen antialiased">
    <!-- Sidebar -->
    <aside class="w-80 sidebar-gradient text-white sidebar-shadow flex flex-col transition-all duration-500 relative z-20">
        <!-- Brand Section -->
        <div class="brand-section p-6 text-center">
            <div class="flex items-center justify-center space-x-3 mb-2">
                <i class="fas fa-crown text-3xl text-yellow-300 pulse-glow"></i>
                <span class="text-2xl font-bold text-glow tracking-wide">Aggota</span>
            </div>
            <div class="text-sm text-purple-200 font-medium">UKM SENI PSDKU KEDIRI</div>
            <div class="mt-3 h-0.5 bg-gradient-to-r from-transparent via-white to-transparent opacity-30"></div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-6 space-y-4 overflow-y-auto" x-data="{ openJadwal: false }">
            <!-- Dashboard -->
            <a href="{{ route('anggota.dashboard') }}"
               class="flex items-center space-x-4 px-6 py-4 rounded-2xl nav-item text-lg font-semibold glassmorphism">
                <i class="fas fa-cog text-xl w-6 text-center text-amber-300 icon-glow"></i>
                <span class="text-glow">Dashboard</span>
                <div class="ml-auto">
                    <i class="fas fa-chevron-right text-sm opacity-60"></i>
                </div>
            </a>
            <!-- Jadwal with Submenu -->
            <div class="space-y-3">
                <button @click="openJadwal = !openJadwal"
                        class="w-full flex items-center justify-between px-6 py-4 rounded-2xl glassmorphism hover:bg-opacity-20 focus:outline-none nav-item text-lg font-semibold">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-calendar-alt text-xl w-6 text-center text-amber-300 icon-glow"></i>
                        <span class="text-glow">Jadwal</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-300 text-amber-300 chevron-icon"
                       :class="{ 'rotate-180': openJadwal }"></i>
                </button>
                <div x-show="openJadwal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="ml-4 pl-6 submenu-border space-y-2 rounded-lg p-2">
                    <a href="{{ route('anggota.jadwal.event') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('anggota.jadwal.event') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check text-lg w-6 text-center text-amber-300"></i>
                        <span class="font-medium">Jadwal Event</span>
                    </a>
                    <a href="{{ route('anggota.jadwal.latihan') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('anggota.jadwal.latihan') ? 'active' : '' }}">
                        <i class="fas fa-dumbbell text-lg w-6 text-center text-amber-300"></i>
                        <span class="font-medium">Jadwal Latihan</span>
                    </a>
                    <a href="{{ route('anggota.jadwal.rapat') }}"
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl submenu-item {{ request()->routeIs('anggota.jadwal.rapat') ? 'active' : '' }}">
                        <i class="fas fa-users-cog text-lg w-6 text-center text-amber-300"></i>
                        <span class="font-medium">Jadwal Rapat</span>
                    </a>
                </div>
            </div>

            <!-- Biodata -->
            <a href="{{ route('anggota.biodata.index') }}"
               class="flex items-center space-x-4 px-6 py-4 rounded-2xl nav-item text-lg font-semibold {{ request()->routeIs('anggota.biodata.*') ? 'nav-active' : 'glassmorphism' }}">
                <i class="fas fa-id-card text-xl w-6 text-center text-amber-300 icon-glow"></i>
                <span class="text-glow">Biodata</span>
                <div class="ml-auto">
                    <i class="fas fa-chevron-right text-sm opacity-60"></i>
                </div>
            </a>

            

           
        </nav>

        <!-- User Info Section -->
        <div class="px-6 py-4 border-t border-purple-700/50">
            <div class="flex items-center space-x-3 p-3 rounded-xl glassmorphism">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-purple-900 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Anggota' }}</div>
                    <div class="text-xs text-purple-200">Member Active</div>
                </div>
                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
            </div>
        </div>

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
        <div class="content-wrapper rounded-3xl p-10 min-h-full relative z-10">
            @yield('content')
        </div>
    </main>
</body>
</html>