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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --purple-dark: #2d1b69;
            --purple-primary: #3730a3;
            --purple-light: #4c1d95;
            --purple-accent: #6366f1;
            --purple-glow: rgba(99, 102, 241, 0.3);
            --btn-login: #2563eb; /* Blue for Login */
            --btn-login-hover: #1e40af;
            --btn-register: #16a34a; /* Green for Register */
            --btn-register-hover: #15803d;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple-light) 100%), url('https://source.unsplash.com/random/1920x1080/?art');
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
            opacity: 0.30;
            z-index: 1;
            max-width: 70%;
            height: auto;
            box-sizing: border-box;
        }

        .nav-item:hover {
            color: var(--purple-accent);
            transform: translateY(-2px);
        }

        .btn-login {
            background: var(--btn-login);
            color: white;
        }

        .btn-login:hover {
            background: var(--btn-login-hover);
            transform: scale(1.05);
            box-shadow: 0 8px 25px var(--purple-glow);
        }

        .btn-register {
            background: var(--btn-register);
            color: white;
        }

        .btn-register:hover {
            background: var(--btn-register-hover);
            transform: scale(1.05);
            box-shadow: 0 8px 25px var(--purple-glow);
        }

        .btn-primary {
            background: var(--purple-accent);
            color: white;
        }

        .btn-primary:hover {
            background: var(--purple-light);
            transform: scale(1.05);
            box-shadow: 0 8px 25px var(--purple-glow);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid var(--purple-accent);
            color: var(--purple-accent);
        }

        .btn-secondary:hover {
            background: var(--purple-accent);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 8px 25px var(--purple-glow);
        }

        .icon-glow {
            filter: drop-shadow(0 0 8px rgba(99, 102, 241, 0.6));
        }

        .text-glow {
            text-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
        }

        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .section-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
        }

        .section-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 20%, var(--purple-glow) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, var(--purple-glow) 0%, transparent 50%);
            pointer-events: none;
        }

        @media (min-width: 768px) {
            .video-iframe {
                height: 250px;
            }
            .hero-logo {
                max-width: 50%;
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
                    <span class="text-2xl font-extrabold text-purple-dark">UKM - SENI</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#home" class="text-gray-700 hover:text-purple-accent font-semibold transition duration-200 nav-item">Beranda</a>
                    <a href="#tentang" class="text-gray-700 hover:text-purple-accent font-semibold transition duration-200 nav-item">Tentang</a>
                    <a href="#review" class="text-gray-700 hover:text-purple-accent font-semibold transition duration-200 nav-item">Review</a>
                    <a href="#manfaat" class="text-gray-700 hover:text-purple-accent font-semibold transition duration-200 nav-item">Manfaat</a>
                    <a href="#kontak" class="text-gray-700 hover:text-purple-accent font-semibold transition duration-200 nav-item">Kontak</a>
                    <a href="{{ route('login') }}" class="text-white btn-login px-6 py-2 rounded-full shadow-lg font-semibold transition duration-300 transform">Login</a>
                    <a href="{{ route('register') }}" class="text-white btn-register px-6 py-2 rounded-full shadow-lg font-semibold transition duration-300 transform">Daftar</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="relative min-h-screen hero-bg text-white flex flex-col justify-center items-center pt-24 pb-16">
            <div class="relative text-center px-4 max-w-5xl mx-auto z-10" data-aos="fade-up" data-aos-duration="1000">
                <img src="{{ asset('') }}?v={{ time() }}" alt="Logo UKM Seni" class="hero-logo" data-aos="zoom-in" data-aos-duration="1200">
                <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight text-glow">UKM Seni Kampus Kediri</h1>
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white text-glow">Wujudkan Kreativitasmu Bersama Kami!</h2>
                <p class="text-lg md:text-xl mb-10 max-w-3xl mx-auto leading-relaxed">Bergabunglah dengan komunitas seni terdepan di kampus dan kembangkan bakat seni Anda melalui pelatihan, pameran, dan kolaborasi kreatif.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="btn-register px-8 py-4 rounded-full shadow-2xl font-semibold text-lg transition duration-300 transform">Daftar Sekarang</a>
                    <a href="#tentang" class="btn-secondary px-8 py-4 rounded-full font-semibold text-lg transition duration-300 transform">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="tentang" class="py-20 section-bg text-gray-800 relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-4xl font-extrabold text-purple-dark mb-4">Tentang UKM Seni</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">UKM Seni adalah wadah bagi mahasiswa untuk mengeksplorasi dan mengembangkan bakat seni mereka. Kami menawarkan berbagai kegiatan seperti pelatihan seni, pameran, dan kolaborasi lintas disiplin untuk menciptakan karya yang inspiratif.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="flex items-center" data-aos="fade-right" data-aos-duration="1000">
                        <img src="images/logo-ukm-seni.jpg" alt="UKM Seni" class="w-full rounded-xl shadow-lg">
                    </div>
                    <div class="flex flex-col justify-center space-y-6" data-aos="fade-left" data-aos-duration="1000">
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-paint-brush text-3xl text-purple-accent icon-glow"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-purple-dark">Kreativitas Tanpa Batas</h3>
                                <p class="text-gray-600">Kami mendorong setiap anggota untuk bereksperimen dan menciptakan karya seni yang unik.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-users text-3xl text-purple-accent icon-glow"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-purple-dark">Komunitas yang Solid</h3>
                                <p class="text-gray-600">Bergabung dengan komunitas yang mendukung dan penuh semangat untuk berkolaborasi.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-trophy text-3xl text-purple-accent icon-glow"></i>
                            <div>
                                <h3 class="text-xl font-semibold text-purple-dark">Prestasi dan Pengakuan</h3>
                                <p class="text-gray-600">Pamerkan karya Anda di pameran dan kompetisi untuk mendapatkan pengakuan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Review Section -->
        <section id="review" class="py-20 section-bg relative">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-extrabold text-center text-purple-dark mb-16" data-aos="fade-up" data-aos-duration="800">Review dari Anggota UKM Seni</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Video 1 -->
                    <div class="content-card p-6 rounded-xl transform transition duration-300 hover:scale-105" data-aos="fade-up" data-aos-duration="1000">
                        <iframe class="video-iframe" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Review 1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <h3 class="text-xl font-semibold text-purple-dark mt-4">Pengalaman Seni yang Menginspirasi</h3>
                        <p class="text-gray-600 mt-2">Anggota kami berbagi pengalaman mereka dalam pameran seni tahunan UKM Seni.</p>
                    </div>
                    <!-- Video 2 -->
                    <div class="content-card p-6 rounded-xl transform transition duration-300 hover:scale-105" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <iframe class="video-iframe" src="https://www.youtube.com/embed/VIDEO_ID_2" title="Review 2" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <h3 class="text-xl font-semibold text-purple-dark mt-4">Kolaborasi Kreatif</h3>
                        <p class="text-gray-600 mt-2">Lihat bagaimana anggota kami berkolaborasi dalam proyek seni lintas disiplin.</p>
                    </div>
                    <!-- Video 3 -->
                    <div class="content-card p-6 rounded-xl transform transition duration-300 hover:scale-105" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <iframe class="video-iframe" src="https://www.youtube.com/embed/VIDEO_ID_3" title="Review 3" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <h3 class="text-xl font-semibold text-purple-dark mt-4">Pelatihan Seni Profesional</h3>
                        <p class="text-gray-600 mt-2">Testimoni tentang pelatihan seni yang meningkatkan keterampilan anggota.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section id="manfaat" class="py-20 section-bg relative">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-extrabold text-center text-purple-dark mb-16" data-aos="fade-up" data-aos-duration="800">Mengapa Memilih UKM Seni?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="content-card p-6 rounded-xl text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000">
                        <i class="fas fa-paint-brush text-4xl text-purple-accent mb-4 icon-glow"></i>
                        <h3 class="text-xl font-semibold mb-2 text-purple-dark">Pelatihan Seni Profesional</h3>
                        <p class="text-gray-600">Dapatkan bimbingan dari seniman berpengalaman untuk mengasah keterampilan Anda.</p>
                    </div>
                    <div class="content-card p-6 rounded-xl text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="100">
                        <i class="fas fa-trophy text-4xl text-purple-accent mb-4 icon-glow"></i>
                        <h3 class="text-xl font-semibold mb-2 text-purple-dark">Kompetisi dan Pameran</h3>
                        <p class="text-gray-600">Pamerkan karya seni Anda di berbagai ajang kompetisi dan pameran.</p>
                    </div>
                    <div class="content-card p-6 rounded-xl text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
                        <i class="fas fa-users text-4xl text-purple-accent mb-4 icon-glow"></i>
                        <h3 class="text-xl font-semibold mb-2 text-purple-dark">Jaringan dengan Seniman</h3>
                        <p class="text-gray-600">Bangun koneksi dan kolaborasi dengan komunitas seniman kampus.</p>
                    </div>
                    <div class="content-card p-6 rounded-xl text-center transform transition duration-300 hover:scale-105" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="300">
                        <i class="fas fa-seedling text-4xl text-purple-accent mb-4 icon-glow"></i>
                        <h3 class="text-xl font-semibold mb-2 text-purple-dark">Kesempatan Berkembang</h3>
                        <p class="text-gray-600">Kembangkan portofolio dan karir Anda di dunia seni.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="kontak" class="py-20 bg-purple-dark relative">
            <div class="max-w-7xl mx-auto px-6 text-center" data-aos="fade-up" data-aos-duration="800">
                <h2 class="text-4xl font-extrabold mb-8 text-purple-accent text-glow">Hubungi Kami</h2>
                <p class="text-lg mb-6 max-w-2xl mx-auto text-purple-accent">Punya pertanyaan atau ingin tahu lebih banyak tentang UKM Seni? Jangan ragu untuk menghubungi kami!</p>
                <div class="mb-8">
                    <p class="text-xl mb-4">Email: <a href="mailto:ukmseni@example.com" class="text-purple-light hover:text-purple-accent text-glow transition duration-300">ukmseni@example.com</a></p>
                    <p class="text-xl">Telepon: <a href="tel:+6281234567890" class="text-purple-light hover:text-purple-accent text-glow transition duration-300">+62 812-3456-7890</a></p>
                </div>
                <div class="flex justify-center space-x-8">
                    <a href="#" class="text-3xl text-purple-light hover:text-purple-accent transition duration-300 transform hover:scale-110 icon-glow"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-3xl text-purple-light hover:text-purple-accent transition duration-300 transform hover:scale-110 icon-glow"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-3xl text-purple-light hover:text-purple-accent transition duration-300 transform hover:scale-110 icon-glow"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-3xl text-purple-light hover:text-purple-accent transition duration-300 transform hover:scale-110 icon-glow"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-purple-dark text-purple-accent py-6">
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