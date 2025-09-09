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

    /**
     * Create a new job instance.
     *
     * @param string $filePath The path to the CSV file to be processed.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Job starting: Processing CSV at {$this->filePath}");

        // Call the Artisan command programmatically.
        // We pass the file path and any other options your command needs.
        Artisan::call('csv:process', [
            'file' => $this->filePath,
            '--validate-ip' => 'source_ip', // Example: Hardcode options or pass them in constructor
            '--unique' => 'transaction_id' // Example
        ]);

        Log::info("Job finished: " . Artisan::output());
    }
}