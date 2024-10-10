<?php

use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/dat-lich', [BookController::class, 'booking'])->name('booking');
Route::post('/dat-lich', [BookController::class, 'handleBooking'])->name('booking');
Route::post('/verify-otp', [BookController::class, 'verifyOtp'])->name('verify.otp');
