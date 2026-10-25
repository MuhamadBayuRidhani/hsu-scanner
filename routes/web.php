<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScannerController;

Route::get('/', [ScannerController::class, 'index'])->name('home');
Route::post('/scan', [ScannerController::class, 'scan'])->name('scan.process');
Route::get('/history/{id}', [ScannerController::class, 'show'])->name('scan.history');
Route::delete('/history/{id}', [ScannerController::class, 'destroy'])->name('scan.destroy');
Route::delete('/history-cleanup/duplicates', [ScannerController::class, 'cleanupOldDuplicates'])->name('scan.cleanup.duplicates');
Route::get('/reports', [ScannerController::class, 'reports'])->name('scan.reports');
Route::get('/reports/print', [ScannerController::class, 'printReport'])->name('scan.reports.print');