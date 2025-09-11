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
    public function index()
    {
        $logs = UploadLog::with('user')->latest()->take(10)->get();
        return view('welcome', ['logs' => $logs]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
            'type' => 'required|in:ip,hash',
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $type = $request->input('type');

        if (!$this->validateFileContent($file, $type)) {
            return back()->with('error', 'Isi file tidak sesuai dengan tipe yang dipilih (IP/Hash).')->withInput();
        }

        // [PERUBAHAN] Inisialisasi variabel untuk menghitung data baru dan duplikat
        $newEntriesCount = 0;
        $duplicateEntriesCount = 0;

        DB::beginTransaction();
        try {
            $uploadLog = new UploadLog();
            $uploadLog->user_id = auth()->id();
            $uploadLog->comment = $request->input('comment');
            $uploadLog->data_type = $type;
            $uploadLog->save();

            $fileHandle = fopen($file->getRealPath(), 'r');

            while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
                $value = trim($row[0]);
                if (empty($value)) {
                    continue;
                }

                $model = null;

                if ($type === 'ip') {
                    $model = IpAddress::firstOrCreate(['ip_address' => $value]);
                } elseif ($type === 'hash') {
                    $model = Hash::firstOrCreate(['hash_value' => $value]);
                }

                if ($model) {
                    // [PERUBAHAN] Cek apakah model baru saja dibuat atau sudah ada sebelumnya
                    if ($model->wasRecentlyCreated) {
                        $newEntriesCount++;
                    } else {
                        $duplicateEntriesCount++;
                    }
                    $uploadLog->{$type === 'ip' ? 'ipAddresses' : 'hashes'}()->syncWithoutDetaching($model->id);
                }
            }

            fclose($fileHandle);
            DB::commit();
            
            // [PERUBAHAN] Buat pesan notifikasi yang dinamis berdasarkan hasil hitungan
            $message = "Proses selesai! {$newEntriesCount} data baru ditambahkan, {$duplicateEntriesCount} duplikat ditemukan dan diabaikan.";

            // [PERUBAHAN] Kirim pesan yang sudah dinamis ke session
            return redirect()->route('home')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Upload Gagal: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memproses file.');
        }
    }

    private function validateFileContent($file, $expectedType): bool
    {
        // ... (kode validasi konten tidak berubah) ...
        $fileHandle = fopen($file->getRealPath(), 'r');
        $isValid = true;
        $linesToSample = 10;
        $linesChecked = 0;

        while (($row = fgetcsv($fileHandle, 1000, ',')) !== false && $linesChecked < $linesToSample) {
            if (!empty($row) && !empty(trim($row[0]))) {
                $value = trim($row[0]);
                $linesChecked++;
                if ($expectedType === 'ip') {
                    if (filter_var($value, FILTER_VALIDATE_IP) === false) {
                        $isValid = false;
                        break;
                    }
                } elseif ($expectedType === 'hash') {
                    if (!ctype_xdigit($value)) {
                        $isValid = false;
                        break;
                    }
                }
            }
        }
        fclose($fileHandle);
        return $isValid;
    }
}