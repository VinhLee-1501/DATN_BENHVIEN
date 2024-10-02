<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SystemController;

Route::middleware('check_login_admin')->group(function (){
   Route::get('/', [SystemController::class, 'getDashboard', 'getDashboardPieChart'])->name('dashboard');
});
