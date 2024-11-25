<?php

use App\Http\Controllers\Admin\ServiceTypeController;
use Illuminate\Support\Facades\Route;


Route::prefix('serviceTypes')->middleware('check_login_admin')
->group(function () {
    Route::get('/', [ServiceTypeController::class, 'index'])->name('serviceType');
    Route::get('/search', [ServiceTypeController::class, 'index'])->name('serviceTypes.search');
    Route::post('/multipledelete', [ServiceTypeController::class, 'index'])->name('serviceTypes.multipledelete');
    Route::get('/perpage', [ServiceTypeController::class, 'index'])->name('serviceTypes.perpage');
    Route::get('/listservicetype',[ServiceTypeController::class, 'indexinactive'])->name('serviceTypes.inactive');
    Route::get('/resetsearch', [ServiceTypeController::class, 'resetSearch'])->name('serviceTypes.resetsearch');
    Route::get('/create', [ServiceTypeController::class, 'create'])->name('serviceTypes.create');
    Route::post('/create', [ServiceTypeController::class, 'store'])->name('serviceTypes.store');
    Route::get('/edit/{id}', [ServiceTypeController::class, 'edit'])->name('serviceTypes.edit'); 
    Route::patch('/update/{row_id}', [ServiceTypeController::class, 'update'])->name('serviceTypes.update');
    Route::get('/delete/{row_id}/{directory_id}', [ServiceTypeController::class, 'delete'])->name('serviceTypes.delete');

});