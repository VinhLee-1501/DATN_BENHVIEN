<?php

use App\Http\Controllers\Admin\CouponController;
use Illuminate\Support\Facades\Route;


Route::prefix('coupons')->middleware('check_login_admin')
    ->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupon');
        Route::get('/create', [CouponController::class, 'create'])->name('coupons.create');
        Route::post('/store', [CouponController::class, 'store'])->name('store_coupon');
        Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::patch('/update/{id}', [CouponController::class, 'update'])->name('coupons.update');
        Route::get('/delete/{id}', [CouponController::class, 'delete'])->name('coupons.delete');
        Route::get('/search', [CouponController::class, 'index'])->name('coupons.search');
        Route::get('/listproduct',[CouponController::class, 'listproduct']);
        Route::get('/listcategory',[CouponController::class, 'listcategory']);
        Route::get('/resetsearch', [CouponController::class, 'resetSearch'])->name('coupon.resetsearch');
        Route::post('/multipledelete', [CouponController::class, 'index'])->name('coupon.multipledelete');
    });
