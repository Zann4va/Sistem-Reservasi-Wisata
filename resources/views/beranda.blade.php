<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi Wisata - Admin</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50 !important;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            color: #555 !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #667eea !important;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.85) 0%, rgba(118, 75, 162, 0.85) 100%),
                        url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1200&h=1200&fit=crop') center/cover no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hero-content {
            text-align: center;
            color: white;
            max-width: 800px;
        }

        .hero-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .hero h1 {
            font-size: 52px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
            opacity: 0.95;
            line-height: 1.6;
        }

        .btn-hero {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            margin: 10px;
            transition: all 0.3s ease;
            border: 2px solid white;
        }

        .btn-hero:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
        }

        /* Features Section */
        .features {
            padding: 80px 20px;
            background: white;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border-top: 4px solid #667eea;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            padding: 60px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-item {
            text-align: center;
            margin-bottom: 30px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 18px;
            opacity: 0.9;
        }

        /* About Section */
        .about {
            padding: 80px 20px;
            background: #f8f9fa;
        }

        .about-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .about h2 {
            font-size: 40px;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .about p {
            font-size: 16px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .features-list {
            list-style: none;
            padding: 0;
        }

        .features-list li {
            padding: 12px 0;
            color: #555;
            border-bottom: 1px solid #e0e0e0;
            font-size: 16px;
        }

        .features-list li:before {
            content: "✓ ";
            color: #27ae60;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .footer p {
            margin: 0;
            opacity: 0.8;
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 42px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 18px;
            color: #666;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 20px auto 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .hero-icon {
                font-size: 60px;
            }

            .section-title h2 {
                font-size: 28px;
            }

            .stat-number {
                font-size: 36px;
            }
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <i class="bi bi-building"></i> Reservasi Wisata
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                    <li class="nav-item">
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

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content fade-in">
            <div class="hero-icon">
                <i class="bi bi-airplane"></i>
            </div>
            <h1>Sistem Reservasi Wisata</h1>
            <p>Platform management profesional untuk mengelola destinasi dan reservasi wisata Anda dengan mudah dan efisien.</p>
            <div>
                @if (Auth::check())
                    <a href="{{ route('admin.dashboard') }}" class="btn-hero">
                        <i class="bi bi-speedometer2"></i> Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-hero">
                        <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
                    </a>
                @endif
                <a href="#features" class="btn-hero" style="background: transparent; border-color: white;">
                    <i class="bi bi-arrow-down"></i> Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container-lg">
            <div class="section-title">
                <h2>Fitur Unggulan</h2>
                <p>Kelola bisnis wisata Anda dengan tools profesional dan mudah digunakan</p>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-map"></i>
                        </div>
                        <h3>Kelola Destinasi</h3>
                        <p>Tambah, edit, dan hapus destinasi wisata dengan mudah. Kelola informasi lengkap tentang lokasi, harga, dan deskripsi.</p>
                        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=500&h=300&fit=crop" alt="Destinasi Wisata" style="width: 100%; border-radius: 10px; margin-top: 15px; object-fit: cover; height: 200px;">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h3>Manajemen Reservasi</h3>
                        <p>Atur reservasi pelanggan dengan sistem yang terorganisir. Pantau status, tanggal, dan detail setiap pemesanan.</p>
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&h=300&fit=crop" alt="Manajemen Reservasi" style="width: 100%; border-radius: 10px; margin-top: 15px; object-fit: cover; height: 200px;">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3>Analytics & Dashboard</h3>
                        <p>Lihat statistik real-time dan visualisasi data dengan grafik interaktif. Pantau performa bisnis Anda.</p>
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=500&h=300&fit=crop" alt="Analytics Dashboard" style="width: 100%; border-radius: 10px; margin-top: 15px; object-fit: cover; height: 200px;">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h3>Keamanan Terjamin</h3>
                        <p>Sistem login aman dengan autentikasi admin. Data Anda terlindungi dengan enkripsi modern.</p>
                        <img src="https://images.unsplash.com/photo-1614694267537-b85ca80c69a7?w=500&h=300&fit=crop" alt="Keamanan" style="width: 100%; border-radius: 10px; margin-top: 15px; object-fit: cover; height: 200px;">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h3>Responsive Design</h3>
                        <p>Akses sistem dari mana saja dengan smartphone, tablet, atau desktop. Interface yang user-friendly.</p>
                        <img src="https://images.unsplash.com/photo-1512941691920-25bda36dc643?w=500&h=300&fit=crop" alt="Responsive" style="width: 100%; border-radius: 10px; margin-top: 15px; object-fit: cover; height: 200px;">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning"></i>
                        </div>
                        <h3>Performa Cepat</h3>
                        <p>Sistem yang responsif dan loading time cepat. Bekerja tanpa hambatan dengan performa optimal.</p>
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=1172&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Performa" style="width: 100%; border-radius: 10px; margin-top: 15px; object-fit: cover; height: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">5+</div>
                        <div class="stat-label">Destinasi Wisata</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">70+</div>
                        <div class="stat-label">Reservasi Terproses</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Uptime Server</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-content">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div style="text-align: center;">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&h=400&fit=crop" alt="Tentang Kami" style="border-radius: 15px; width: 100%; object-fit: cover; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                    </div>
                </div>

                <div class="col-md-6">
                    <h2>Tentang Sistem Kami</h2>
                    <p>Sistem Reservasi Wisata adalah solusi modern untuk mengelola bisnis pariwisata Anda dengan efisien dan profesional. Kami menyediakan platform yang user-friendly dengan fitur-fitur lengkap yang Anda butuhkan.</p>

                    <h4 style="color: #2c3e50; margin-top: 30px; margin-bottom: 20px; font-weight: bold;">Keunggulan Kami:</h4>
                    <ul class="features-list">
                        <li>Dashboard intuitif dengan analytics real-time</li>
                        <li>Manajemen destinasi yang komprehensif</li>
                        <li>Sistem reservasi yang terorganisir</li>
                        <li>Keamanan data tingkat enterprise</li>
                        <li>Interface responsive untuk semua perangkat</li>
                        <li>Support dan dokumentasi lengkap</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <div class="footer" id="contact">
        <div class="container-lg">
            <p><strong>Sistem Reservasi Wisata © 2025</strong></p>
            <p style="margin-top: 10px;">Kelola bisnis wisata Anda dengan mudah dan profesional</p>
            <p style="margin-top: 15px; font-size: 14px;">
                <i class="bi bi-envelope"></i> Email: admin@wisata.com | 
                <i class="bi bi-telephone"></i> Telp: +62 812-3456-7890
            </p>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
