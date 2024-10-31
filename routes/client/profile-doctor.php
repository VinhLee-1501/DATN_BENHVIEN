<?php

use App\Http\Controllers\Client\ProfileDoctorController;
use Illuminate\Support\Facades\Route;

Route::get('/profile/{id}', [ProfileDoctorController::class, 'index'])->name('ho-so');
