<?php

use App\Http\Controllers\Admin\SaleProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('sale_products')->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [SaleProductController::class, 'index'])->name('sale_product');
        Route::get('/create', [SaleProductController::class, 'create'])->name('create_sale_product');
        Route::post('/store', [SaleProductController::class, 'store'])->name('store_sale_product');
        Route::get('/edit/{id}', [SaleProductController::class, 'edit'])->name('edit_sale_product');
        Route::patch('/update/{id}', [SaleProductController::class, 'update'])->name('update_sale_product');
        Route::delete('/delete/{id}', [SaleProductController::class, 'destroy'])->name('delete');
    });
