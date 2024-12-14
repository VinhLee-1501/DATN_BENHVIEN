<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderMedicineController;


Route::prefix('order-medicines')->middleware('check_login_admin')
->group(function () {
    Route::get('/', [OrderMedicineController::class, 'index'])->name('ordermedicine');
    Route::get('/edit/{id}', [OrderMedicineController::class, 'edit'])->name('order.edit');
    Route::get('/print_order_medicineOnline/{id}', [OrderMedicineController::class, 'print_orderOnline'])->name('order.print_order_medicineOnline');
    Route::get('/print/{id}', [OrderMedicineController::class, 'print_order'])->name('ordermedicine.print');
    Route::post('/handlepay', [OrderMedicineController::class, 'handlepay'])->name('ordermedicine.handlepay');
    Route::get('/delete/{id}', [OrderMedicineController::class, 'delete'])->name('ordermedicine.delete');
    Route::get('/dispense_medication/{id}', [OrderMedicineController::class, 'dispenseMedication'])->name('ordermedicine.dispense');
});
