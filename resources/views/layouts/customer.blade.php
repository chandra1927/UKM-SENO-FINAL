<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pelanggan')</title>

    <!-- Load Tailwind via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
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
<body class="flex min-h-screen font-sans antialiased bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-72 sidebar-gradient text-white shadow-xl flex flex-col">
        <!-- Header -->
        <div class="p-6 text-3xl font-extrabold border-b border-indigo-400 flex items-center gap-3">
            <i class="fas fa-user-circle text-yellow-300"></i>
            <span>Pelanggan</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-6 space-y-3 text-base">
            @php
                $menuItems = [
                    ['route' => 'customer.index', 'icon' => 'fa-home', 'label' => 'Dashboard'],
                    ['route' => 'customer.history', 'icon' => 'fa-history', 'label' => 'History'],
                    ['route' => 'customer.order', 'icon' => 'fa-shopping-cart', 'label' => 'Order'],
                    ['route' => 'customer.payment', 'icon' => 'fa-credit-card', 'label' => 'Payment'],
                    ['route' => 'customer.indexCustomer', 'icon' => 'fa-user', 'label' => 'Profile'],
                ];
            @endphp

            @foreach ($menuItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg bg-indigo-700/50 hover:bg-indigo-600 transition hover-scale">
                    <i class="fas {{ $item['icon'] }} text-yellow-300"></i>
                    <span class="font-semibold">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Logout -->
        <div class="p-6 border-t border-indigo-400">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center justify-center w-full gap-3 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition hover-scale">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 relative overflow-auto">
        <div class="absolute inset-0 bg-white/40 backdrop-blur-md rounded-l-3xl"></div>
        <div class="relative z-10">
            @yield('content')
        </div>
    </main>
</body>
</html>
