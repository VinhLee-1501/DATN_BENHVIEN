<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ScheduleDoctorController;

Route::prefix('scheduleDoctor')->middleware('check_login_admin')->group(function (){
   Route::get('/', [ScheduleDoctorController::class, 'index'])->name('scheduleDoctor');
});
