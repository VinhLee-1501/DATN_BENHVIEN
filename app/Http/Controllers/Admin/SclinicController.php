<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sclinic;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SclinicController extends Controller
{
    public function index()
    {
        $clinics = Sclinic::join('specialties', 'specialties.specialty_id', '=', 'sclinics.specialty_id')
            ->select('sclinics.*', 'specialties.name as specialtyName')
            ->paginate(5);

        $specialties = Specialty::all(); // Lấy danh sách chuyên khoa

        return view('System.clinic.index', compact('clinics', 'specialties'));
    }

    public function filterClinicsBySpecialty(Request $request)
    {
        $specialtyId = $request->input('specialty_id');

        $activeClinics = Sclinic::join('specialties', 'specialties.specialty_id', '=', 'sclinics.specialty_id')
            ->where('sclinics.specialty_id', $specialtyId)
            ->where('sclinics.status', 1)
            ->select('sclinics.sclinic_id', 'sclinics.name', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->get();
            // dd($activeClinics);

        $inactiveClinics = Sclinic::join('specialties', 'specialties.specialty_id', '=', 'sclinics.specialty_id')
            ->where('sclinics.specialty_id', $specialtyId)
            ->where('sclinics.status', 0)
            ->select('sclinics.sclinic_id', 'sclinics.name', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->get();

        return response()->json([
            'activeClinics' => $activeClinics,
            'inactiveClinics' => $inactiveClinics,
        ]);
    }
}
