<?php

namespace App\Http\Controllers;

use App\Models\Hash; // <-- Gunakan model Hash
use Illuminate\Http\Request;

class HashController extends Controller
{
    /**
     * Menampilkan halaman daftar Hash.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query dasar
        $query = Hash::query();

        // Jika ada input pencarian, tambahkan kondisi 'where'
        if ($search) {
            $query->where('hash_value', 'like', '%' . $search . '%');
        }

        $hashes = $query->latest()->get();

        $hashCount = $hashes->count();
        $lastModified = Hash::latest('updated_at')->first();

        return view('hashes.index', [
            'hashes' => $hashes,
            'hashCount' => $hashCount,
            'lastModified' => $lastModified ? $lastModified->updated_at : null ,
            'search' => $search 
        ]);
    }

    public function destroy(Hash $hash)
    {
        $hash->delete();
        return redirect()->route('hashes.index')->with('success', 'Hash berhasil dihapus.');
    }
}