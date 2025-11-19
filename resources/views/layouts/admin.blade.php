<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Reservasi Wisata Admin</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --sidebar-color: #34495e;
            --accent-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ecf0f1;
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--sidebar-color) 100%);
            color: white;
            padding: 20px;
            min-height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
        }

        .sidebar-header h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 10px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .nav-menu a:hover {
            background: rgba(52, 152, 219, 0.2);
            padding-left: 20px;
        }

        .nav-menu a.active {
            background: var(--accent-color);
            color: white;
        }

        .nav-menu a i {
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-left h2 {
            font-size: 24px;
            color: var(--primary-color);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .logout-btn {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        /* Content Area */
        .content {
            padding: 30px;
            flex: 1;
        }

        /* Cards */
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .stat-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .stat-card-content h5 {
            color: #7f8c8d;
            font-size: 13px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .stat-card-content h3 {
            color: var(--primary-color);
            font-size: 28px;
            margin: 0;
            font-weight: bold;
        }

        /* Alert */
        .alert-container {
            margin-bottom: 20px;
        }

        /* Table */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table-container table {
            margin: 0;
        }

        .table-container thead {
            background: #f8f9fa;
        }

        .table-container thead th {
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table-container tbody tr:hover {
            background: #f8f9fa;
        }

        .btn-action {
            padding: 5px 10px;
            font-size: 12px;
            margin: 0 2px;
        }

        /* Forms */
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        /* Button */
        .btn-primary {
            background: var(--accent-color);
            border: none;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-success {
            background: var(--success-color);
            border: none;
        }

        .btn-success:hover {
            background: #229954;
        }

        .btn-danger {
            background: var(--danger-color);
            border: none;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .topbar {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
                margin-bottom: 20px;
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 15px;
            }

            .table-container {
                overflow-x: auto;
            }
        }
    </style>

    @yield('extra-css')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="bi bi-building"></i> Reservasi Wisata</h3>
            <p>Admin Panel</p>
        </div>

        <ul class="nav-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.destinations.index') }}" class="@if(Route::currentRouteName() === 'admin.destinations.index' || Route::currentRouteName() === 'admin.destinations.create' || Route::currentRouteName() === 'admin.destinations.edit') active @endif">
                    <i class="bi bi-map"></i> Destinasi
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reservations.index') }}" class="@if(Route::currentRouteName() === 'admin.reservations.index' || Route::currentRouteName() === 'admin.reservations.create' || Route::currentRouteName() === 'admin.reservations.edit') active @endif">
                    <i class="bi bi-calendar-check"></i> Reservasi
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <h2>@yield('page-title', 'Dashboard')</h2>
            </div>
            <div class="topbar-right">
                <div class="user-info">
                    <span>{{ Auth::user()->username ?? 'Admin' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @if ($errors->any())
                <div class="alert-container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Ada kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="alert-container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    @yield('extra-js')
</body>
</html>
