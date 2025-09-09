<?php

namespace App\Console\Commands;

use App\Models\ProcessingResult;
use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\Log;

class CsvProcessorCommand extends Command
{
    protected $signature = 'csv:process {file} {original_filename} {--type=}';
    protected $description = 'Processes a CSV file based on a specific logic type (ip or hash) and saves results to the DB.';

    public function handle()
    {
        $filePath = $this->argument('file');
        $originalFilename = $this->argument('original_filename');
        $processingType = $this->option('type'); // 'ip' or 'hash'

        if (!in_array($processingType, ['ip', 'hash'])) {
            $this->error("Invalid processing type specified. Must be 'ip' or 'hash'.");
            return 1;
        }

        $this->info("Starting {$processingType} processing for: {$originalFilename}");

        $fileHandle = fopen(storage_path('app/' . $filePath), 'r');
        $headers = fgetcsv($fileHandle);
        $rowCount = 1;
        $uniqueValues = [];

        while (($row = fgetcsv($fileHandle)) !== false) {
            $rowCount++;
            $data = array_combine($headers, $row);

            $status = 'processed';
            $message = null;

            // --- SPLIT LOGIC ---
            switch ($processingType) {
                case 'ip':
                    $ipColumn = 'source_ip'; // IMPORTANT: Change to your IP column name
                    $uniqueColumn = 'source_ip';
                    if (filter_var($data[$ipColumn] ?? '', FILTER_VALIDATE_IP) === false) {
                        $status = 'failed_invalid';
                        $message = "Invalid IP address: " . ($data[$ipColumn] ?? 'NULL');
                    }
                    break;
                
                case 'hash':
                    $hashColumn = 'file_hash'; // IMPORTANT: Change to your hash column name
                    $uniqueColumn = 'file_hash';
                    if (!preg_match('/^([a-f0-9]{32}|[a-f0-9]{40}|[a-f0-9]{64})$/i', $data[$hashColumn] ?? '')) {
                        $status = 'failed_invalid';
                        $message = "Invalid hash format.";
                    }
                    break;
            }

            // Check for duplicates if the row is still valid
            if ($status === 'processed') {
                $value = $data[$uniqueColumn] ?? null;
                if (isset($uniqueValues[$value])) {
                    $status = 'failed_duplicate';
                    $message = "Duplicate value: {$value}";
                }
                $uniqueValues[$value] = true;
            }

            // Save the result of this row to the database
            ProcessingResult::create([
                'processing_type' => $processingType,
                'original_filename' => $originalFilename,
                'row_number' => $rowCount,
                'data' => $data,
                'status' => $status,
                'message' => $message,
            ]);
        }
        
        fclose($fileHandle);
        $this->info("Finished processing {$originalFilename}. Results saved to database.");
        return 0;
    }
}