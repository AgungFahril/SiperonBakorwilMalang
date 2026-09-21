<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
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
| ADMIN ROUTES - CRUD dengan database (butuh login)
| Sesuaikan middleware 'auth' dengan sistem login admin yang dipakai,
| mis. Breeze/Jetstream/custom guard.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('rooms', AdminRoomController::class)->except(['show']);

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES - halaman tampilan dari branch main
| (sementara masih view statis, belum terhubung ke database)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::get('/peminjaman', function () {
        return view('admin.peminjaman');
    });
    Route::get('/ruangan', function () {
        return view('admin.ruangan');
    });
    Route::get('/pengguna', function () {
        return view('admin.pengguna');
    });
    Route::get('/pengaturan', function () {
        return view('admin.pengaturan');
    });
});