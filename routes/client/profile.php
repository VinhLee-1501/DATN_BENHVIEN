<?php

use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('ho-so')->middleware('check_login_client')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::patch('update', [UserController::class, 'updateProfile'])->name('update');
    });
