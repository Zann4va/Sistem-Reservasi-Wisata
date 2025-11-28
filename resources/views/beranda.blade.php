<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi Wisata - Admin</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: #333 !important;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            color: #fff !important;
        }
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(102,126,234,.85), rgba(118,75,162,.85)),
            url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1200&h=1200&fit=crop');
            background-size: cover;
            display: flex;
            align-items: center;
            text-align: center;
            padding: 40px;
        }
        .btn-hero {
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 600;
            border: 2px solid #fff;
            background: #fff;
            color: #667eea;
            margin: 10px;
        }
        .btn-hero:hover {
            background: transparent;
            color: #fff;
        }
        .features {
            padding: 80px 20px;
            background: #fff;
        }
        .feature-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,.1);
            margin-bottom: 30px;
        }
        .about {
            padding: 80px 20px;
            background: #faf8f8;
        }
        .features-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .stats {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 60px 20px;
            text-align: center;
            color: #fff;
        }
        .stat-number {
            font-size: 42px;
            font-weight: 700;
        }
        .footer {
            background: #2c3e50;
            padding: 40px;
            text-align: center;
            color: #fff;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top" data-aos="fade-down">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="#">
            <i class="bi bi-building"></i> Sistem Reservasi Wisata
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>

                <li class="nav-item ms-2">

                    @if (Auth::check())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-login">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right"></i> Login Admin
                        </a>
                    @endif

                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container text-white" data-aos="zoom-in">
        <i class="bi bi-airplane" style="font-size: 80px;"></i>
        <h1 class="mt-3">Sistem Reservasi Wisata</h1>
        <p>Platform modern untuk memanajemen destinasi dan reservasi wisata.</p>

        @if (Auth::check())
            <a href="{{ route('admin.dashboard') }}" class="btn-hero">
                <i class="bi bi-speedometer2"></i> Buka Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-hero">
                <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
            </a>
        @endif

        <a href="#features" class="btn-hero" style="background: transparent; color:white;">
            <i class="bi bi-arrow-down"></i> Pelajari Lebih Lanjut
        </a>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="features">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Fitur Unggulan</h2>

        <div class="row">

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <i class="bi bi-map fs-1 text-primary"></i>
                    <h4 class="mt-3">Kelola Destinasi</h4>
                    <p>Tambah, edit, hapus destinasi wisata dengan mudah.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <i class="bi bi-calendar-check fs-1 text-primary"></i>
                    <h4 class="mt-3">Manajemen Reservasi</h4>
                    <p>Atur reservasi dengan sistem yang rapi dan otomatis.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <i class="bi bi-graph-up fs-1 text-primary"></i>
                    <h4 class="mt-3">Analytics & Dashboard</h4>
                    <p>Dapatkan statistik real-time untuk mengambil keputusan.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="about">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-6" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500"
                     class="img-fluid rounded shadow">
            </div>

            <div class="col-md-6 mt-4 mt-md-0" data-aos="fade-left">
                <h2>Tentang Sistem Kami</h2>
                <p>Sistem modern yang mempermudah bisnis pariwisata.</p>

                <ul class="features-list">
                    <li>Dashboard intuitif real-time</li>
                    <li>Manajemen destinasi lengkap</li>
                    <li>Sistem reservasi otomatis</li>
                    <li>Keamanan data enterprise</li>
                    <li>Responsive di semua perangkat</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- STATS -->
<section class="stats">
    <div class="row container mx-auto">

        <div class="col-md-3 mb-3" data-aos="zoom-in">
            <div class="stat-number">5+</div>
            <div>Destinasi Wisata</div>
        </div>

        <div class="col-md-3 mb-3" data-aos="zoom-in" data-aos-delay="100">
            <div class="stat-number">70+</div>
            <div>Reservasi Terproses</div>
        </div>

        <div class="col-md-3 mb-3" data-aos="zoom-in" data-aos-delay="200">
            <div class="stat-number">100%</div>
            <div>Uptime Server</div>
        </div>

        <div class="col-md-3 mb-3" data-aos="zoom-in" data-aos-delay="300">
            <div class="stat-number">24/7</div>
            <div>Support</div>
        </div>

    </div>
</section>

<!-- FOOTER -->
<footer id="contact" class="footer" data-aos="fade-up">
    <p><strong>Sistem Reservasi Wisata © 2025</strong></p>
    <p>Email: admin@wisata.com | Telp: +62 812-3456-7890</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- AOS Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

</body>
</html>
