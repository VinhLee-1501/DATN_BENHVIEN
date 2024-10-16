<?php

use App\Http\Controllers\Admin\ScheduleController;
use Illuminate\Support\Facades\Route;


Route::prefix('schedules')->middleware('check_login_admin')
    ->group(function (){
    Route::get('/', [ScheduleController::class, 'index'])->name('schedule');
    Route::get('/data', [ScheduleController::class, 'getData'])->name('getData');
    Route::get('/doctor', [ScheduleController::class, 'getDoctors'])->name('getDoctor');
    Route::get('/clinic', [ScheduleController::class, 'getClinics'])->name('getClinics');
    // Route::get('/create',[ScheduleController::class, 'create'])->name( 'schedules.create');
    Route::post('/create',[ScheduleController::class, 'store'])->name( 'schedules.store');
    Route::get('/edit/{shift_id}',[ScheduleController::class, 'edit'])->name( 'schedules.edit');
    Route::patch('/update/{shift_id}',[ScheduleController::class, 'update'])->name( 'schedules.update');
    Route::delete( '/delete/{shift_id}',[ScheduleController::class, 'delete'])->name( 'schedules.delete');


});
