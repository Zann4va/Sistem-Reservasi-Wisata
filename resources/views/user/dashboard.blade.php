<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - Sistem Reservasi Wisata</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .navbar-links a,
        .navbar-links form button {
            color: white;
            text-decoration: none;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .navbar-links a:hover,
        .navbar-links form button:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .welcome-card h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: #666;
            font-size: 16px;
        }
        
        .user-info {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .user-info h3 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            gap: 40px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .info-item {
            flex: 1;
            min-width: 250px;
        }
        
        .info-item label {
            display: block;
            color: #999;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .info-item value {
            display: block;
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }
        
        .reservations {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .reservations h3 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }
        
        .empty-state svg {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Sistem Reservasi Wisata</h1>
        <div class="navbar-links">
            <a href="/">Home</a>
            <a href="/about">About</a>
            <span>{{ auth()->user()->username }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-card">
            <h2>Selamat Datang, {{ auth()->user()->username }}! 👋</h2>
            <p>Anda login sebagai Customer. Kelola reservasi wisata Anda di sini.</p>
        </div>
        
        <div class="user-info">
            <h3>Informasi Akun</h3>
            <div class="info-row">
                <div class="info-item">
                    <label>Username</label>
                    <value>{{ auth()->user()->username }}</value>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <value>{{ auth()->user()->email }}</value>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <label>Nomor Handphone</label>
                    <value>{{ auth()->user()->No_Handphone }}</value>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <value><span style="background: #d4edda; padding: 5px 10px; border-radius: 3px; color: #155724;">{{ ucfirst(auth()->user()->role) }}</span></value>
                </div>
            </div>
        </div>
        
        <div class="reservations">
            <h3>Riwayat Reservasi</h3>
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Belum ada reservasi. Mulai pesan wisata favorit Anda!</p>
            </div>
        </div>
    </div>
</body>
</html>
