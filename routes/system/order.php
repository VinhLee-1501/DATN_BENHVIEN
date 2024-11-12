<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;


Route::prefix('orders')->middleware('check_login_admin')
->group(function () {
    // Route::get('/create', [OrderController::class, 'create'])->name('blogs.create');
    // Route::post('/upload', [OrderController::class, 'store'])->name('blogs.store');
    // Route::post('/uploadfile', [OrderController::class, 'uploadfile']);
    // Route::delete('/revertfile', [OrderController::class, 'revertfile']);
    Route::get('/', [OrderController::class, 'index'])->name('order');
    Route::get('/complete', [OrderController::class, 'indexUn'])->name('orders.complete');
    Route::delete('/multipledelete', [OrderController::class, 'index'])->name('order.multipledelete');
    Route::get('/resetsearch', [OrderController::class, 'resetSearch'])->name('order.resetsearch');
    Route::get('/perpage', [OrderController::class, 'index'])->name('order.perpage');
    Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::patch('/update/{id}', [OrderController::class, 'update'])->name('order.updatestatus');
    Route::get('/print/{id}', [OrderController::class, 'print_order'])->name('order.print');
    Route::post('/checkout', [OrderController::class, 'checkout_online'])->name('order.checkout');
});
