<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
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

// ============ PEMINJAMAN ROUTES LENGKAP ============
// Untuk admin dan petugas
Route::middleware(['auth', 'role:admin,petugas'])->prefix('peminjaman')->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::put('/{id}/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
    Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::get('/pending', [PeminjamanController::class, 'pending'])->name('peminjaman.pending');
    Route::put('/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::put('/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
});

// Untuk anggota (pengajuan peminjaman)
Route::middleware(['auth', 'role:anggota'])->prefix('anggota/peminjaman')->group(function () {
    Route::get('/create', [PeminjamanController::class, 'createAnggota'])->name('peminjaman.anggota.create');
    Route::post('/', [PeminjamanController::class, 'storeAnggota'])->name('peminjaman.anggota.store');
    Route::get('/', [PeminjamanController::class, 'indexAnggota'])->name('peminjaman.anggota.index');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ROUTE TEST UNTUK DEBUG PENDING (HAPUS NANTI)
Route::get('/test-pending', function() {
    $peminjamans = App\Models\Peminjaman::where('status_pengajuan', 'menunggu')
        ->with(['anggota', 'detailPeminjaman.buku'])
        ->get();
    return view('peminjaman.pending', compact('peminjamans'));
})->middleware(['auth', 'role:admin,petugas']);

// Auth routes dari Breeze
require __DIR__.'/auth.php';