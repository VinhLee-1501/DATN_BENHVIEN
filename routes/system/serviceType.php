<?php

use App\Http\Controllers\Admin\ServiceTypeController;
use Illuminate\Support\Facades\Route;


Route::prefix('serviceTypes')->middleware('check_login_admin')
->group(function () {
    Route::get('/', [ServiceTypeController::class, 'index'])->name('serviceType');
    Route::delete('/multipledelete', [ServiceTypeController::class, 'index'])->name('serviceTypes.multipledelete');
    Route::get('/resetsearch', [ServiceTypeController::class, 'resetSearch'])->name('serviceTypes.resetsearch');
    Route::get('/perpage', [ServiceTypeController::class, 'index'])->name('serviceTypes.perpage');
    Route::get('/create', [ServiceTypeController::class, 'create'])->name('serviceTypes.create');
    Route::post('/create', [ServiceTypeController::class, 'store'])->name('serviceTypes.store');
    // Route::get('/edit/{row_id}', [ServiceTypeController::class, 'edit'])->name('serviceTypes.edit');
    // Route::patch('/update/{row_id}', [ServiceTypeController::class, 'update'])->name('serviceTypes.update');
    // Route::delete('/delete{row_id}', [ServiceTypeController::class, 'destroy'])->name('serviceTypes.delete');
});