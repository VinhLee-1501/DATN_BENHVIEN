<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SclinicController;

Route::prefix('sclinics')->middleware('check_login_admin')->group(function () {
    Route::get('/', [SclinicController::class, 'index'])->name('sclinic');
    // Route::get('/filter-clinics', [SclinicController::class, 'filterClinicsBySpecialty'])->name('filter-clinics');
    Route::get('/create', [SclinicController::class, 'create'])->name('create');
    Route::post('/store', [SclinicController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [SclinicController::class, 'edit'])->name('edit');
    Route::patch('/update/{id}', [SclinicController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [SclinicController::class, 'destroy'])->name('delete');
});
