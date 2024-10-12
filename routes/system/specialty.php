<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SpecialtyController;

Route::prefix('specialties')->middleware('check_login_admin')->group(function (){
   Route::get('/', [SpecialtyController::class, 'index'])->name('specialty');
   Route::get('/detail/{id}', [SpecialtyController::class, 'detail'])->name('detail');
   Route::post('/create', [SpecialtyController::class, 'store'])->name('create');
   Route::get('/edit/{id}', [SpecialtyController::class, 'edit'])->name('edit');
   Route::patch('/update/{id}', [SpecialtyController::class, 'update'])->name('update');
   Route::delete('/delete/{id}', [SpecialtyController::class, 'destroy'])->name('delete');
});
