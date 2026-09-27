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
| AUTH ROUTES - login & register (punya teman Anda)
| Catatan: ini baru menampilkan view saja, belum ada logic proses
| login/register (POST). Nanti perlu ditambahkan Route::post untuk
| memproses form-nya.
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
| ADMIN ROUTES - semua digabung jadi satu group, wajib login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD ruangan - terhubung ke database
    Route::resource('rooms', AdminRoomController::class)->except(['show']);

    // Pengajuan peminjaman - terhubung ke database
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    // Halaman statis (punya teman Anda, belum terhubung ke database)
    Route::get('/ruangan', function () {
        return view('admin.ruangan');
    })->name('ruangan');

    Route::get('/peminjaman', function () {
        return view('admin.peminjaman');
    })->name('peminjaman');

    Route::get('/pengguna', function () {
        return view('admin.pengguna');
    })->name('pengguna');

    Route::get('/pengaturan', function () {
        return view('admin.pengaturan');
    })->name('pengaturan');

});
