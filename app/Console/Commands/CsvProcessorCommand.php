<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;

class CsvProcessorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * 'file' is a required argument for the CSV path.
     * --unique: Optional flag to specify a column for duplicate checking.
     * --validate-ip: Optional flag to specify a column to validate as an IP address.
     * --validate-hash: Optional flag to specify a column to validate as a hash (MD5, SHA1, SHA256).
     *
     * @var string
     */
    protected $signature = 'csv:process {file}
                            {--unique= :The column name to check for duplicates}
                            {--validate-ip= :The column to validate as an IP address}
                            {--validate-hash= :The column to validate as a hash (MD5, SHA1, SHA256)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A robust command to process a CSV file with validation and duplicate checking';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // --- 1. RETRIEVE AND VALIDATE INPUTS ---
            $filePath = $this->argument('file');
            $uniqueColumn = $this->option('unique');
            $ipColumn = $this->option('validate-ip');
            $hashColumn = $this->option('validate-hash');

            if (!file_exists($filePath)) {
                $this->error("File does not exist at path: {$filePath}");
                return 1; // Indicate failure
            }

            // --- 2. OPEN FILE AND READ HEADERS ---
            $fileHandle = fopen($filePath, 'r');
            if ($fileHandle === false) {
                $this->error("Unable to open the file: {$filePath}");
                return 1;
            }

            $headers = fgetcsv($fileHandle);
            if ($headers === false) {
                $this->error("Could not read CSV headers. The file might be empty or corrupted.");
                fclose($fileHandle);
                return 1;
            }

            // --- 3. INITIALIZE COUNTERS AND TRACKERS ---
            $this->info("Starting CSV processing for: " . basename($filePath));
            $counters = [
                'processed' => 0,
                'duplicates' => 0,
                'invalid_ip' => 0,
                'invalid_hash' => 0,
            ];
            $uniqueValues = []; // Used to track values for duplicate checking
            $rowCount = 1;      // Start at 1 to account for the header row

            // --- 4. PROCESS FILE ROW BY ROW ---
            while (($row = fgetcsv($fileHandle)) !== false) {
                $rowCount++;
                // Create an associative array (header => value) for the current row
                $data = array_combine($headers, $row);

                // --- VALIDATION PIPELINE ---

                // A. IP Address Validation
                if ($ipColumn && filter_var($data[$ipColumn] ?? '', FILTER_VALIDATE_IP) === false) {
                    $this->warn("Skipping row {$rowCount}: Invalid IP '{$data[$ipColumn]}' in column '{$ipColumn}'.");
                    $counters['invalid_ip']++;
                    continue; // Skip to the next row
                }

                // B. Hash Format Validation (MD5, SHA1, SHA256)
                if ($hashColumn && !preg_match('/^([a-f0-9]{32}|[a-f0-9]{40}|[a-f0-9]{64})$/i', $data[$hashColumn] ?? '')) {
                    $this->warn("Skipping row {$rowCount}: Invalid hash format in column '{$hashColumn}'.");
                    $counters['invalid_hash']++;
                    continue; // Skip to the next row
                }

                // C. Duplicate Entry Validation
                if ($uniqueColumn) {
                    $value = $data[$uniqueColumn] ?? null;
                    if (isset($uniqueValues[$value])) {
                        $this->warn("Skipping row {$rowCount}: Duplicate value '{$value}' in column '{$uniqueColumn}'.");
                        $counters['duplicates']++;
                        continue; // Skip to the next row
                    }
                    $uniqueValues[$value] = true; // Mark this value as seen
                }

                // --- 5. PROCESS THE VALID DATA ---
                // If the row passes all validations, it reaches this point.
                // Replace this line with your actual business logic (e.g., save to database).
                // For this example, we'll just output the data.
                $this->line("Processing row {$rowCount}: " . json_encode($data));
                $counters['processed']++;

            } // End of while loop

            fclose($fileHandle);

            // --- 6. DISPLAY FINAL SUMMARY ---
            $this->info(PHP_EOL . '--------------------');
            $this->info('  Processing Complete!');
            $this->info('--------------------');
            $this->info("Total Records Processed: {$counters['processed']}");
            $this->warn("Skipped Duplicate Records: {$counters['duplicates']}");
            $this->warn("Skipped Invalid IP Records: {$counters['invalid_ip']}");
            $this->warn("Skipped Invalid Hash Records: {$counters['invalid_hash']}");
            $this->info('--------------------');

            return 0; // Indicate success

        } catch (Exception $e) {
            // Catch any unexpected errors during processing
            $this->error("An unexpected error occurred: " . $e->getMessage());
            Log::error("CSV Processing Failed: " . $e); // Log the full error
            return 1; // Indicate failure
        }
    }
}
