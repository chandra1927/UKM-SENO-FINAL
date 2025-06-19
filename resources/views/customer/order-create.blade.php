@extends('layouts.customer')

@section('title', 'Buat Pesanan')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow-xl rounded-lg p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-extrabold text-purple-900 mb-6">Buat Pesanan Baru</h1>

        <!-- Informasi Bundle -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-purple-600">{{ $bundle->nama_paket }}</h2>
            <p class="text-gray-600 mb-2"><strong>Deskripsi:</strong> {{ $bundle->deskripsi ?? '-' }}</p>
            <p class="text-gray-600 mb-2"><strong>Isi Paket:</strong></p>
            <ul class="list-disc list-inside mb-4 text-gray-600">
                @php
                    $isi_paket_array = is_array($bundle->isi_paket) ? $bundle->isi_paket : (is_string($bundle->isi_paket) ? json_decode($bundle->isi_paket, true) : []);
                    $isi_paket_array = $isi_paket_array ?: [];
                @endphp
                @forelse($isi_paket_array as $musisi)
                    <li>{{ $musisi }}</li>
                @empty
                    <li>Tidak ada isi paket yang tersedia.</li>
                @endforelse
            </ul>
            <p class="text-purple-800 font-bold mb-4">Harga: Rp {{ number_format($bundle->harga, 0, ',', '.') }}</p>

            <!-- Video Review -->
            @if ($bundle->video_path)
                <div class="mb-4">
                    <video class="w-full rounded-lg shadow-md" controls>
                        <source src="{{ asset('storage/' . $bundle->video_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                </div>
            @else
                <p class="text-gray-500 italic mb-4">Video review belum tersedia.</p>
            @endif
        </div>

        <!-- Formulir Pesanan -->
        <form id="orderForm" class="space-y-6">
            @csrf
            <input type="hidden" name="bundle_id" value="{{ $bundle->id }}">

            <!-- Data Pribadi -->
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-700 mb-4">Data Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_lengkap" class="block text-gray-700 font-semibold mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required>
                        <span id="nama_lengkap_error" class="text-red-500 text-sm mt-1 hidden"></span>
                    </div>
                    <div>
                        <label for="no_telepon" class="block text-gray-700 font-semibold mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required pattern="[0-9]{10,15}">
                        <span id="no_telepon_error" class="text-red-500 text-sm mt-1 hidden"></span>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-semibold mb-1">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required>
                        <span id="email_error" class="text-red-500 text-sm mt-1 hidden"></span>
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-gray-700 font-semibold mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" rows="3" required>{{ old('alamat') }}</textarea>
                        <span id="alamat_error" class="text-red-500 text-sm mt-1 hidden"></span>
                    </div>
                </div>
            </div>

            <!-- Detail Acara -->
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-700 mb-4">Detail Acara</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_acara" class="block text-gray-700 font-semibold mb-1">Tanggal Acara <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" value="{{ old('tanggal_acara') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required min="{{ date('Y-m-d') }}">
                        <span id="tanggal_acara_error" class="text-red-500 text-sm mt-1 hidden"></span>
                    </div>
                    <div>
                        <label for="waktu_acara" class="block text-gray-700 font-semibold mb-1">Waktu Acara <span class="text-red-500">*</span></label>
                        <input type="time" name="waktu_acara" id="waktu_acara" value="{{ old('waktu_acara') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" required>
                        <span id="waktu_acara_error" class="text-red-500 text-sm mt-1 hidden"></span>
                    </div>
                    <div class="md:col-span-2">
                        <label for="lokasi_acara" class="block text-gray-700 font-semibold mb-1">Lokasi Acara <span class="text-red-500">*</span></label>
                        <textarea name="lokasi_acara" id="lokasi_acara" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" rows="3" required>{{ old('lokasi_acara') }}</textarea>
                        <span id="lokasi_acara_error" class="text-red-500 text-sm mt-1 hidden"></span>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-700 mb-4">Catatan Tambahan (Opsional)</h3>
                <textarea name="notes" id="notes" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-400" rows="4" placeholder="Masukkan catatan tambahan jika ada">{{ old('notes') }}</textarea>
                <span id="notes_error" class="text-red-500 text-sm mt-1 hidden"></span>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" id="createOrderButton" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-2"></i> Buat Pesanan
                </button>
            </div>
        </form>

        <!-- Tampilan Checkout setelah pesanan dibuat -->
        <div id="checkoutSection" class="mt-6 bg-purple-50 p-4 rounded-lg hidden">
            <h3 class="text-lg font-semibold text-purple-700 mb-4">Lanjutkan Pembayaran</h3>
            <p class="text-gray-700 mb-4">Pesanan dengan ID: <strong id="orderIdDisplay"></strong> telah dibuat. Silakan lakukan pembayaran.</p>
            <button id="payButton" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition transform hover:scale-105">
                <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
            </button>
            <p id="checkoutError" class="text-red-500 text-sm mt-2 hidden"></p>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const orderForm = document.getElementById('orderForm');
        const checkoutSection = document.getElementById('checkoutSection');
        const payButton = document.getElementById('payButton');
        const orderIdDisplay = document.getElementById('orderIdDisplay');
        const checkoutError = document.getElementById('checkoutError');
        let snapToken = null;

        if (orderForm) {
            orderForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(orderForm);
                fetch('{{ route('customer.order.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        snapToken = data.snap_token;
                        orderIdDisplay.textContent = data.order_id;
                        checkoutSection.classList.remove('hidden');
                        document.getElementById('createOrderButton').disabled = true;
                    } else {
                        checkoutError.textContent = data.message || 'Gagal membuat pesanan.';
                        checkoutError.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    checkoutError.textContent = 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.';
                    checkoutError.classList.remove('hidden');
                });
            });
        }

        if (payButton) {
            payButton.addEventListener('click', function() {
                if (snapToken) {
                    snap.pay(snapToken, {
                        onSuccess: function(result) {
                            alert('Pembayaran berhasil! Silakan segarkan halaman untuk melihat status terbaru.');
                            window.location.href = "{{ route('customer.order') }}";
                        },
                        onPending: function(result) {
                            alert('Pembayaran menunggu konfirmasi. Silakan cek status pesanan nanti.');
                            window.location.href = "{{ route('customer.order') }}";
                        },
                        onError: function(result) {
                            alert('Terjadi kesalahan saat pembayaran. Silakan coba lagi.');
                            window.location.href = "{{ route('customer.order') }}";
                        },
                        onClose: function() {
                            alert('Pembayaran dibatalkan.');
                            window.location.href = "{{ route('customer.order') }}";
                        }
                    });
                } else {
                    checkoutError.textContent = 'Token pembayaran tidak tersedia. Silakan coba lagi.';
                    checkoutError.classList.remove('hidden');
                }
            });
        }
    });
</script>
@endsection