<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IpController;
use App\Http\Controllers\HashController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login']);
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'postlogin']);
});

// --- RUTE PUBLIK ---
// Siapa pun bisa mengakses halaman ini tanpa perlu login.
Route::get('/ips', [IpController::class, 'index'])->name('ips.index');
Route::get('/hashes', [HashController::class, 'index'])->name('hashes.index');


// --- RUTE PRIVAT ---
// Hanya user yang sudah login yang bisa mengakses rute di grup ini.
Route::middleware('auth')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::post('/upload', [DashboardController::class, 'store'])->name('upload.store');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});