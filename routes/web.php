<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

// Halaman utama redirect ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard (butuh login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Buku routes (hanya admin & petugas)
Route::resource('buku', BukuController::class)
    ->middleware(['auth', 'role:admin,petugas']);

// Anggota routes (hanya admin & petugas)
Route::resource('anggota', AnggotaController::class)
    ->middleware(['auth', 'role:admin,petugas']);

// Peminjaman routes (hanya admin & petugas)
Route::prefix('peminjaman')->middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::put('/{id}/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
    Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

// Profile route
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

// Auth routes dari Breeze (login, register, logout, dll)
require __DIR__.'/auth.php';