<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileDoctorController extends Controller
{
    public function index() {
//        $doctordetail = User::where('user_id', $user_id)->first();
        $doctordetail = User::where('role', 2)->get();
//        dd($doctordetail);
        return view('client.profile-doctor', compact('doctordetail'));
    }
}
