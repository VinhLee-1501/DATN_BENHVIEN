<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('products')->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/end', [ProductController::class, 'end'])->name('product.end');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::patch('/update/{product_id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{prod}', [ProductController::class, 'delete'])->name('product.delete');
    });
