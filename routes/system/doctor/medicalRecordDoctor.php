<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\MedicalRecordDocotrController;

Route::prefix('recordDoctors')->middleware('check_login_admin')
   ->group(function () {
      Route::get('/', [MedicalRecordDocotrController::class, 'index'])->name('recordDoctor');
      Route::get('/create', [MedicalRecordDocotrController::class, 'create'])->name('recordDoctor.create');
      Route::get('/detail/{medical_id}/prescription/{treatment_id}', [MedicalRecordDocotrController::class, 'prescription'])->name('prescription_medical_record');
      Route::delete('/delete/{medical_id}', [MedicalRecordDocotrController::class, 'destroy'])->name('delete_medical_record');
   });