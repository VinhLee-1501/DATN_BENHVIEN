<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AccountController;


Route::prefix('accounts')->middleware('check_login_admin')->group(function () {

    Route::get('/', [AccountController::class, 'index'])->name('account');

    Route::get('create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('store', [AccountController::class, 'store'])->name('accounts.store');

    Route::get('edit/{user_id}', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::patch('update/{user_id}', [AccountController::class, 'update'])->name('accounts.update');

    Route::delete('delete/{user_id}', [AccountController::class, 'destroy'])->name('accounts.destroy');

});

