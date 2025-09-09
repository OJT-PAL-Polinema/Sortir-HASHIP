<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ProcessUploadedCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $originalFilename;
    protected $processingType;

    public function __construct(string $filePath, string $originalFilename, string $processingType)
    {
        $this->filePath = $filePath;
        $this->originalFilename = $originalFilename;
        $this->processingType = $processingType;
    }

    public function handle(): void
    {
        Log::info("Job starting for {$this->originalFilename}, type: {$this->processingType}");

        Artisan::call('csv:process', [
            'file' => $this->filePath,
            'original_filename' => $this->originalFilename,
            '--type' => $this->processingType,
        ]);

        Log::info("Job finished for {$this->originalFilename}. Output: " . Artisan::output());
    }
}