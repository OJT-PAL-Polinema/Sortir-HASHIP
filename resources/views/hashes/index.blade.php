<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hash List</title>
    <style>
        /* Sisipkan semua CSS Anda di sini, sama seperti di file welcome.blade.php */
        :root {
            --primary-color: #0d6efd;
            --text-color: #343a40;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --border-color: #dee2e6;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-color); }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
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
        .list-card { background-color: var(--card-bg); padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 600px; margin: 40px auto; }
        .list-card h2 { margin-top: 0; margin-bottom: 20px; font-size: 24px; }
        .metadata-table { width: 100%; margin-bottom: 25px; font-size: 15px; }
        .metadata-table td { padding: 8px 0; }
        .metadata-table td:first-child { color: #6c757d; width: 120px; }
        .metadata-table td:last-child { font-weight: 600; }
        .ip-list { display: flex; flex-direction: column; gap: 10px; }
        .ip-item { padding: 15px; border: 1px solid var(--border-color); border-radius: 5px; background-color: #f8f9fa; font-family: monospace; }
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
        <div class="list-card">
            <h2>List Hash</h2>
            
            <table class="metadata-table">
                <tbody>
                    <tr>
                        <td>Last Modified</td>
                        <td>
                            @if($lastModified)
                                {{ $lastModified->format('d F Y H:i:s') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Result Contains</td>
                        <td>{{ $hashCount }} entries</td>
                    </tr>
                </tbody>
            </table>

            <div class="ip-list">
                @forelse ($hashes as $hash)
                    <div class="ip-item">{{ $hash->hash_value }}</div>
                @empty
                    <div class="ip-item">Belum ada data Hash yang tersimpan.</div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>