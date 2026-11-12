<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarisController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/inventaris');

// ---------- LOGIN / LOGOUT ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ---------- MODUL INVENTARIS ----------
// Guest otomatis diarahkan ke halaman login oleh middleware 'auth'
Route::middleware('auth')->group(function () {

    // Admin + Petugas: lihat, tambah, ubah
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('inventaris', InventarisController::class)
            ->except(['show', 'destroy'])
            ->parameters(['inventaris' => 'inventaris']);
    });

    // Hanya Admin: hapus
    Route::delete('inventaris/{inventaris}', [InventarisController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('inventaris.destroy');
});
