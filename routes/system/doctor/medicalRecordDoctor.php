<?php

use App\Http\Controllers\Admin\CheckupHealthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PDFController;
use App\Http\Controllers\Admin\MedicalRecordDocotrController;

Route::prefix('recordDoctors')->middleware('check_login_admin')
   ->group(function () {
      Route::get('/', [MedicalRecordDocotrController::class, 'index'])->name('recordDoctor');
      Route::get('/create', [MedicalRecordDocotrController::class, 'create'])->name('recordDoctor.create');
      Route::get('/record/{medical_id}', [MedicalRecordDocotrController::class, 'record'])->name('recordDoctors.record');
      Route::get('/detail/{medical_id}', [MedicalRecordDocotrController::class, 'detail'])->name('recordDoctors.detail');

      
      Route::get('/print/{medical_id}', [PDFController::class, 'printMedical'])->name('printMedical');
      Route::get('/service/{treatment_id}', [PDFController::class, 'printService'])->name('pdfService');
   });