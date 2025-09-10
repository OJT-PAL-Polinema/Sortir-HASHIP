<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hash extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Kolom 'hash_value' diizinkan untuk diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash_value',
    ];

    /**
     * Mendefinisikan relasi Many-to-Many ke UploadLog.
     * Satu Hash bisa muncul di BANYAK sesi upload.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function uploadLogs(): BelongsToMany
    {
        // Parameter kedua ('hash_upload_log') adalah nama tabel pivot-nya.
        return $this->belongsToMany(UploadLog::class, 'hash_upload_log');
    }
}