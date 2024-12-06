<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;


Route::prefix('order-services')->middleware('check_login_admin')
->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order');
    Route::delete('/multipledelete', [OrderController::class, 'index'])->name('order.multipledelete');
    Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
    Route::get('/resetsearch', [OrderController::class, 'resetSearch'])->name('order.resetsearch');
    Route::get('/perpage', [OrderController::class, 'index'])->name('order.perpage');
    Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::get('/updateStatus/{id}', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::post('/handlepay', [OrderController::class, 'handlepay'])->name('order.handlepay');
    Route::get('/print/{id}', [OrderController::class, 'print_order'])->name('order.print');
    Route::get('/print_orderOnline/{id}', [OrderController::class, 'print_orderOnline'])->name('order.print_orderOnline');
    Route::post('/checkout', [OrderController::class, 'checkout_online'])->name('order.checkout');
    Route::get('/momo/callback', [OrderController::class, 'handleCallback'])->name('momo.callback');
    Route::get('/vnpay/callback', [OrderController::class, 'handlecallbackVnpay'])->name('vnpay.callback');
});
