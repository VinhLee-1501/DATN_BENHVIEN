<?php

use App\Http\Controllers\Admin\CheckupHealthController;
use Illuminate\Support\Facades\Route;


Route::prefix('checkupHealths')->middleware('check_login_admin')
   ->group(function () {
      Route::get('/', [CheckupHealthController::class, 'index'])->name('checkupHealth');
      Route::get('/create/{book_id}', [CheckupHealthController::class, 'create'])->name('checkupHealth.create');
    //   Route::get('/detail/{medical_id}/prescription/{treatment_id}', [MedicalRecordDocotrController::class, 'prescription'])->name('prescription_medical_record');
    //   Route::delete('/delete/{medical_id}', [MedicalRecordDocotrController::class, 'destroy'])->name('delete_medical_record');
   });