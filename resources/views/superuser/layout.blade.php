<!-- resources/views/superuser/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super User - UKM Seni</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex font-sans">
    @include('superuser.sidebar') <!-- buat file sidebar.blade.php nanti -->

    <main class="flex-1 p-8">
        @yield('content')
    </main>
</body>
</html>
