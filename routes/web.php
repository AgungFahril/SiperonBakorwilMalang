<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

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