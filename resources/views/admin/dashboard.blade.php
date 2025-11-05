<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Reservasi Wisata</title>
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
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
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
        
        .admin-badge {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
        }
        
        .management {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .management h3 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #e74c3c;
            padding-bottom: 10px;
        }
        
        .management-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .management-links a {
            display: block;
            padding: 15px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            font-weight: 500;
        }
        
        .management-links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }
        
        .user-info {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .user-info h3 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #e74c3c;
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
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Sistem Reservasi Wisata <span class="admin-badge">ADMIN</span></h1>
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
            <h2>Selamat Datang, Admin {{ auth()->user()->username }}! 👨‍💼</h2>
            <p>Kelola sistem reservasi wisata dari panel admin ini.</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Reservasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Destinasi Wisata</div>
            </div>
        </div>
        
        <div class="management">
            <h3>📋 Menu Manajemen</h3>
            <div class="management-links">
                <a href="#">Kelola Users</a>
                <a href="#">Kelola Reservasi</a>
                <a href="#">Kelola Destinasi</a>
                <a href="#">Laporan Penjualan</a>
            </div>
        </div>
        
        <div class="user-info">
            <h3>Informasi Admin</h3>
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
                    <value><span style="background: #fadbd8; padding: 5px 10px; border-radius: 3px; color: #c0392b;">{{ ucfirst(auth()->user()->role) }}</span></value>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

