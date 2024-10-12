<?php

use App\Http\Controllers\Admin\CheckupHealthController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\MedicalRecordDocotrController;

Route::prefix('recordDoctors')->middleware('check_login_admin')
   ->group(function () {
      Route::get('/', [MedicalRecordDocotrController::class, 'index'])->name('recordDoctor');
      Route::get('/create', [MedicalRecordDocotrController::class, 'create'])->name('recordDoctor.create');
      Route::get('/record/{medical_id}', [MedicalRecordDocotrController::class, 'record'])->name('recordDoctors.record');
      // Route::get('/record/{book_id}', [MedicalRecordDocotrController::class, 'recordbook'])->name('recordDoctors.recordbook');
      // Route::post('/store/{medical_id}', [MedicalRecordDocotrController::class, 'store'])->name('recordDoctors.store');
      Route::get('/detail/{medical_id}', [MedicalRecordDocotrController::class, 'detail'])->name('recordDoctors.detail');
      // Route::post('/storePatient', [MedicalRecordDocotrController::class, 'storePatient'])->name('recordDoctors.storePatient');
      // Route::post('/savemedicine', [MedicalRecordDocotrController::class, 'saveMedicine'])->name('recordDoctors.saveMedicine');
      // Route::post('/saveservice', [MedicalRecordDocotrController::class, 'saveService'])->name('recordDoctors.saveService');
   });