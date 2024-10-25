<?php

use App\Http\Controllers\Client\ProfileDoctorController;
use Illuminate\Support\Facades\Route;

Route::prefix('ho-so-bac-si')->name('profileDoctor.')->group(function () {

        Route::get('/', [ProfileDoctorController::class, 'index'])->name('index');

    });
