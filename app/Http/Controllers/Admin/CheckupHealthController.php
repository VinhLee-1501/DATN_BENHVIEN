<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medical\CheckupHealthRequest;
use App\Http\Requests\Admin\Medical\CheckupPatientRequest;
use App\Models\Book;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Models\Patient;
use App\Models\Service;
use App\Models\TreatmentDetail;
use App\Models\TreatmentMedication;
use App\Models\TreatmentService;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckupHealthController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->user_id;

        $book = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('users.user_id', $user_id)
            ->where('books.status', 1)
            ->select(
                'books.*'
            )
            ->orderBy('books.row_id', 'desc');
        if ($request->filled('name')) {
            $book->where('books.name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('phone')) {
            $book->where('books.phone', 'like', '%' . $request->name . '%');
        }

        $online = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('schedules.user_id', $user_id)
            ->where('books.status', 1)
            ->where('books.role', 1)
            ->select(
                'books.*'
            )
            ->paginate(10);



        $offline = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('schedules.user_id', $user_id)
            ->where('books.status', 1)
            ->where('books.role', 0)
            ->select(
                'books.*'
            )
            ->paginate(10);

        // dd($offline);

        return view('System.doctors.checkupHealth.index', [
            'book' => $book,
            'online' => $online,
            'offline' => $offline,

        ]);
    }

    public function create($book_id, Request $request)
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
                    'patients.row_id',
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
            'System.doctors.checkupHealth.checkupHealth',
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



    public function store(CheckupHealthRequest $request, $medical_id)
    {

        $medical_record = MedicalRecord::where('medical_id', $medical_id)->first();

        $book_id = $medical_record->book_id;

        // $medical_id = $medical_record->medical_id;
        $patient_id = $medical_record->patient_id;
        $book = Book::where('book_id', $book_id)->first();
        $patient = Patient::where('patient_id', $patient_id)->first();
        // dd($medical_id);
        $treatment = TreatmentDetail::where('medical_id', $medical_id)->first();

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
        $user = Auth::user();
        $user_id = $user->user_id;

        $patient_id = $patient->patient_id;
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
        $medical->patient_id  = $patient_id;
        $medical->book_id  = $book_id;
        $medical->user_id  = $user_id;
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

        $order_medicine = new OrderMedicine();
        $order_medicine->order_medicine_id = strtoupper(Str::random(10));
        $order_medicine->treatment_id = $treatment_id;
        $order_medicine->save();


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
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Donthuoc.pdf');
    }

    public function storePatient(Request $request, $book_id)
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
            $patient->phone = $phone;
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

        return redirect()->route('system.checkupHealth.create', $book_id)->with('success', 'Lưu thông tin bệnh nhân thành công.');
    }


    public function saveService(Request $request, $book_id)
    {

        $user = Auth::user();
        $user_id = $user->user_id;
        $book = Book::where('book_id', $book_id)->first();
        $phone = $book->phone;
        $symptom = $book->symptoms;
        $patient = Patient::where('phone', $phone)->first();

        if (!$patient) {
            return redirect()->route('system.checkupHealth.create', $book_id)->with('error', 'Nhập thông tin bệnh nhân');
        }

        $patient_id = $patient->patient_id;

        if ($request->input('action') === 'cancel') {
            return redirect()->route('system.checkupHealth.saveMedical', $book_id)
                ->with('success', 'Bạn đã không chọn dịch vụ.');
        } elseif ($request->input('action') === 'select') {

            if (!$request->input('selectedService')) {
                return redirect()->route('system.checkupHealth.create', $book_id)
                    ->with('error', 'Vui lòng chọn cận lâm sàng');
            }

            $medical_recordbook = MedicalRecord::where('medical_records.book_id', $book_id)->first();

            if (!$medical_recordbook) {
                $medical_record = new MedicalRecord();
                $medical_record->medical_id = strtoupper(Str::random(10));
                $medical_record->date = now();
                $medical_record->symptom = $symptom;
                $medical_record->book_id = $book_id;
                $medical_record->patient_id = $patient_id;
                $medical_record->user_id = $user_id;
                $medical_record->status = 2;
                $medical_record->save();
            } else {

                $medical_record = $medical_recordbook;
                $medical_record->update([
                    'status' => 2,
                ]);
            }

            $book->status = 2;
            $book->update();

            $treatment = new TreatmentDetail();
            $treatment->treatment_id = strtoupper(Str::random(10));
            $treatment->medical_id = $medical_record->medical_id;
            $treatment->save();

            if ($treatment) {
                $selectedServices = $request->input('selectedService');
                $services = json_decode($selectedServices, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($services)) {
                    foreach ($services as $serviceId) {
                        $saveService = new TreatmentService();
                        $saveService->service_id = $serviceId;
                        $saveService->treatment_id = $treatment->treatment_id;
                        $treatment_id =  $treatment->treatment_id;
                        $saveService->save();
                    }
                } else {

                    return response()->json(['error' => 'Invalid data format'], 400);
                }
            }

            $phone = $book->phone;
            $services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
                ->join('treatment_details', 'treatment_details.treatment_id', '=', 'treatment_services.treatment_id')
                ->where('treatment_services.treatment_id', $treatment_id)
                ->get();
            $totalprices = TreatmentService::where('treatment_id', $treatment_id)
                ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
                ->select(
                    'treatment_services.treatment_id',
                    DB::raw('COUNT(services.service_id) AS service_count'),
                    DB::raw('SUM(services.price) AS total_price')
                )
                ->groupBy(
                    'treatment_services.id',
                    'treatment_services.treatment_id',
                    'treatment_services.note',
                    'treatment_services.result',
                    'treatment_services.service_id',
                    'treatment_services.deleted_at',
                    'treatment_services.created_at',
                    'treatment_services.updated_at',

                )
                ->get();

            $totalprice = $totalprices->sum('total_price');
            $medical_patient = MedicalRecord::where('patient_id', $patient_id)
                ->join('users', 'users.user_id', '=', 'medical_records.user_id')
                ->select('medical_records.*', 'users.lastname as lastname', 'users.firstname as firstname')
                ->whereNotNull('medical_records.diaginsis')
                ->orderBy('medical_records.created_at', 'desc')
                ->limit(3)
                ->get();
            $service = Service::get();
            $medicine = Medicine::select('*')->distinct()->get();
            $medical = MedicalRecord::orderBy('row_id', 'desc')->first();

            $order = new Order();
            $order->order_id = strtoupper(Str::random(10));
            $order->treatment_id = $treatment->treatment_id;
            $order->status = 0;
            $order->payment = 0;
            $order->total_price = $totalprice;
            $order->save();

            $content = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
                ->join('specialties', 'specialties.specialty_id', 'books.specialty_id')
                ->join('sclinics', 'sclinics.sclinic_id', 'schedules.sclinic_id')
                ->where('books.book_id', $book_id)
                ->select('sclinics.name as sclinicName', 'specialties.name as specialtyName')
                ->get();
            $health = MedicalRecord::where('medical_records.book_id', $book_id)->first();

            return view(
                'System.doctors.checkupHealth.medicalRecord',
                [
                    'book' => $book,
                    'medical' => $medical,
                    'patient' => $patient,
                    'services' => $services,
                    'service' => $service,
                    'totalprice' => $totalprice,
                    'medicine' => $medicine,
                    'medical_patient' => $medical_patient,
                    'user' => $user,
                    'doctor' => $user,
                    'content' => $content,
                    'health' => $health,
                ]
            )->with('success', 'Lưu cận lâm sàng thành công.');
        }
    }

    public function saveMedical(Request $request, $book_id)
    {

        $user = Auth::user();
        $user_id = $user->user_id;
        $book = Book::where('book_id', $book_id)->first();
        $phone = $book->phone;
        $symptom = $book->symptoms;
        $patient = Patient::where('phone', $phone)->first();

        if (!$patient) {
            return redirect()->route('system.checkupHealth.create', $book_id)->with('error', 'Nhập thông tin bệnh nhân');
        }

        $patient_id = $patient->patient_id;

        $medical_book = MedicalRecord::where('medical_records.book_id', $book_id)->first();

        if (!$medical_book) {
            $medical_record = new MedicalRecord();
            $medical_record->medical_id =  strtoupper(Str::random(10));
            $medical_record->date = now();
            $medical_record->symptom = $symptom;
            $medical_record->book_id = $book_id;
            $medical_record->patient_id = $patient_id;
            $medical_record->user_id = $user_id;
            $medical_record->status = 2;
            $medical_record->save();
        } else {
            $medical_record = $medical_book;
            $medical_record->update([
                'status' => 2,
            ]);
        }

        $book->status = 2;
        $book->update();

        $treatment = new TreatmentDetail();
        $treatment->treatment_id = strtoupper(Str::random(10));
        $treatment->medical_id = $medical_record->medical_id;
        $treatment->save();

        $phone = $book->phone;
        $medical_patient = MedicalRecord::where('patient_id', $patient_id)
            ->join('users', 'users.user_id', '=', 'medical_records.user_id')
            ->select('medical_records.*', 'users.lastname as lastname', 'users.firstname as firstname')
            ->whereNotNull('medical_records.diaginsis')
            ->orderBy('medical_records.created_at', 'desc')
            ->limit(3)
            ->get();

        $service = Service::get();
        $medicine = Medicine::select('*')->distinct()->get();
        $medical = MedicalRecord::orderBy('row_id', 'desc')->first();

        $order = new Order();
        $order->order_id = strtoupper(Str::random(10));
        $order->treatment_id = $treatment->treatment_id;
        $order->total_price = 20000;
        $order->status = 0;
        $order->payment = 0;
        $order->save();

        $content = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('specialties', 'specialties.specialty_id', 'books.specialty_id')
            ->join('sclinics', 'sclinics.sclinic_id', 'schedules.sclinic_id')
            ->where('books.book_id', $book_id)
            ->select('sclinics.name as sclinicName', 'specialties.name as specialtyName')
            ->get();

        $totalprice = 20;

        $health = $medical_book;
        return view(
            'System.doctors.checkupHealth.medicalRecord',
            [
                'book' => $book,
                'medical' => $medical,
                'patient' => $patient,
                'service' => $service,
                'medicine' => $medicine,
                'content' => $content,
                'health' => $health,
                'doctor' => $user,
                'totalprice' => $totalprice,
                'medical_patient' => $medical_patient
            ]
        )->with('success', 'Lưu cận lâm sàng thành công.');
    }
}