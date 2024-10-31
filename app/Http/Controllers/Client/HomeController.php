<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $doctor = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
        ->where('role', 2)
        ->select('users.*', 'specialties.specialty_id', 'specialties.name as specialtyName')
        ->limit(6)
        ->get();
        // dd($doctor);
        return view('client.index', ['doctor' => $doctor]);
    }
}
