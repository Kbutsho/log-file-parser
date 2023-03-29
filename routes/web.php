<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('upload', [FileController::class, 'showForm'])->name('upload');
    Route::post('file-parse', [FileController::class, 'fileParse'])->name('file-parse');
    Route::get('logs', [FileController::class, 'showAllLogs'])->name('logs');
    Route::get('delete-all-logs', [FileController::class, 'deleteAllLogs'])->name('delete-all-logs');
    Route::delete('log/{id}', [FileController::class, 'deleteLogById'])->name('log.delete');
    Route::get('log/{id}/details', [FileController::class, 'detailsLogById'])->name('log.details');
});

Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('get.login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
