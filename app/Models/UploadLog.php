<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UploadLog extends Model
{
    use HasFactory;

    /**
     * Atribut yang diizinkan untuk diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'comment',
        'data_type',
    ];

    /**
     * RELASI 1: Satu log upload DIMILIKI OLEH satu User.
     * Ini adalah relasi "belongsTo" (milik dari).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELASI 2: Satu log upload bisa memiliki BANYAK IpAddress.
     * Ini adalah relasi "many-to-many" (banyak ke banyak).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ipAddresses(): BelongsToMany
    {
        // Parameter kedua adalah nama tabel pivot yang menghubungkan keduanya.
        return $this->belongsToMany(IpAddress::class, 'ip_address_upload_log');
    }

    /**
     * RELASI 3: Satu log upload bisa memiliki BANYAK Hash.
     * Ini juga relasi "many-to-many".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hashes(): BelongsToMany
    {
        // Parameter kedua adalah nama tabel pivot yang menghubungkan keduanya.
        return $this->belongsToMany(Hash::class, 'hash_upload_log');
    }
}