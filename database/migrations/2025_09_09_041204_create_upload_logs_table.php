<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upload_logs', function (Blueprint $table) {
            $table->id();
            
            // RELASI: Menghubungkan log ini ke user yang mengupload.
            // Jika user dihapus, semua log miliknya juga akan terhapus (onDelete('cascade')).
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->text('comment')->nullable();
            $table->enum('data_type', ['ip', 'hash']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upload_logs');
    }
};