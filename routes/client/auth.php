<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\UserController;

//UserController
Route::get('/dang-ky', [UserController::class, 'register'])->name('register');
Route::post('/dang-ky', [UserController::class, 'handleRegister']);
Route::get('/dang-nhap', [UserController::class, 'login'])->name('login');
Route::post('/dang-nhap', [UserController::class, 'authenticateLogin']);
Route::get('/dang-xuat', [UserController::class, 'logout'])->name('logout');
