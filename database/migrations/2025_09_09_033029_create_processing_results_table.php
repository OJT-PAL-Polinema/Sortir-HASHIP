<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // xxxx_xx_xx_xxxxxx_create_processing_results_table.php

public function up(): void
{
    Schema::create('processing_results', function (Blueprint $table) {
        $table->id();
        $table->string('processing_type'); // 'ip' or 'hash'
        $table->string('original_filename');
        $table->unsignedInteger('row_number');
        $table->json('data'); // Store the original row data as JSON
        $table->string('status'); // 'processed', 'failed_duplicate', 'failed_invalid'
        $table->string('message')->nullable(); // Reason for failure
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_results');
    }
};
