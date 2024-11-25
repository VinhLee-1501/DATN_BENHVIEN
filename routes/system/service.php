<?php

use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;


Route::prefix('services')->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('service');
        Route::get('/search', [ServiceController::class, 'index'])->name('services.search');
        Route::get('/resetsearch', [ServiceController::class, 'resetSearch'])->name('services.resetsearch');
        Route::get('/perpage', [ServiceController::class, 'index'])->name('services.perpage');
        // Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
        Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
        Route::get('/delete/{row_id}', [ServiceController::class, 'delete'])->name('services.delete');
        Route::get('/listservice', [ServiceController::class, 'listservice']);
        Route::post('/multipledelete', [ServiceController::class, 'index'])->name('services.multipledelete');
        Route::patch('/update/{row_id}', [ServiceController::class, 'update'])->name('services.update');
        Route::post('/create', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/check-duplicate-name', [ServiceController::class, 'checkDuplicateName']);
    });
