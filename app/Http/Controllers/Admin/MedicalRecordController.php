<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Service;
use App\Models\TreatmentDetail;
use App\Models\TreatmentService;
use Illuminate\Support\Facades\DB;

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
        $medical = MedicalRecord::select('medical_records.*', 'patients.*', 'users.*', 'treatment_details.*')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->join('treatment_details', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->join('users', 'users.user_id', '=', 'medical_records.user_id')
            ->where('medical_records.medical_id', $id)
            ->get();
            // dd($medical);
// 
        $treatment_id = $medical[0]->treatment_id;

        $services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
            ->where('treatment_services.treatment_id', $treatment_id)
            ->get();

        $totalprice = TreatmentService::where('treatment_id', $treatment_id)
            ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
            ->select(
                'treatment_services.treatment_id',
                DB::raw('COUNT(services.service_id) AS service_count'),
                DB::raw('SUM(services.price) AS total_price')
            )
            ->groupBy('treatment_services.treatment_id')
            ->get();

        $medicines = Medicine::join('treatment_medications', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
            ->where('treatment_medications.treatment_id', $treatment_id)
            ->get();
        // dd($medicines);
        return view(
            'System.medicalrecord.detail',
            [
                'medical' => $medical,
                'medicines' => $medicines,
                'services' => $services,
                'totalprice' => $totalprice,
            ]
        );

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
