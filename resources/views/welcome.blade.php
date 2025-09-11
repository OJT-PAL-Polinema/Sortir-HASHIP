<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* CSS Variables for easy theming */
        :root {
            --primary-color: #0d6efd;
            --primary-hover: #0b5ed7;
            --text-color: #343a40;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --border-color: #dee2e6;
            --gray-light: #e9ecef;
        }

        /* General Styling */
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-color); }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        
        /* Header / Navbar */
        .header { display: flex; justify-content: space-between; align-items: center; background-color: var(--card-bg); padding: 10px 40px; border-bottom: 1px solid var(--border-color); }
        .nav { display: flex; gap: 30px; }
        .nav a { text-decoration: none; color: #555; font-weight: 600; padding: 10px 0; border-bottom: 3px solid transparent; transition: color 0.2s, border-color 0.2s; }
        .nav a:hover { color: var(--primary-color); }
        .nav a.active { color: var(--primary-color); border-bottom-color: var(--primary-color); }
        
        .user-profile { display: flex; align-items: center; gap: 15px; }
        .user-profile span { font-weight: 600; }
        .user-profile form { margin: 0; }
        .logout-btn { background-color: transparent; border: 1px solid var(--border-color); padding: 8px; border-radius: 5px; cursor: pointer; display: flex; align-items: center; transition: background-color 0.2s; }
        .logout-btn:hover { background-color: #f1f1f1; }

        /* Main Content */
        .main-content { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 30px; }
        .card { background-color: var(--card-bg); padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .card h3 { margin-top: 0; }

        /* Time Display */
        .time-display { display: flex; gap: 10px; margin-bottom: 20px; }
        .time-display span { background-color: var(--gray-light); padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 500; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group textarea, .form-group input { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 5px; box-sizing: border-box; transition: border-color 0.2s, box-shadow 0.2s; }
        .form-group textarea:focus, .form-group input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15); }
        .form-group textarea { height: 100px; resize: vertical; }
        .radio-group { display: flex; gap: 20px; margin-bottom: 20px; }

        /* [PERBAIKAN] Custom styling for the file input */
        .file-input-wrapper { position: relative; border: 2px dashed var(--border-color); border-radius: 8px; padding: 30px; text-align: center; cursor: pointer; transition: border-color 0.2s, background-color 0.2s; }
        .file-input-wrapper:hover { border-color: var(--primary-color); background-color: #fdfdff; }
        .file-input-label { color: #6c757d; font-weight: 500; }
        .file-input-name { margin-top: 10px; font-style: italic; color: var(--primary-color); font-weight: bold; }
        #fileInput { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }

        .submit-btn { background-color: var(--primary-color); color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 16px; cursor: pointer; font-weight: 600; transition: background-color 0.2s, transform 0.1s; }
        .submit-btn:hover { background-color: var(--primary-hover); }
        .submit-btn:active { transform: scale(0.98); }
        
        .history-table { width: 100%; border-collapse: collapse; }
        .history-table th, .history-table td { padding: 12px; text-align: left; border-bottom: 1px solid var(--border-color); }
        .history-table th { background-color: var(--bg-color); }
        
        .notification { padding: 15px; margin-bottom: 20px; border-radius: 5px; color: #fff; text-align: center; }
        .notification.success { background-color: #198754; }
        .notification.error { background-color: #dc3545; }
    </style>
</head>
<body>
        <header class="header">
            <nav class="nav">
                <a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">HOME</a>
                <a href="{{ route('ips.index') }}" class="{{ Route::is('ips.index') ? 'active' : '' }}">IP</a>
                <a href="{{ route('hashes.index') }}" class="{{ Route::is('hashes.index') ? 'active' : '' }}">HASH</a>
            </nav>
            <div class="user-profile">
                @auth
                    {{-- Bagian ini HANYA akan tampil jika user sudah login --}}
                    <span>{{ Auth::user()->username }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn" title="Logout">
                            <img alt=" logout" height="20" src="{{ asset('assets/logouticon.png') }}" width="20" />
                        </button>
                    </form>
                @endauth

                @guest
                    {{-- Bagian ini HANYA akan tampil jika user belum login --}}
                    <a href="{{ route('login') }}" style="font-weight: 600; text-decoration: none;">Login</a>
                @endguest
            </div>
        </header>

    <div class="container">
        @if (session('success'))
            <div class="notification success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="notification error">{{ session('error') }}</div>
        @endif

        <main class="main-content">
            <section class="upload-section card">
                <div class="time-display">
                    <span>{{ now()->format('d F Y') }}</span>
                    <span>{{ now()->format('h:i A') }}</span>
                </div>
                <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">        
                    @csrf
                    <div class="form-group">
                        <label for="comment">Komentar</label>
                        <textarea id="comment" name="comment" required>{{ old('comment') }}</textarea>
                    </div>
                    <div class="radio-group">
                        <label><input type="radio" name="type" value="ip" checked> Ip</label>
                        <label><input type="radio" name="type" value="hash"> Hash</label>
                    </div>
                    
                    <div class="form-group">
                        <label for="fileInput" class="file-input-wrapper">
                            <span class="file-input-label">Click or Drag File to Upload</span>
                            <div class="file-input-name" id="fileName"></div>
                            <input type="file" id="fileInput" name="file" required>
                        </label>
                    </div>

                    <button type="submit" class="submit-btn">Kirim</button>
                </form>
            </section>
            
            <section class="history-section card">
                <h3>Riwayat</h3>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->user->username }}</td>
                                <td>{{ $log->comment }}</td>
                                <td>{{ $log->created_at->format('d F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center;">Belum ada riwayat upload.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        // JavaScript untuk menampilkan nama file yang dipilih
        const fileInput = document.getElementById('fileInput');
        const fileNameEl = document.getElementById('fileName');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameEl.textContent = this.files[0].name;
            } else {
                fileNameEl.textContent = '';
            }
        });
    </script>
</body>
</html>