<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\SocialLoginController;

//UserController
Route::get('/dang-ky', [UserController::class, 'register'])->name('register');
Route::post('/dang-ky', [UserController::class, 'handleRegister']);
Route::get('/dang-nhap', [UserController::class, 'login'])->name('login');
Route::post('/dang-nhap', [UserController::class, 'authenticateLogin']);
Route::get('/dang-xuat', [UserController::class, 'logout'])->name('logout');

// SocialLoginController
Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [SocialLoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [SocialLoginController::class, 'handleFacebookCallback']);

Route::get('auth/zalo', [SocialLoginController::class, 'redirectToZalo'])->name('auth.zalo');
Route::get('auth/zalo/callback', [SocialLoginController::class, 'handleZaloCallback']);
