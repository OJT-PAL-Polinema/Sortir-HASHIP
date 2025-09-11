<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Sisipkan semua CSS Anda dari file welcome.blade.php di sini */
        /* Pastikan .login-container dan styling lainnya ada di sini */
        :root {
            --primary-color: #0d6efd;
            --text-color: #343a40;
            --bg-color: #f8f9fa;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-color); }
        .header { display: flex; justify-content: space-between; align-items: center; background-color: #fff; padding: 10px 40px; border-bottom: 1px solid #dee2e6; }
        .nav { display: flex; gap: 30px; }
        .nav a { text-decoration: none; color: #555; font-weight: 600; padding: 10px 0; border-bottom: 3px solid transparent; }
        .nav a.active { color: var(--primary-color); border-bottom-color: var(--primary-color); }
        .user-profile { display: flex; align-items: center; gap: 15px; }
        .user-profile a { font-weight: 600; text-decoration: none; }
        
        .login-wrapper { display: flex; justify-content: center; align-items: center; height: calc(100vh - 70px); }
        .login-container { background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; color: #555; font-weight: 500; }
        .input-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: var(--primary-color); border: none; border-radius: 4px; color: white; font-size: 16px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

    {{-- Header Universal disisipkan di sini --}}
    <header class="header">
        <nav class="nav">
            <a href="{{ route('home') }}">HOME</a>
            <a href="{{ route('ips.index') }}">IP</a>
            <a href="{{ route('hashes.index') }}">HASH</a>
        </nav>
        <div class="user-profile">
            @guest
                {{-- Tampilkan tombol Login karena user adalah tamu --}}
                <a href="{{ route('login') }}">Login</a>
            @endguest
        </div>
    </header>

    <div class="login-wrapper">
        <div class="login-container">
            <h2>Login Akun</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <span style="color: red; font-size: 14px;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

</body>
</html>