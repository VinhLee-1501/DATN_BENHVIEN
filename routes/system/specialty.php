<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SpecialtyController;

Route::prefix('specialties')->middleware('check_login_admin')->group(function (){
   Route::get('/', [SpecialtyController::class, 'index'])->name('specialty');
   Route::get('/detail/{id}', [SpecialtyController::class, 'detail'])->name('detail_specialty');
   Route::post('/store', [SpecialtyController::class, 'store'])->name('store_specialty');
   Route::get('/edit/{id}', [SpecialtyController::class, 'edit'])->name('edit_specialty');
   Route::patch('/update/{id}', [SpecialtyController::class, 'update'])->name('update_specialty');
   Route::delete('/delete/{id}', [SpecialtyController::class, 'destroy'])->name('delete_specialty');
});
