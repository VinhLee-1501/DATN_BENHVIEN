<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medical\CheckupHealthRequest;
use App\Http\Requests\Admin\Medical\CheckupPatientRequest;
use App\Models\Book;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Order;
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
use Illuminate\Support\Facades\DB;

class CheckupHealthController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->user_id;
        // dd($user_id);
        $book = Book::join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('users.user_id', $user_id)
            ->where('books.status', 1)
            ->select(
                'books.status as status',
                'books.name as name',
                'books.phone as phone',
                'books.day as day',
                'books.symptoms as symptoms',
                'books.book_id as book_id',
            )
            ->get();
        // dd($book);
        return view('System.doctors.checkupHealth.index', compact('book'));
    }

    public function create($book_id, Request $request)
    {

        $book = Book::where('book_id', $book_id)->get();
        $phone = $book[0]->phone;
        $patient = Patient::where('phone', $phone)->first();
        // dd($patient);
        if (!$patient) {
            $user = $book->first();
        } else {

            $patient_id = $patient->patient_id;
            $medicalRecord = Book::join('medical_records', 'medical_records.book_id', 'books.book_id')
                ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
                ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
                ->where('medical_records.patient_id', $patient_id)
                ->groupBy('medical_records.medical_id', 'patients.patient_id', 'patients.first_name', 'patients.last_name', 'patients.gender')
                ->get();
            $user = [
                'medicalRecord' => $medicalRecord,
                'patient' => $patient,
                'book' => $book->first()
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
                'medicine' => $medicine
            ]

        );
    }


    public function store(CheckupHealthRequest $request, $medical_id)
    {
        
        $medical_record = MedicalRecord::where('medical_id', $medical_id)->first();
        // dd($medical_id);
        $book_id = $medical_record->book_id;
       
        $medical_id = $medical_record->medical_id;
        $patient_id = $medical_record->patient_id;
        $book = Book::where('book_id',$book_id)->first();
        $patient = Patient::where('patient_id', $patient_id)->first();
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
            // dd($saveMedicine);
            $saveMedicine->save();
        }


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
        $medical->date  = now();

        $medical->update();
        return redirect()->route('system.recordDoctor')->with('success', 'Lưu thông tin bệnh án thành công.');
    }

    public function storePatient(CheckupPatientRequest $request, $book_id)
    {
        $book = Book::where('book_id', $book_id)->first();
        $phone = $book->phone;

        $existingUser = User::where('phone', $phone)->first();
        if (!$existingUser) {
            $user = new User();
            $user->user_id = strtoupper(Str::random(10));
            $user->firstname = $request->input('first_name');
            $user->lastname = $request->input('last_name');
            $user->password = $user->user_id.'12345';
            $user->phone = $phone;
            $user->role = 0;
            $user->save();
        }


            $patient = new Patient();
            $patient->patient_id = $request->input('patient_id');
            $patient->first_name = $request->input('first_name');
            $patient->last_name = $request->input('last_name');
            $patient->phone = $phone; // Sử dụng phone từ book
            $patient->gender = $request->input('gender');
            $patient->birthday = $request->input('age');
            $patient->address = $request->input('address');
            $patient->occupation = $request->input('occupation');
            $patient->national = $request->input('national');
            $patient->insurance_number = $request->input('insurance_number');
            $patient->emergency_contact = $request->input('emergency_contact');

            $patient->save();
        
        return redirect()->route('system.checkupHealth.create', $book_id)->with('success', 'Lưu thông tin bệnh nhân thành công.');
    }

  
    public function saveService(Request $request, $book_id)
    {
        // dd($book_id);
        $user = Auth::user();
        $user_id = $user->user_id;
        $book = Book::where('book_id', $book_id)->first();
        $phone = $book->phone;
        $symptom = $book->symptoms;
        $patient = Patient::where('phone',$phone)->first();
        
        if(!$patient){
            return redirect()->route('system.checkupHealth.create', $book_id)->with('error', 'Nhập thông tin bệnh nhân');
        }

        $patient_id = $patient->patient_id;

        if (!$request->input('selectedService')) {
            return redirect()->route('system.checkupHealth.create', $book_id)->with('error', 'Mời chọn cận lâm sàng');
        }
        $medical_record = new MedicalRecord();
        $medical_record->medical_id =  strtoupper(Str::random(10));
        $medical_record->date = now();
        $medical_record->symptom = $symptom;
        $medical_record->book_id = $book_id;
        $medical_record->patient_id = $patient_id;
        $medical_record->user_id = $user_id;
        $medical_record->status = 2;
        $medical_record->save();

        if ($medical_record) {
            $book->status = 2;
            // dd($book);
            $book->update();
        }

        // dd($medical_record);

        if ($medical_record) {

            $treatment = new TreatmentDetail();
            $treatment->treatment_id = strtoupper(Str::random(10));
            $treatment->medical_id = $medical_record->medical_id;
            // dd($treatment->medical_id);
            $treatment->save();
        }

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
        $totalprice = TreatmentService::where('treatment_id', $treatment_id)
            ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
            ->select(
                'treatment_services.treatment_id',
                DB::raw('COUNT(services.service_id) AS service_count'),
                DB::raw('SUM(services.price) AS total_price')
            )
            ->groupBy('treatment_services.treatment_id')
            ->get();

        $medical_patient = MedicalRecord::where('patient_id', $patient_id)->get();
        $service = Service::get();
        $medicine = Medicine::select('*')->distinct()->get();
        $medical = MedicalRecord::orderBy('row_id', 'desc')->first();
        
        $order = new Order();
        $order->order_id = strtoupper(Str::random(10));
        $order->treatment_id = $treatment->treatment_id;
        $order->status = 0;
        $order->role = 0;
        $order->total_price = $totalprice[0]->total_price;
        $order->save();

        
        return view(
            'System.doctors.checkupHealth.medicalRecord',
            [
                'book' => $book,
                'medical' =>$medical,
                'patient' => $patient,
                'services' => $services,
                'service' => $service,
                'totalprice' => $totalprice,
                'medicine' => $medicine,
                'medical_patient' => $medical_patient
            ]
        )->with('success', 'Lưu cận lâm sàng thành công.');;
    }
}