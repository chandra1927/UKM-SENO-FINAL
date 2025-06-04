<!-- resources/views/customer/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Customer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Profil Customer</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-4 p-3 bg-yellow-200 text-yellow-800 rounded">
                {{ session('warning') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <p><strong>Nama:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Telepon:</strong> {{ $customer->phone }}</p>
            <p><strong>Alamat:</strong> {{ $customer->address }}</p>
            <p><strong>Dibuat pada:</strong> {{ $customer->created_at->format('d M Y H:i') }}</p>
            <p><strong>Diperbarui pada:</strong> {{ $customer->updated_at->format('d M Y H:i') }}</p>

            <div class="mt-4">
                <a href="{{ route('customer.edit', $customer->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit Profil</a>
                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Hapus Profil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
