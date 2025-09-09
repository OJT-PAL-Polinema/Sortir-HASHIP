<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ip_address_upload_log', function (Blueprint $table) {
            $table->id();

            // RELASI: Menghubungkan ke ID dari tabel ip_addresses.
            $table->foreignId('ip_address_id')->constrained('ip_addresses')->onDelete('cascade');
            
            // RELASI: Menghubungkan ke ID dari tabel upload_logs.
            $table->foreignId('upload_log_id')->constrained('upload_logs')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_address_upload_log');
    }
};