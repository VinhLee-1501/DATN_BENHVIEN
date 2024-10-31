<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProfileDoctor;
use App\Models\User;

class ProfileDoctorController extends Controller
{
    public function index($id) {
        $doctorId = ProfileDoctor::join('users', 'users.user_id', '=', 'profile_doctors.user_id')
        ->join('specialties',  'specialties.specialty_id', '=', 'users.specialty_id')
        ->where('profile_doctors.user_id', $id)
        ->select('profile_doctors.*', 'users.lastname as lastName', 'users.firstname as firstName', 'users.avatar', 'specialties.name as specialtyName')
        ->get();
        // dd($doctorId);
        return view('client.profile-doctor', ['doctorId' => $doctorId]);
    }
}
