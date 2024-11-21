<?php

use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\shop\PayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\shop\shopController;
use Illuminate\Http\Request;



Route::prefix('cua-hang')->group(function () {

    Route::get('/', [shopController::class, 'index'])->name('shop');
    Route::post('/update-header-total', function (Request $request) {
        $formattedTotal = number_format($request->totalCart, 0, ',', '.') . ' VND';
        return response()->json(['formattedTotal' => $formattedTotal]);
    });
    Route::post('/ship', [CheckoutController::class, 'calculateShippingFee'])->name('calculateShippingFee');
    Route::post('/mua-hang', [shopController::class, 'checkout'])->name('checkout');
 
    Route::post('/voucher', [shopController::class, 'checkVoucher'])->name('checkVoucher');
    Route::post('/thanh-toan', [PayController::class, 'order'])->name('order');
    Route::get('/chi-tiet-san-pham/{id}', [shopController::class, 'detail'])->name('shop-details');
    Route::get('/san-pham', [shopController::class, 'grid'])->name('shop-grid');
    Route::get('/gio-hang', [shopController::class, 'cart'])->name('cart');
    Route::post('/gio-hang/{id}', [shopController::class, 'addProductToCart'])->name('addProductTocart');
    Route::put('/gio-hang', [shopController::class, 'updateCart'])->name('updateCart');
    Route::get('/bai-viet', [shopController::class, 'blog'])->name('blog');
    Route::get('/hoa-don', [PayController::class, 'bill'])->name('bill');

    Route::get('/payment/momo/return', [PayController::class, 'handleMomoPaymentResponse'])->name('momo.return');



    
});