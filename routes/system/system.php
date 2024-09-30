<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('system.index');
})->name('dashboard')->middleware('check_login_admin');
