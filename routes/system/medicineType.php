<?php

use App\Http\Controllers\Admin\MedicineTypeController;
use Illuminate\Support\Facades\Route;


Route::prefix('medicineTypes')->middleware('check_login_admin')
->group(function () {
    Route::get('/', [MedicineTypeController::class, 'index'])->name('medicineType');
    Route::get('/create', [MedicineTypeController::class, 'create'])->name('medicineTypes.create');
    Route::post('/store', [MedicineTypeController::class, 'store'])->name('medicineTypes.store');
    Route::get('/edit/{row_id}', [MedicineTypeController::class, 'edit'])->name('medicineTypes.edit');
    Route::patch('/update/{row_id}', [MedicineTypeController::class, 'update'])->name('medicineTypes.update');
    Route::delete('/delete{row_id}', [MedicineTypeController::class, 'destroy'])->name('medicineTypes.delete');
});