<?php

namespace App\Http\Controllers;

use App\Models\Hash; // <-- Gunakan model Hash
use Illuminate\Http\Request;

class HashController extends Controller
{
    /**
     * Menampilkan halaman daftar Hash.
     */
    public function index()
    {
        // 1. Ambil semua data Hash, urutkan dari yang terbaru
        $hashes = Hash::latest()->get();

        // 2. Hitung jumlah total Hash
        $hashCount = $hashes->count();

        // 3. Cari kapan data terakhir diubah/ditambahkan
        $lastModified = Hash::latest('updated_at')->first();

        // 4. Kirim semua data ke view 'hashes.index'
        return view('hashes.index', [
            'hashes' => $hashes,
            'hashCount' => $hashCount,
            'lastModified' => $lastModified ? $lastModified->updated_at : null
        ]);
    }
}