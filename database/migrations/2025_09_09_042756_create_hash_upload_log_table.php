<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hash_upload_log', function (Blueprint $table) {
            $table->id();

            // RELASI: Menghubungkan ke ID dari tabel hashes.
            $table->foreignId('hash_id')->constrained('hashes')->onDelete('cascade');
            
            // RELASI: Menghubungkan ke ID dari tabel upload_logs.
            $table->foreignId('upload_log_id')->constrained('upload_logs')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hash_upload_log');
    }
};