<?php

use App\Http\Controllers\Admin\MedicineController;
use Illuminate\Support\Facades\Route;


Route::prefix('medicines')->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [MedicineController::class, 'index'])->name('medicine');
        Route::get('/end', [MedicineController::class, 'end'])->name('medicines.end');
        Route::get('/create', [MedicineController::class, 'create'])->name('medicines.create');
        Route::post('/store', [MedicineController::class, 'store'])->name('medicines.store');
        Route::get('/edit/{medicine_id}', [MedicineController::class, 'edit'])->name('medicines.edit');
        Route::patch('/update/{medicine_id}', [MedicineController::class, 'update'])->name('medicines.update');
        Route::delete('/delete/{medicine_id}', [MedicineController::class, 'delete'])->name('medicines.delete');
    });
