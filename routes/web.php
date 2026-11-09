<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\AuthController;

// Route Autentikasi (Login & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Terproteksi (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('/', [ScannerController::class, 'index'])->name('home');
    Route::post('/scan', [ScannerController::class, 'scan'])->name('scan.process');
    Route::get('/history/{id}', [ScannerController::class, 'show'])->name('scan.history');
    Route::delete('/history/{id}', [ScannerController::class, 'destroy'])->name('scan.destroy');
    Route::delete('/history-cleanup/duplicates', [ScannerController::class, 'cleanupOldDuplicates'])->name('scan.cleanup.duplicates');
    Route::get('/reports', [ScannerController::class, 'reports'])->name('scan.reports');
    Route::get('/reports/print', [ScannerController::class, 'printReport'])->name('scan.reports.print');

    // Manajemen Akun, Ganti Password & Tambah User Baru
    Route::get('/account', [AuthController::class, 'showAccount'])->name('account.index');
    Route::put('/account/password', [AuthController::class, 'updatePassword'])->name('account.password');
    Route::post('/account/users', [AuthController::class, 'storeUser'])->name('account.users.store');
    Route::delete('/account/users/{id}', [AuthController::class, 'destroyUser'])->name('account.users.destroy');
});
