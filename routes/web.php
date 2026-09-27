<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ruangan/{room}/ajukan', [HomeController::class, 'bookingForm'])->name('booking.form');
Route::post('/ruangan/{room}/ajukan', [HomeController::class, 'bookingStore'])->name('booking.store');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - login & register
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES - Terhubung ke database
| Sementara tanpa middleware auth agar bisa diakses langsung.
| Aktifkan middleware(['auth']) setelah sistem login disiapkan.
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::patch('/peminjaman/{booking}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.status');
    Route::delete('/peminjaman/{booking}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::put('/ruangan/{room}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{room}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');

    // Pengaturan (tetap view statis untuk saat ini)
    Route::get('/pengaturan', function () {
        return view('admin.pengaturan');
    })->name('pengaturan');

});