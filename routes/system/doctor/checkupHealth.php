<?php

use App\Http\Controllers\Admin\CheckupHealthController;
use Illuminate\Support\Facades\Route;


Route::prefix('checkupHealths')->middleware('check_login_admin')
   ->group(function () {
      Route::get('/', [CheckupHealthController::class, 'index'])->name('checkupHealth');
      Route::get('/create/{book_id}', [CheckupHealthController::class, 'create'])->name('checkupHealth.create');
      Route::post('/storePatient/{book_id}', [CheckupHealthController::class, 'storePatient'])->name('checkupHealth.storePatient');
      Route::post('/savemedicine', [CheckupHealthController::class, 'saveMedicine'])->name('checkupHealth.saveMedicine');
      Route::post('/saveservice/{book_id}', [CheckupHealthController::class, 'saveService'])->name('checkupHealth.saveService');
      Route::get('/record/{medical}', [CheckupHealthController::class, 'record'])->name(name: 'checkupHealth.record');
      Route::post('/store/{medical_id}', [CheckupHealthController::class, 'store'])->name('checkupHealth.store');
      
      Route::get('/download-pdf', [CheckupHealthController::class, 'download'])->name('downloadPdf');


   });