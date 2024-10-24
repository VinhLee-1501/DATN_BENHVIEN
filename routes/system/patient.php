<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PatientController;


Route::prefix('patients')->middleware('check_login_admin')->group(function () {

    Route::get('/', [PatientController::class, 'index'])->name('patient');

    Route::get('create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('store', [PatientController::class, 'store'])->name('patients.store');

    Route::get('edit/{patient_id}', [PatientController::class, 'edit'])->name('patients.edit');
    Route::patch('update/{patient_id}', [PatientController::class, 'update'])->name('patients.update');

    Route::delete('delete/{patient_id}', [PatientController::class, 'destroy'])->name('patients.destroy');

});

