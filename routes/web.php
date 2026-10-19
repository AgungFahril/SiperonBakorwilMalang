<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES - Dapat diakses tanpa login
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ketersediaan Ruangan - PUBLIK
Route::get('/ketersediaan', [HomeController::class, 'ketersediaan'])->name('ketersediaan');

// Booking - PUBLIK (tanpa login)
Route::get('/ruangan/{room}/ajukan', [HomeController::class, 'bookingForm'])->name('booking.form');
Route::post('/ruangan/{room}/ajukan', [HomeController::class, 'bookingStore'])->name('booking.store');

// Cek status booking dengan kode booking
Route::get('/cek-booking', [HomeController::class, 'cekBookingForm'])->name('cek.booking.form');
Route::post('/cek-booking', [HomeController::class, 'cekBooking'])->name('cek.booking');

// Halaman sukses booking
Route::get('/booking-berhasil', [HomeController::class, 'bookingSuccess'])->name('booking.success');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - Login ADMIN saja (tanpa register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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
    Route::get('/peminjaman/{booking}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::patch('/peminjaman/{booking}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.status');
    Route::post('/peminjaman/{booking}/reschedule', [PeminjamanController::class, 'reschedule'])->name('peminjaman.reschedule');
    Route::delete('/peminjaman/{booking}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::put('/ruangan/{room}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{room}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

    // Notifikasi
    Route::get('/notifikasi', [DashboardController::class, 'notifications'])->name('notifikasi.index');
    Route::patch('/notifikasi/{notification}/read', [DashboardController::class, 'markAsRead'])->name('notifikasi.read');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

});