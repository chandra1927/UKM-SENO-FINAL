<!-- resources/views/customer/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Customer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Data Customer</h1>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label for="name" class="block font-semibold">Nama</label>
                <input type="text" name="name" id="name" class="border rounded p-2 w-full" value="{{ old('name') }}" required>
            </div>
            <div class="mb-2">
                <label for="email" class="block font-semibold">Email</label>
                <input type="email" name="email" id="email" class="border rounded p-2 w-full" value="{{ old('email') }}" required>
            </div>
            <div class="mb-2">
                <label for="phone" class="block font-semibold">Telepon</label>
                <input type="text" name="phone" id="phone" class="border rounded p-2 w-full" value="{{ old('phone') }}" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block font-semibold">Alamat</label>
                <textarea name="address" id="address" rows="3" class="border rounded p-2 w-full" required>{{ old('address') }}</textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </form>
    </div>
</body>
</html>
