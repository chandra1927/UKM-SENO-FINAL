<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    <!-- Add your CSS (Tailwind or others) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar or Header -->
    <nav class="bg-blue-600 p-4">
        <div class="max-w-7xl mx-auto">
            <a href="/" class="text-white font-bold">Home</a>
        </div>
    </nav>

    <div class="container mx-auto py-12">
        @yield('content')
    </div>

</body>
</html>
