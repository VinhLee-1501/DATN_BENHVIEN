<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;

Route::middleware('check_login_admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); 
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'changePasswordForm'])->name('change-password');   
    Route::patch('/change-password', [ProfileController::class, 'changePassword'])->name('change-password.update');   
    Route::patch('/change-avatar', [ProfileController::class, 'updateAvatar'])->name('change-avatar');   
});