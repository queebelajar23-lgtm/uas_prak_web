<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Root ───────────────────────────────────────────────────
Route::get('/', function () {
    return redirect('/dashboard');
});

// ─── Dashboard ──────────────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ─── Buku (admin & petugas) ─────────────────────────────────
Route::resource('buku', BukuController::class)
    ->middleware(['auth', 'role:admin,petugas']);

// ─── Anggota (admin & petugas) ──────────────────────────────
Route::resource('anggota', AnggotaController::class)
    ->middleware(['auth', 'role:admin,petugas']);

// ─── Katalog Buku (khusus anggota) ──────────────────────────
Route::get('/katalog', [PeminjamanController::class, 'katalog'])
    ->middleware(['auth', 'role:anggota'])
    ->name('katalog.index');

// ─── Peminjaman (admin & petugas) ───────────────────────────
// PENTING: route statis (/pending, /create) HARUS di atas /{id}
Route::middleware(['auth', 'role:admin,petugas'])
    ->prefix('peminjaman')
    ->group(function () {

        // Statis dulu — tanpa {id}
        Route::get('/',        [PeminjamanController::class, 'index'])      ->name('peminjaman.index');
        Route::get('/create',  [PeminjamanController::class, 'create'])     ->name('peminjaman.create');
        Route::get('/pending', [PeminjamanController::class, 'pending'])    ->name('peminjaman.pending');
        Route::post('/',       [PeminjamanController::class, 'store'])      ->name('peminjaman.store');

        // Dinamis — dengan {id}, letakkan di bawah semua route statis
        Route::get('/{id}',              [PeminjamanController::class, 'show'])         ->name('peminjaman.show');
        Route::put('/{id}/pengembalian', [PeminjamanController::class, 'pengembalian']) ->name('peminjaman.pengembalian');
        Route::put('/{id}/approve',      [PeminjamanController::class, 'approve'])      ->name('peminjaman.approve');
        Route::put('/{id}/reject',       [PeminjamanController::class, 'reject'])       ->name('peminjaman.reject');
        Route::delete('/{id}',           [PeminjamanController::class, 'destroy'])      ->name('peminjaman.destroy');
    });

// ─── Peminjaman (anggota — pengajuan mandiri) ───────────────
// Memastikan hak akses murni hanya untuk role 'anggota'
Route::middleware(['auth', 'role:anggota'])
    ->prefix('panel-anggota') // <-- KITA GANTI URL-NYA DI SINI
    ->group(function () {

        Route::get('/',        [PeminjamanController::class, 'indexAnggota'])  ->name('anggota.peminjaman.index');
        Route::get('/create',  [PeminjamanController::class, 'createAnggota']) ->name('anggota.peminjaman.create');
        Route::post('/store',  [PeminjamanController::class, 'storeAnggota'])  ->name('anggota.peminjaman.store');
    });

// ─── Profile ────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',       [ProfileController::class, 'show'])   ->name('profile.show');
    Route::get('/profile/edit',  [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch('/profile',     [ProfileController::class, 'update']) ->name('profile.update');
});

// ─── Auth (Breeze) ──────────────────────────────────────────
require __DIR__.'/auth.php';