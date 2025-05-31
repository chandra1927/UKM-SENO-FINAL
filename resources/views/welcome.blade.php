<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM - SENI</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .hero-bg {
            background: linear-gradient(135deg, rgba(29, 78, 216, 0.9), rgba(91, 33, 182, 0.9)), url('https://source.unsplash.com/random/1920x1080/?art');
            background-size: cover;
            background-position: center;
        }
        .scroll-smooth {
            scroll-behavior: smooth;
        }
        .video-iframe {
            width: 100%;
            height: 200px;
            border-radius: 12px;
        }
        .hero-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.30; /* Transparansi lebih jelas */
            z-index: 1; /* Di atas background, di bawah teks */
            max-width: 70%; /* Dikurangi untuk centering lebih baik */
            height: auto;
            box-sizing: border-box; /* Hindari pergeseran akibat padding */
        }
        @media (min-width: 768px) {
            .video-iframe {
                height: 250px;
            }
            .hero-logo {
                max-width: 50%; /* Lebih kecil di desktop untuk proporsi */
            }
        }
    </style>
</head>
<body class="bg-gray-50 scroll-smooth">
    <div class="relative min-h-screen">
        <!-- Navigation Bar -->
        <nav class="bg-white shadow-xl fixed w-full z-30 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo-ukm-seni.jpg') }}?v={{ time() }}" alt="Logo UKM Seni" class="h-10 w-auto" data-aos="fade-right" data-aos-duration="800">
                    <span class="text-2xl font-extrabold text-indigo-900">UKM - SENI</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#home" class="text-gray-700 hover:text-indigo-600 font-semibold transition duration-200">Beranda</a>
                    <a href="#tentang" class="text-gray-700 hover:text-indigo-600 font-semibold transition duration-200">Tentang</a>
                    <a href="#review" class="text-gray-700 hover:text-indigo-600 font-semibold transition duration-200">Review</a>
                    <a href="#manfaat" class="text-gray-700 hover:text-indigo-600 font-semibold transition duration-200">Manfaat</a>
                    <a href="#kontak" class="text-gray-700 hover:text-indigo-600 font-semibold transition duration-200">Kontak</a>
                    <a href="{{ route('login') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-full shadow-lg font-semibold transition duration-300 transform hover:scale-105">Login</a>
                    <a href="{{ route('register') }}" class="text-white bg-yellow-500 hover:bg-yellow-600 px-6 py-2 rounded-full shadow-lg font-semibold transition duration-300 transform hover:scale-105">Daftar</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="relative min-h-screen hero-bg text-white flex flex-col justify-center items-center pt-24 pb-16">
            <div class="relative text-center px-4 max-w-5xl mx-auto z-10" data-aos="fade-up" data-aos-duration="1000">
                <img src="{{ asset('images/logo-ukm-seni.jpg') }}?v={{ time() }}" alt="Logo UKM Seni" class="hero-logo" data-aos="zoom-in" data-aos-duration="1200">
                <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">UKM Seni Kampus Kediri</h1>
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-yellow-300">Wujudkan Kreativitasmu Bersama Kami!</h2>
                <p class="text-lg md:text-xl mb-10 max-w-3xl mx-auto leading-relaxed">Bergabunglah dengan komunitas seni terdepan di kampus dan kembangkan bakat seni Anda melalui pelatihan, pameran, dan kolaborasi kreatif.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 hover:bg-yellow-500 px-8 py-4 rounded-full shadow-2xl font-semibold text-lg transition duration-300 transform hover:scale-105">Daftar Sekarang</a>
                    <a href="#tentang" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-indigo-900 px-8 py-4 rounded-full font-semibold text-lg transition duration-300 transform hover:scale-105">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="tentang" class="py-20 bg-white text-gray-800">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-4xl font-extrabold text-indigo-900 mb-4">Tentang UKM Seni</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">UKM Seni adalah wadah bagi mahasiswa untuk mengeksplorasi dan mengembangkan bakat seni mereka. Kami menawarkan berbagai kegiatan seperti pelatihan seni, pameran, dan kolaborasi lintas disiplin untuk menciptakan karya yang inspiratif.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="flex items-center" data-aos="fade-right" data-aos-duration="1000">
                        <img src="https://source.unsplash.com/random/600x400/?art" alt="UKM Seni" class="w-full rounded-xl shadow-lg">
                    </div>
                    <div class="flex flex-col justify-center space-y-6" data-aos="fade-left" data-aos-duration="1000">
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-paint-brush text-3xl text-indigo-600"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-indigo-900">Kreativitas Tanpa Batas</h3>
                                <p class="text-gray-600">Kami mendorong setiap anggota untuk bereksperimen dan menciptakan karya seni yang unik.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-users text-3xl text-indigo-600"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-indigo-900">Komunitas yang Solid</h3>
                                <p class="text-gray-600">Bergabung dengan komunitas yang mendukung dan penuh semangat untuk berkolaborasi.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-trophy text-3xl text-indigo-600"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-indigo-900">Prestasi dan Pengakuan</h3>
                                <p class="text-gray-600">Pamerkan karya Anda di pameran dan kompetisi untuk mendapatkan pengakuan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Review Section -->
        <section id="review" class="py-20 bg-indigo-50">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-extrabold text-center text-indigo-900 mb-16" data-aos="fade-up" data-aos-duration="800">Review dari Anggota UKM Seni</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Video 1 -->
                    <div class="bg-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:scale-105" data-aos="fade-up" data-aos-duration="1000">
                        <iframe class="video-iframe" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Review 1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <h3 class="text-xl font-semibold text-indigo-900 mt-4">Pengalaman Seni yang Menginspirasi</h3>
                        <p class="text-gray-600 mt-2">Anggota kami berbagi pengalaman mereka dalam pameran seni tahunan UKM Seni.</p>
                    </div>
                    <!-- Video 2 -->
                    <div class="bg-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:scale-105" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <iframe class="video-iframe" src="https://www.youtube.com/embed/VIDEO_ID_2" title="Review 2" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <h3 class="text-xl font-semibold text-indigo-900 mt-4">Kolaborasi Kreatif</h3>
                        <p class="text-gray-600 mt-2">Lihat bagaimana anggota kami berkolaborasi dalam proyek seni lintas disiplin.</p>
                    </div>
                    <!-- Video 3 -->
                    <div class="bg-white p-6 rounded-xl shadow-lg transform transition duration-300 hover:scale-105" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <iframe class="video-iframe" src="https://www.youtube.com/embed/VIDEO_ID_3" title="Review 3" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <h3 class="text-xl font-semibold text-indigo-900 mt-4">Pelatihan Seni Profesional</h3>
                        <p class="text-gray-600 mt-2">Testimoni tentang pelatihan seni yang meningkatkan keterampilan anggota.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section id="manfaat" class="py-20 bg-indigo-50">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-extrabold text-center text-indigo-900 mb-16" data-aos="fade-up" data-aos-duration="800">Mengapa Memilih UKM Seni?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000">
                        <i class="fas fa-paint-brush text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Pelatihan Seni Profesional</h3>
                        <p class="text-gray-600">Dapatkan bimbingan dari seniman berpengalaman untuk mengasah keterampilan Anda.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="100">
                        <i class="fas fa-trophy text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Kompetisi dan Pameran</h3>
                        <p class="text-gray-600">Pamerkan karya seni Anda di berbagai ajang kompetisi dan pameran.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
                        <i class="fas fa-users text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Jaringan dengan Seniman</h3>
                        <p class="text-gray-600">Bangun koneksi dan kolaborasi dengan komunitas seniman kampus.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="300">
                        <i class="fas fa-seedling text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Kesempatan Berkembang</h3>
                        <p class="text-gray-600">Kembangkan portofolio dan karir Anda di dunia seni.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="kontak" class="py-20 bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-6 text-center" data-aos="fade-up" data-aos-duration="800">
                <h2 class="text-4xl font-extrabold mb-8">Hubungi Kami</h2>
                <p class="text-lg mb-6 max-w-2xl mx-auto">Punya pertanyaan atau ingin tahu lebih banyak tentang UKM Seni? Jangan ragu untuk menghubungi kami!</p>
                <div class="mb-8">
                    <p class="text-xl mb-4">Email: <a href="mailto:ukmseni@example.com" class="text-yellow-400 hover:underline">ukmseni@example.com</a></p>
                    <p class="text-xl">Telepon: <a href="tel:+6281234567890" class="text-yellow-400 hover:underline">+62 812-3456-7890</a></p>
                </div>
                <div class="flex justify-center space-x-8">
                    <a href="#" class="text-3xl text-white hover:text-yellow-400 transition duration-300 transform hover:scale-110"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-3xl text-white hover:text-yellow-400 transition duration-300 transform hover:scale-110"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-3xl text-white hover:text-yellow-400 transition duration-300 transform hover:scale-110"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-3xl text-white hover:text-yellow-400 transition duration-300 transform hover:scale-110"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-indigo-900 text-white py-6">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <p class="text-sm">© {{ date('Y') }} UKM Seni. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>