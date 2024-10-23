<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleDoctorController extends Controller
{
    public function index()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $user = Auth()->user();
        $schedules = Schedule::join('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('schedules.user_id', $user->user_id)
            ->whereMonth('schedules.day', $now->format('m'))
            ->select('schedules.*', 'users.firstname', 'users.lastname', 'sclinics.name')
            ->get();
   
        return view('System.doctors.schedules.index', ['schedules' => $schedules, 'now' => $now]);
    }
}
