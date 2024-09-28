<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppointmentSchedule;

Route::prefix('appointmentSchedules')->group(function (){
    Route::get('/', [AppointmentSchedule::class, 'index'])->name('appointmentSchedule');
    Route::get('/edit/{id}', [AppointmentSchedule::class, 'edit'])->name('editAppointmentSchedule');
    Route::put('/update/{id}', [AppointmentSchedule::class, 'update'])->name('updateAppointmentSchedule');
    Route::delete('/destroy/{id}', [AppointmentSchedule::class, 'destroy'])->name('deleteAppointmentSchedule');
})->middleware('check_login_admin');
