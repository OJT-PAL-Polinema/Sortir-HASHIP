<?php

namespace App\Http\Controllers;

use App\Models\IpAddress;
use Illuminate\Http\Request;

class IpController extends Controller
{
    /**
     * Menampilkan halaman daftar IP.
     */
    public function index()
    {
        // 1. Ambil semua data IP, urutkan dari yang terbaru
        $ips = IpAddress::latest()->get();

        // 2. Hitung jumlah total IP
        $ipCount = $ips->count();

        // 3. Cari kapan data terakhir diubah/ditambahkan
        $lastModified = IpAddress::latest('updated_at')->first();

        // 4. Kirim semua data ke view
        return view('ips.index', [
            'ips' => $ips,
            'ipCount' => $ipCount,
            'lastModified' => $lastModified ? $lastModified->updated_at : null
        ]);
    }
}