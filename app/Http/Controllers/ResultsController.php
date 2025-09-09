<?php

namespace App\Http\Controllers;

use App\Models\ProcessingResult;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function showIpResults()
    {
        $results = ProcessingResult::where('processing_type', 'ip')->latest()->paginate(50);
        return view('results', ['results' => $results, 'title' => 'IP Processing Results']);
    }

    public function showHashResults()
    {
        $results = ProcessingResult::where('processing_type', 'hash')->latest()->paginate(50);
        return view('results', ['results' => $results, 'title' => 'Hash Processing Results']);
    }
}