<?php

use App\Http\Controllers\Admin\CouponController;
use Illuminate\Support\Facades\Route;


Route::prefix('coupons')->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupon');
        Route::get('/create', [CouponController::class, 'create'])->name('create_coupon');
        Route::post('/store', [CouponController::class, 'store'])->name('store_coupon');
        Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('edit_coupon');
        Route::patch('/update/{id}', [CouponController::class, 'update'])->name('update_coupon');
        Route::delete('/delete/{id}', [CouponController::class, 'destroy'])->name('delete');
    });
