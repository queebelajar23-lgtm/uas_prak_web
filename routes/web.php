<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Buku routes dengan middleware role
Route::resource('buku', BukuController::class)
    ->middleware(['auth', 'role:admin,petugas']);

// Anggota routes dengan middleware role
Route::resource('anggota', AnggotaController::class)
    ->middleware(['auth', 'role:admin,petugas']);

// Peminjaman routes
Route::prefix('peminjaman')->middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::put('/{id}/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
    Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

require __DIR__.'/auth.php';