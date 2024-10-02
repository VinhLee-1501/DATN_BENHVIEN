<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MedicalRecordController;

Route::prefix('medicalRecords')->middleware('check_login_admin')
   ->group(function () {
      Route::get('/', [MedicalRecordController::class, 'index'])->name('medicalRecord');
      Route::get('/detail/{id}', [MedicalRecordController::class, 'detail'])->name('detail_medical_record');
      Route::get('/detail/{medical_id}/prescription/{treatment_id}', [MedicalRecordController::class, 'prescription'])->name('prescription_medical_record');
      Route::delete('/delete/{medical_id}', [MedicalRecordController::class, 'destroy'])->name('delete_medical_record');
   });


   