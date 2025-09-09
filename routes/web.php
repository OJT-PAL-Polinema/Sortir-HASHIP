<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CsvUploadController;

// Route to show the upload form
Route::get('/upload-csv', [CsvUploadController::class, 'create'])->name('csv.upload.form');

// Route to handle the form submission
Route::post('/upload-csv', [CsvUploadController::class, 'store'])->name('csv.upload.store');