<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
})->name('dashboard')->middleware('check_login_admin');
