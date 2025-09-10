<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IpAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Kolom 'ip_address' diizinkan untuk diisi secara massal,
     * ini penting untuk fungsi firstOrCreate().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip_address',
    ];

    /**
     * Mendefinisikan relasi Many-to-Many ke UploadLog.
     * Satu IP bisa muncul di BANYAK sesi upload.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function uploadLogs(): BelongsToMany
    {
        // Parameter kedua ('ip_address_upload_log') adalah nama tabel pivot-nya.
        return $this->belongsToMany(UploadLog::class, 'ip_address_upload_log');
    }
}