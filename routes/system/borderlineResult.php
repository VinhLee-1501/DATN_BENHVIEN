<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BorderlineResultController;;


Route::prefix('borderline-result')->middleware('check_login_admin')
->group(function () {

    Route::get('/', [BorderlineResultController::class, 'index'])->name('borderline-result');

    Route::get('/details/{treatment_id}/{service_id}', [BorderlineResultController::class, 'detail'])->name('borderline-result.details');
       
    Route::get('/delete/{id}', [BorderlineResultController::class, 'delete'])->name('borderline-result.delete');

    Route::post('/update/{treatment_id}/{service_id}', [BorderlineResultController::class, 'update'])->name('borderline-result.update');

    Route::post('/uploadfile', [BorderlineResultController::class, 'uploadfile']);

    Route::post('/revertfile', [BorderlineResultController::class, 'revertfile']);

    Route::post('/fetch-images', [BorderlineResultController::class, 'fetchImages']);
});
