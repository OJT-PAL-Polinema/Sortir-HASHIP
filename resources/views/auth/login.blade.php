<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* CSS untuk tampilan form */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Penting agar padding tidak menambah lebar */
            transition: border-color 0.2s;
        }
        .input-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #0056b3;
        }
        #error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
            display: none; /* Sembunyikan secara default */
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login Akun</h2>
        <form action="{{ url('login') }}" method="POST" id="loginForm">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div id="error-message"></div>
    </div>

    <script>
        // --- JavaScript untuk menangani proses login ---

        // 1. Ambil elemen form dan pesan error dari HTML
        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('error-message');

        // 2. Tambahkan event listener untuk event 'submit' pada form
        loginForm.addEventListener('submit', async function(event) {
            // Mencegah form melakukan submit standar (refresh halaman)
            event.preventDefault();

            // Sembunyikan pesan error sebelumnya
            errorMessage.style.display = 'none';

            // 3. Ambil data dari input form
            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                // 4. Kirim data ke API menggunakan fetch
                const response = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                // Ubah respons menjadi format JSON
                const result = await response.json();

                // 5. Cek apakah respons dari server OK (status code 200-299)
                if (response.ok) {
                    // Jika login berhasil:
                    console.log('Login Berhasil:', result);
                    
                    // Simpan access_token ke localStorage browser
                    localStorage.setItem('access_token', result.access_token);
                    
                    // Arahkan (redirect) pengguna ke halaman home
                    window.location.href = '/home'; // Ganti '/home' jika halaman tujuan Anda berbeda

                } else {
                    // Jika login gagal (misal: status code 401 Unauthorized):
                    throw new Error(result.error || 'Username atau password salah!');
                }

            } catch (error) {
                // 6. Tangani jika terjadi error (gagal login atau masalah jaringan)
                console.error('Error saat login:', error);
                
                // Tampilkan pesan error di halaman
                errorMessage.textContent = error.message;
                errorMessage.style.display = 'block';
            }
        });
    </script>

</body>
</html>