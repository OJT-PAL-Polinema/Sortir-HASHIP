<?php

namespace App\Http\Controllers;

use App\Models\IpAddress;
use Illuminate\Http\Request;

class IpController extends Controller
{
    /**
     * Menampilkan halaman daftar IP.
     */
    // app/Http/Controllers/IpController.php

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query dasar
        $query = IpAddress::query();

        // Jika ada input pencarian, tambahkan kondisi 'where'
        if ($search) {
            $query->where('ip_address', 'like', '%' . $search . '%');
        }

        // Ambil data setelah difilter (atau tidak), urutkan dari yang terbaru
        $ips = $query->latest()->get();

        $ipCount = $ips->count();
        $lastModified = IpAddress::latest('updated_at')->first();

        return view('ips.index', [
            'ips' => $ips,
            'ipCount' => $ipCount,
            'lastModified' => $lastModified ? $lastModified->updated_at : null,
            'search' => $search // Kirim kata kunci pencarian kembali ke view
        ]);
    }
    
    public function destroy(IpAddress $ipAddress)
    {
        $ipAddress->delete();
        return redirect()->route('ips.index')->with('success', 'Alamat IP berhasil dihapus.');
    }
}