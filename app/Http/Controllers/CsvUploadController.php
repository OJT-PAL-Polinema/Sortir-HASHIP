<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUploadedCsv;
use Illuminate\Http\Request;

class CsvUploadController extends Controller
{
    /**
     * Show the form for uploading a CSV file.
     */
    public function create()
    {
        // This would return a view with an HTML form
        return view('csv_upload');
    }

    /**
     * Store the uploaded CSV and dispatch the processing job.
     */
    public function store(Request $request)
    {
        // 1. Validate the request
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt', // Ensure it's a CSV
        ]);

        // 2. Store the file in the 'storage/app/uploads' directory
        $path = $request->file('csv_file')->store('uploads');

        // 3. Dispatch the job to the queue
        ProcessUploadedCsv::dispatch($path);

        // 4. Redirect back with a success message
        return back()->with('success', 'Your file has been uploaded and is being processed!');
    }
}