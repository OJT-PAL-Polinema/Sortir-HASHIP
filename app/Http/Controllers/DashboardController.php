<?php

namespace App\Http\Controllers;

use App\Models\Hash;
use App\Models\IpAddress;
use App\Models\UploadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama beserta data riwayat.
     */
    public function index()
    {
        $logs = UploadLog::with('user')->latest()->take(10)->get();
        return view('welcome', ['logs' => $logs]); // Pastikan nama view Anda 'welcome.blade.php'
    }

    /**
     * Fungsi utama untuk membaca file CSV, menyimpan data tanpa duplikat.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input dari Form
        $request->validate([
            'comment' => 'required|string|max:255',
            'type' => 'required|in:ip,hash', // Pastikan tipenya hanya ip atau hash
            'file' => 'required|file|mimes:csv,txt' // Pastikan file adalah CSV atau TXT
        ]);

        $file = $request->file('file');
        $type = $request->input('type');

        // Gunakan Transaction untuk memastikan semua data berhasil disimpan atau tidak sama sekali
        DB::beginTransaction();
        try {
            // 2. Buat catatan di tabel upload_logs terlebih dahulu
            $uploadLog = new UploadLog();
            $uploadLog->user_id = auth()->id();
            $uploadLog->comment = $request->input('comment');
            $uploadLog->data_type = $type;
            $uploadLog->save();

            // 3. Buka dan baca file CSV baris per baris
            $fileHandle = fopen($file->getRealPath(), 'r');

            // Loop untuk membaca setiap baris di file CSV
            while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
                // Asumsikan data penting ada di kolom pertama (indeks 0)
                $value = trim($row[0]);
                
                if (empty($value)) {
                    continue; // Lewati baris kosong
                }

                $model = null;

                if ($type === 'ip') {
                    // 4a. Cari IP, atau buat baru jika belum ada. Ini adalah inti dari logika "tanpa duplikat".
                    $model = IpAddress::firstOrCreate(['ip_address' => $value]);
                    // 5a. Hubungkan IP ini ke log upload melalui tabel pivot
                    $uploadLog->ipAddresses()->syncWithoutDetaching($model->id);

                } elseif ($type === 'hash') {
                    // 4b. Cari Hash, atau buat baru jika belum ada.
                    $model = Hash::firstOrCreate(['hash_value' => $value]);
                    // 5b. Hubungkan Hash ini ke log upload melalui tabel pivot
                    $uploadLog->hashes()->syncWithoutDetaching($model->id);
                }
            }

            fclose($fileHandle);
            
            // Jika semua berhasil, simpan perubahan ke database
            DB::commit();

            return redirect()->route('home')->with('success', 'File berhasil di-upload dan diproses!');

        } catch (\Exception $e) {
            // Jika ada error di tengah jalan, batalkan semua yang sudah dilakukan
            DB::rollBack();
            Log::error('Upload Gagal: ' . $e->getMessage()); // Catat error untuk debugging

            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memproses file.');
        }
    }
}