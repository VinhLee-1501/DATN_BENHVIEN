<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medical\CheckupHealthRequest;
use App\Http\Requests\Admin\Medical\CheckupPatientRequest;
use App\Mail\MedicalRecord as MailMedicalRecord;
use App\Models\Book;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Service;
use App\Models\TableShift;
use App\Models\TreatmentDetail;
use App\Models\TreatmentMedication;
use App\Models\TreatmentService;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OnlineDotor extends Controller
{

    public function createOnline($book_id, Request $request)
    {

        $doctor = Auth::user();
        $book = Book::where('book_id', $book_id)->first();
        $phone = $book->phone;
        $patient = Patient::where('phone', $phone)->first();

        $content = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('specialties', 'specialties.specialty_id', 'books.specialty_id')
            ->join('sclinics', 'sclinics.sclinic_id', 'schedules.sclinic_id')
            ->where('books.book_id', $book_id)
            ->select('sclinics.name as sclinicName', 'specialties.name as specialtyName')
            ->get();


        if (!$patient) {
            $user = $book->first();
        } else {

            $health = MedicalRecord::where('medical_records.book_id', $book_id)->first();

            $patient_id = $patient->patient_id;
            $medicalRecord = Book::join('medical_records', 'medical_records.book_id', 'books.book_id')
                ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
                ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
                ->where('medical_records.patient_id', $patient_id)
                ->groupBy(
                    'medical_records.medical_id',
                    'medical_records.row_id',
                    'medical_records.date',
                    'medical_records.diaginsis',
                    'medical_records.re_examination_date',
                    'medical_records.symptom',
                    'medical_records.status',
                    'medical_records.advice',
                    'medical_records.blood_pressure',
                    'medical_records.respiratory_rate',
                    'medical_records.weight',
                    'medical_records.height',
                    'medical_records.patient_id',
                    'medical_records.book_id',
                    'medical_records.deleted_at',
                    'medical_records.created_at',
                    'medical_records.updated_at',
                    'medical_records.user_id',
                    
                    'patients.patient_id',
                    'patients.first_name',
                    'patients.last_name',
                    'patients.gender',
                    'patients.birthday',
                    'patients.address',
                    'patients.cccd',
                    'patients.insurance_number',
                    'patients.emergency_contact',
                    'patients.occupation',
                    'patients.national',
                    'patients.phone',
                    'patients.deleted_at',
                    'patients.created_at',
                    'patients.updated_at',
                )
                ->orderBy('medical_records.created_at', 'desc')
                ->whereNotNull('medical_records.diaginsis')
                ->limit(3)
                ->get();

            $user = [
                'medicalRecord' => $medicalRecord,
                'patient' => $patient,
                'health' => $health,
                'book' => $book->first(),

            ];
        }


        $service = Service::get();
        $medicine = Medicine::select('*')->distinct()->get();
        return view(
            'System.doctors.checkupHealth.online.createMedical',
            [
                'book' => $book,
                'patient' => $patient,
                'user' => $user,
                'service' => $service,
                'medicine' => $medicine,
                'doctor' => $doctor,
                'content' => $content,
            ]

        );
    }

    public function savePatient(Request $request, $book_id)
    {

        $book = Book::where('book_id', $book_id)->first();
        $phone = $book->phone;

        $existingUser = User::where('phone', $phone)->first();
        if (!$existingUser) {
            $user = new User();
            $user->user_id = strtoupper(Str::random(10));
            $user->firstname = $request->input('first_name');
            $user->lastname = $request->input('last_name');

            $user->password = $user->user_id . '12345';
            $user->phone = $phone;
            $user->role = 0;
            $user->save();
        }

        $existingPatient = Patient::where('phone', $phone)->first();
        if (!$existingPatient) {
            $patient = new Patient();
            $patient->patient_id = $request->input('patient_id');
            $patient->first_name = $request->input('first_name');
            $patient->last_name = $request->input('last_name');
            $patient->phone = $phone; // Sử dụng phone từ book
            $patient->gender = $request->input('gender');
            $patient->cccd = $request->input('cccd');
            $patient->birthday = $request->input('age');
            $patient->address = $request->input('address');
            $patient->occupation = $request->input('occupation');
            $patient->national = $request->input('national');
            $patient->insurance_number = $request->input('insurance_number');
            $patient->emergency_contact = $request->input('emergency_contact');

            $patient->save();
        }


        return redirect()->route('system.Online.create', $book_id)->with('success', 'Lưu thông tin bệnh nhân thành công.');
    }

    public function store(CheckupHealthRequest $request, $book_id)
    {


        $book = Book::where('book_id', $book_id)->first();
        $phone = $book->phone;
        $patient = Patient::where('phone', $phone)->first();
        $user = Auth::user();
        $user_id = $user->user_id;

        $patient_id = $patient->patient_id;
        $medical = new MedicalRecord();
        $medical->medical_id = strtoupper(Str::random(10));
        $medical->diaginsis = $request->input('diaginsis');
        $medical->re_examination_date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('re_examination_date'))->format('Y-m-d');
        $medical->symptom = $request->input('symptoms');
        $medical->status = 3;
        $medical->advice = $request->input('advice');
        $medical->blood_pressure = $request->input('blood_pressure');
        $medical->respiratory_rate = $request->input('respiratory_rate');
        $medical->weight = $request->input('weight');
        $medical->height = $request->input('height');
        $medical->patient_id  = $patient_id;
        $medical->book_id  = $book_id;
        $medical->user_id  = $user_id;
        $medical->date  = now();
        $medical->save();

        $medical_id = $medical->medical_id;
        if ($medical) {
            $treatment = new TreatmentDetail();
            $treatment->treatment_id = strtoupper(Str::random(10));
            $treatment->medical_id  = $medical_id;
            $treatment->save();
        }

        $book = Book::where('book_id', $book_id)->first();
        $table_shift = $book->table_shift_id;

        $shift = TableShift::where('row_id', $table_shift)->first();
        $shift->status = 0;
        $shift->update();



        $treatment_id = $treatment->treatment_id;
        $medicines = json_decode($request->input('selectedMedicines'), true);

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
        Mail::to($book->email)->send(new MailMedicalRecord($medicals, $medicines));


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
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Donthuoc.pdf');
    }
}