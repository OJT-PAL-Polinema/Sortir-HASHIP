<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function login()
    {
        // Jika user sudah login, langsung arahkan ke halaman home
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string', // <-- Menggunakan 'username' sesuai tabel users
            'password' => 'required|string',
        ]);

        // Mengambil kredensial dari request
        $credentials = $request->only('username', 'password');

        // Mencoba untuk melakukan autentikasi
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Jika berhasil, kirim respons JSON untuk di-handle oleh JavaScript
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
                'redirect' => url('/home')
            ]);
        }

        // Jika gagal, kirim respons JSON dengan pesan error
        return response()->json([
            'status' => false,
            'message' => 'Login Gagal! Username atau password salah.'
        ]);
    }

    /**
     * Memproses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}