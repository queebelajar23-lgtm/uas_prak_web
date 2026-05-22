<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// ─── Fitur Saat Belum Login (Guest) ───────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Opsional: Lupa Password (Bisa dibiarkan aktif untuk jaga-jaga)
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// ─── Fitur Saat Sudah Login (Auth) ────────────────────────────
Route::middleware('auth')->group(function () {
    // 💡 WAJIB AKTIF: Biar tombol logout di layout kamu bekerja kembali!
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Opsional: Ubah password dari halaman profil
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});