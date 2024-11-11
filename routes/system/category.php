<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('categories')->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{category_id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{category_id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/delete/{category_id}', [CategoryController::class, 'delete'])->name('category.delete');
    });