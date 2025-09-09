<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUploadedCsv;
use Illuminate\Http\Request;

class CsvUploadController extends Controller
{
    public function create()
    {
        return view('csv_upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'processing_type' => 'required|in:ip,hash', // Validate the radio button value
        ]);

        $file = $request->file('csv_file');
        $processingType = $request->input('processing_type');
        
        $originalFilename = $file->getClientOriginalName();
        $path = $file->store('uploads');

        // Dispatch the job with the file path AND the processing type
        ProcessUploadedCsv::dispatch($path, $originalFilename, $processingType);

        return back()->with('success', "File is being processed as '{$processingType}' type!");
    }
}