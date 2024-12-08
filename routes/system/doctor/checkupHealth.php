<?php

use App\Http\Controllers\Admin\CheckupHealthController;
use App\Http\Controllers\Admin\OnlineDotor;
use Illuminate\Support\Facades\Route;


Route::prefix('checkupHealths')->middleware('check_login_admin')
   ->group(function () {
      Route::get('/', [CheckupHealthController::class, 'index'])->name('checkupHealth');
      Route::get('/create/{book_id}', [CheckupHealthController::class, 'create'])->name('checkupHealth.create');
      Route::post('/storePatient/{book_id}', [CheckupHealthController::class, 'storePatient'])->name('checkupHealth.storePatient');
      Route::post('/savemedicine', [CheckupHealthController::class, 'saveMedicine'])->name('checkupHealth.saveMedicine');
      Route::post('/saveservice/{book_id}', [CheckupHealthController::class, 'saveService'])->name('checkupHealth.saveService');
      Route::get('/savemedical/{book_id}', [CheckupHealthController::class, 'saveMedical'])->name('checkupHealth.saveMedical');
      Route::get('/record/{medical}', [CheckupHealthController::class, 'record'])->name(name: 'checkupHealth.record');
      Route::post('/store/{medical_id}', [CheckupHealthController::class, 'store'])->name('checkupHealth.store');
      
      Route::get('/download-pdf', [CheckupHealthController::class, 'download'])->name('downloadPdf');

   //online
   Route::get('/createOnline/{book_id}', [OnlineDotor::class, 'createOnline'])->name('Online.create');
   Route::post('/savePatient/{book_id}', [OnlineDotor::class, 'savePatient'])->name('Online.savePatient');
   Route::post('/tore/{book_id}', [OnlineDotor::class, 'store'])->name('Online.store');

   });