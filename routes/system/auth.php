<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::name('auth.')
    ->group(function (){

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});
