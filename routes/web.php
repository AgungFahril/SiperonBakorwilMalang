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
| ADMIN ROUTES (butuh login — sesuaikan middleware 'auth' dengan sistem
| login admin yang sudah Anda pakai, mis. Breeze/Jetstream/custom guard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('rooms', AdminRoomController::class)->except(['show']);

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
});
