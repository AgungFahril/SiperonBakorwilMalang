<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/ruangan/{room}/ajukan', [HomeController::class, 'bookingForm'])->name('booking.form');
    Route::post('/ruangan/{room}/ajukan', [HomeController::class, 'bookingStore'])->name('booking.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - login & register
| Catatan: ini baru menampilkan view saja, belum ada logic proses
| login/register (POST). Nanti perlu ditambahkan Route::post untuk
| memproses form-nya.
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.post');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES - Terhubung ke database
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

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

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

});