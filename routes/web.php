<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\CsvUploadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;



Route::get('/', [AuthController::class, 'login']);
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/home', [WelcomeController::class, 'index']);

// Route to show the upload form
Route::get('/upload-csv', [CsvUploadController::class, 'create'])->name('csv.upload.form');

// Route to handle the form submission
Route::post('/upload-csv', [CsvUploadController::class, 'store'])->name('csv.upload.store');
Route::get('/results/ip', [ResultsController::class, 'showIpResults'])->name('results.ip');
Route::get('/results/hash', [ResultsController::class, 'showHashResults'])->name('results.hash');