<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordDocotrController extends Controller
{

    public function index()
    {
        $medicalRecord = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
            ->distinct()
            ->get();

        return view('System.doctors.medical.index', ['medicalRecord' => $medicalRecord]);
    }

    public function create(){
        // $record = MedicalRecord::get()
        return view('System.doctors.medical.create');
    }
}