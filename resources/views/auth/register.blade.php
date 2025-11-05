<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Reservasi Wisata</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .links a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .links a:hover {
            color: #764ba2;
        }
        
        .links p {
            color: #999;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Akun</h1>
        
        @if ($errors->any())
            <div style="color: #e74c3c; background-color: #fadbd8; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5b7b1;">
                @foreach ($errors->all() as $error)
                    <p style="margin: 5px 0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="No_Handphone">Nomor Handphone</label>
                <input type="tel" id="No_Handphone" name="No_Handphone" value="{{ old('No_Handphone') }}" placeholder="08xxxxxxxxxx" required>
                @error('No_Handphone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit">Daftar</button>
        </form>
        
        <div class="links">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
            <a href="/">← Kembali ke beranda</a>
        </div>
    </div>
</body>
</html>