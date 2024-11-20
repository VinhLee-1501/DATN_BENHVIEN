<?php

use App\Http\Controllers\Admin\DoctorController;
use Illuminate\Support\Facades\Route;


Route::prefix('doctors')
    ->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('doctor');
        Route::get('/edit/{id}', [DoctorController::class, 'edit'])->name('doctor.edit');
        Route::patch('/update/{id}', [DoctorController::class, 'update'])->name('doctor.update');

        Route::get('/create', [DoctorController::class, 'create'])->name('doctor.create');
        Route::post('/store', [DoctorController::class, 'store'])->name('doctor.store');
    });


