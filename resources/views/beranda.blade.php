<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi Wisata</title>
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
            color: #333;
        }
        
        .navbar {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-links {
            display: flex;
            gap: 20px;
        }
        
        .navbar-links a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .navbar-links a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .hero {
            min-height: calc(100vh - 60px);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
        }
        
        .hero-content {
            max-width: 600px;
        }
        
        .hero h2 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            line-height: 1.6;
        }
        
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 15px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-block;
        }
        
        .btn-primary {
            background: white;
            color: #667eea;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .hero h2 {
                font-size: 32px;
            }
            
            .hero p {
                font-size: 16px;
            }
            
            .navbar {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🏖️ Sistem Reservasi Wisata</h1>
        <div class="navbar-links">
            @auth
                <span>{{ auth()->user()->username }}</span>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button style="background: none; border: none; color: white; cursor: pointer; padding: 8px 15px; border-radius: 5px; transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='none'">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
            <a href="/about">About</a>
        </div>
    </div>
    
    <div class="hero">
        <div class="hero-content">
            <h2>Jelajahi Destinasi Wisata Impian Anda</h2>
            <p>Temukan dan pesan paket wisata terbaik dengan harga terjangkau. Nikmati pengalaman perjalanan yang tak terlupakan bersama kami.</p>
            <div class="buttons">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Masuk</a>
                @else
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Panel Admin</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Mulai Pesan</a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</body>
</html>
