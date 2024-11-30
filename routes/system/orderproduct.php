<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderProductController;


Route::prefix('order-products')->middleware('check_login_admin')
->group(function () {
    Route::get('/', [OrderProductController::class, 'index'])->name('orderproduct');
    // Route::delete('/multipledelete', [OrderController::class, 'index'])->name('order.multipledelete');
    Route::get('/delete/{id}', [OrderProductController::class, 'delete'])->name('orderproduct.delete');
    Route::get('/resetsearch', [OrderProductController::class, 'resetSearch'])->name('orderproduct.resetsearch');
    Route::get('/updateStatus{id}', [OrderProductController::class, 'updateStatus'])->name('orderproduct.updateStatus');
    // Route::get('/perpage', [OrderController::class, 'index'])->name('order.perpage');
    // Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    // Route::post('/handlepay', [OrderController::class, 'handlepay'])->name('order.handlepay');
    // Route::get('/print/{id}', [OrderController::class, 'print_order'])->name('order.print');
    // Route::post('/checkout', [OrderController::class, 'checkout_online'])->name('order.checkout');
    // Route::get('/momo/callback', [OrderController::class, 'handleCallback'])->name('momo.callback');
 
});
