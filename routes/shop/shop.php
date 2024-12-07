<?php

use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Shop\PayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopController;
use Illuminate\Http\Request;



Route::prefix('cua-hang')->group(function () {

    Route::get('/', [ShopController::class, 'index'])->name('shop');

    Route::post('/ship', [CheckoutController::class, 'calculateShippingFee'])->name('calculateShippingFee');
    Route::post('/mua-hang', [ShopController::class, 'checkout'])->name('checkout');
    Route::post('/search', [ShopController::class, 'search'])->name('search');
    Route::get('/getSuggestedProducts', [ShopController::class,'getSuggestedProducts'])->name('getSuggestedProducts');
    Route::post('/voucher', [ShopController::class, 'checkVoucher'])->name('checkVoucher');
    Route::post('/thanh-toan-online', [PayController::class, 'order'])->name('order');
    Route::get('/chi-tiet-san-pham/{id}', [ShopController::class, 'detail'])->name('shop-details');
    Route::get('/san-pham', [ShopController::class, 'grid'])->name('shop-grid');
    Route::get('/gio-hang', [ShopController::class, 'cart'])->name('cart');
    Route::post('/gio-hang/{id}', [ShopController::class, 'addProductToCart'])->name('addProductTocart');
    Route::put('/gio-hang', [ShopController::class, 'updateCart'])->name('updateCart');
    Route::get('/bai-viet', [ShopController::class, 'blog'])->name('blog');
    Route::get('/hoa-don', [PayController::class, 'bill'])->name('bill');


    Route::get('/payment/momo/return', [PayController::class, 'handleMomoPaymentResponse'])->name('momo.return');
    Route::get('/payment/vnpay/return', [PayController::class, 'handleVNPaymentResponse'])->name('vnpay.return');
    Route::get('/payment/zalopay/return', [PayController::class, 'handleZaloPaymentResponse'])->name('zalopay.return');

   


    
});