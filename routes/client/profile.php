<?php

use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('ho-so')->middleware('check_login_client')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::patch('cap-nhat-thong-tin', [UserController::class, 'updateProfile'])->name('update');
        Route::patch('doi-mat-khau', [UserController::class, 'changePassword'])->name('change-password');
    });
