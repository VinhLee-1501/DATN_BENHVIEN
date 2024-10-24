<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medical\CheckupHealthRequest;
use App\Http\Requests\Admin\Medical\CheckupPatientRequest;
use App\Models\Book;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Service;
use App\Models\TreatmentDetail;
use App\Models\TreatmentMedication;
use App\Models\TreatmentService;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MedicalRecordDocotrController extends Controller
{

    public function index()
    {
        $medicalRecord = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
            ->where(function ($query) {
                $query->where('status', 3)
                    ->orWhere('status', 2);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // dd($medicalRecord);


        return view('System.doctors.medical.index', ['medicalRecord' => $medicalRecord]);
    }


    public function record($medical_id)
    {

        $medical = MedicalRecord::where('medical_id', $medical_id)->first();
        // dd($medical);
        $medical_id = $medical->medical_id;
        $patient_id = $medical->patient_id;

        $treatment = TreatmentDetail::where('medical_id', $medical_id)->first();

        // dd($medical_id);
        $treatment_id = $treatment->treatment_id;

        $patient = Patient::where('patient_id', $patient_id)->first();
        $services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'treatment_services.treatment_id')
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

        $medical_patient = MedicalRecord::where('patient_id', $patient_id)
            ->join('users', 'users.user_id', '=', 'medical_records.user_id')
            ->select('medical_records.*', 'users.lastname as lastname', 'users.firstname as firstname')
            ->orderBy('medical_records.created_at', 'desc')
            ->limit(5)
            ->get();

        $service = Service::get();
        $medicine = Medicine::select('*')->distinct()->get();

        // dd($medical_patient);

        return view(
            'System.doctors.medical.medicalRecording',
            [
                'medical_patient' => $medical_patient,
                'medical' => $medical,
                'patient' => $patient,
                'services' => $services,
                'service' => $service,
                'totalprice' => $totalprice,
                'medicine' => $medicine,

            ]
        );
    }

    public function store(CheckupHealthRequest $request, $medical_id)
    {

        $treatment = TreatmentDetail::where('medical_id', $medical_id)->first();

        $treatment_id = $treatment->treatment_id;


        $medicines = json_decode($request->input('selectedMedicines'), true);

        // Kiểm tra dữ liệu JSON
        foreach ($medicines as $medicineData) {
            $saveMedicine = new TreatmentMedication();
            $saveMedicine->medicine_id = $medicineData['id'];
            $saveMedicine->treatment_id  =  $treatment_id;
            $saveMedicine->usage = $medicineData['usage'];
            $saveMedicine->dosage = $medicineData['dosage'];
            $saveMedicine->note = $medicineData['note'];
            $saveMedicine->quantity = $medicineData['quantity'];
            $saveMedicine->save();
        }
        $medical = MedicalRecord::where('medical_id', $medical_id)->first();
        $medical->diaginsis = $request->input('diaginsis');
        $medical->re_examination_date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('re_examination_date'))->format('Y-m-d');;
        $medical->symptom = $request->input('symptoms');
        $medical->status = 3;
        $medical->advice = $request->input('advice');
        $medical->blood_pressure = $request->input('blood_pressure');
        $medical->respiratory_rate = $request->input('respiratory_rate');
        $medical->weight = $request->input('weight');
        $medical->height = $request->input('height');
        $medical->date  = now();

        $medical->update();

        $medicals = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->join('users', 'users.user_id', '=', 'medical_records.user_id')
            ->join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('medical_id', $medical_id)
            ->select(
                'users.firstname as first_name_doctor',
                'users.lastname as last_name_doctor',
                'specialties.name as specialty',
                'patients.*',
                'medical_records.*'
            )
            ->get();

        $data = [
            'medicines' => $medicines,
            'medicals' => $medicals,
        ];

        session()->put('pdf_data', $data);

        return redirect()->route('system.recordDoctor')->with('success', 'Lưu thông tin bệnh án thành công.');
    }

    public function download()
    {
        $data = session('pdf_data'); 
    
        if (!$data) {
            return redirect()->back()->with('error', 'Không có dữ liệu để tải.');
        }
    
    
        session()->forget('pdf_data');
    
        $pdf = Pdf::loadView('System.doctors.medical.pdfMedicine', ['data' => $data]);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->download('Donthuoc.pdf');
    }
    


    public function detail($medical_id)
    {
        // dd($medical_id);
        $medical = MedicalRecord::select('medical_records.*', 'patients.*', 'users.*', 'treatment_details.*')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->join('treatment_details', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->join('users', 'users.user_id', '=', 'medical_records.user_id')
            ->where('medical_records.medical_id', $medical_id)
            ->get();

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
            'System.doctors.medical.detail',
            [
                'medical' => $medical,
                'medicines' => $medicines,
                'services' => $services,
                'totalprice' => $totalprice,
            ]
        );
    }

    public function create()
    {
        $service = Service::get();
        $medicine = Medicine::select('*')->distinct()->get();
        return view(
            'System.doctors.medical.create',
            [
                'service' => $service,
                'medicine' => $medicine,

            ]

        );
    }

    public function storePatient(CheckupPatientRequest $request)
    {
        $user = new User();
        $user->user_id = strtoupper(Str::random(10));
        $user->firstname = $request->input('first_name');
        $user->lastname = $request->input('last_name');

        $user->phone = $request->input('phone');
        $user->role = 0;
        $user->save();

        $patient = new Patient();
        $patient->patient_id = $request->input('patient_id');
        $patient->first_name = $request->input('first_name');
        $patient->last_name = $request->input('last_name');
        $patient->phone = $request->input('phone');
        $patient->gender = $request->input('gender');
        $patient->birthday = $request->input('age');
        $patient->address = $request->input('address');
        $patient->occupation = $request->input('occupation');
        $patient->national = $request->input('national');
        $patient->insurance_number = $request->input('insurance_number');
        $patient->emergency_contact = $request->input('emergency_contact');

        $patient->save();
        $patient = Patient::orderBy('row_id', 'desc')->first();
        $service = Service::get();
        $medicine = Medicine::select('*')->distinct()->get();
        return view('System.doctors.medical.createpatient', [
            'service' => $service,
            'medicine' => $medicine,
            'patient' => $patient,

        ])->with('success', 'Lưu thông tin bệnh nhân thành công.');
    }

}
