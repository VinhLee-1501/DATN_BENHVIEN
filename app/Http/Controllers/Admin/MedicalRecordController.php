<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\TreatmentDetail;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecord = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
            ->distinct()
            ->paginate(5);

        return view('System.medicalrecord.index', ['medicalRecord' => $medicalRecord]);
    }

    public function detail($id)
    {
        $medical = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->join('users', 'users.phone', '=', 'patients.phone')
            ->join('treatment_details', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->where('medical_records.medical_id', $id)
            ->select(
                'medical_records.*',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'users.phone',
                'treatment_details.treatment_id'
            )
            ->orderBy('medical_records.medical_id')
            ->first();

        return view('System.medicalrecord.detail', ['medical' => $medical]);
    }

    public function prescription($medical_id, $treatment_id)
    {
        $treatment = TreatmentDetail::join(
            'medical_records',
            'medical_records.medical_id',
            '=',
            'treatment_details.medical_id'
        )
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->join(
                'treatment_medications',
                'treatment_medications.treatment_id',
                '=',
                'treatment_details.treatment_id'
            )
            ->join('medicines', 'medicines.medicine_id', '=', 'treatment_medications.medicine_id')
            ->where('medical_records.medical_id', $medical_id)
            ->where('treatment_details.treatment_id', $treatment_id)
            ->select(
                'medical_records.*',
                'treatment_details.*',
                'medicines.name',
                'patients.first_name',
                'patients.last_name',
                'patients.birthday',
                'patients.gender',
                'treatment_medications.quantity',
                'treatment_medications.usage'
            )
            ->get();
        //        dd($treatment[0]);
        return view('System.medicalrecord.prescription', ['treatment' => $treatment]);
    }

    public function destroy($medical_id)
    {
        $medicalRecord = MedicalRecord::where('medical_id', $medical_id);
        $medicalRecord->delete();
        return redirect()->route('system.medicalRecord')->with('success', 'Xóa thành công');
    }
}
