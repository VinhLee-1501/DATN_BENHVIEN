<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;


Route::prefix('orders')->middleware('check_login_admin')
->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order');
    Route::delete('/multipledelete', [OrderController::class, 'index'])->name('order.multipledelete');
    Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
    Route::get('/resetsearch', [OrderController::class, 'resetSearch'])->name('order.resetsearch');
    Route::get('/perpage', [OrderController::class, 'index'])->name('order.perpage');
    Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::post('/handlepay', [OrderController::class, 'handlepay'])->name('order.handlepay');
    Route::get('/print/{id}', [OrderController::class, 'print_order'])->name('order.print');
    Route::post('/checkout', [OrderController::class, 'checkout_online'])->name('order.checkout');
    Route::get('/momo/callback', [OrderController::class, 'handleCallback'])->name('momo.callback');
 
});
