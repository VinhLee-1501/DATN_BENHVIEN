<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medical\CheckupPatientRequest;
use App\Models\MedicalRecord;
use App\Http\Requests\Admin\patient\PatientRequest;
use App\Http\Requests\Staff\MedicalRequest;
use App\Mail\PatientAccount;
use App\Models\Book;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Tạo truy vấn cơ bản cho bảng bệnh nhân
        $query = Patient::leftJoin('users', 'patients.phone', '=', 'users.phone')
            ->select(
                'patients.*',
                'users.avatar'
            );

        // Tìm kiếm động
        if ($request->filled('firstname')) {
            $query->where('patients.first_name', 'like', '%' . $request->firstname . '%');
        }
        if ($request->filled('lastname')) {
            $query->where('patients.last_name', 'like', '%' . $request->lastname . '%');
        }
        if ($request->filled('phone')) {
            $query->where('patients.phone', $request->phone);
        }
        if ($request->filled('gender')) {
            $query->where('patients.gender', $request->gender);
        }

        // Lấy danh sách bệnh nhân cùng với bệnh án của họ
        $patients = $query->orderBy('patients.patient_id', 'desc')
            ->with(['medicalRecords' => function ($query) {
                $query->orderBy('created_at', 'desc') // Sắp xếp bệnh án theo ngày, gần nhất lên đầu
                    ->take(5); // Lấy 5 bệnh án gần nhất
            }])
            ->paginate(10)
            ->appends($request->all());


        // Gửi dữ liệu tới view
        return view('System.patients.index', ['patients' => $patients]);
    }





    public function edit($patient_id)
    {
        $patient = Patient::where('patient_id', $patient_id)->first();

        return view('System.patients.edit', ['patient' => $patient]);
    }

    public function update(PatientRequest $request, $patient_id)
    {
        // Tìm bệnh nhân theo mã bệnh nhân (patient_id)
        $patient = Patient::where('patient_id', $patient_id)->firstOrFail();

        // Cập nhật thông tin bệnh nhân từ request
        $patient->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),  // 0: Nam, 1: Nữ
            'birthday' => $request->input('birthday'),
            'address' => $request->input('address'),
            'occupation' => $request->input('occupation'),
            'national' => $request->input('national'),
            'phone' => $request->input('phone'),
            'Insurance_number' => $request->input('insurance_number'),
            'emergency_contact' => $request->input('emergency_contact'),
        ]);

        return redirect()->route('system.patient')->with('success', 'Thông tin bệnh nhân đã được cập nhật thành công.');
    }

    public function create()
    {
        return view('System.patients.create');
    }

    public function store(CheckupPatientRequest $request)
    {

        // dd($request->all());
        $phone = $request->input('phone');

        $userPhone = User::where('users.phone', $phone)->first();

        if (!$userPhone) {
            $user = new User();
            $user->user_id = strtoupper(Str::random(10));
            $user->firstname = $request->input('first_name');
            $user->lastname = $request->input('last_name');
            $user->password = $user->user_id . '12345';
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->role = 0;
            $user->save();
            Mail::to($user->email)->send(new PatientAccount($user));
        }



        $patient = new Patient();
        $patient->patient_id = $request->input('patient_id');
        $patient->first_name = $request->input('first_name');
        $patient->last_name = $request->input('last_name');
        $patient->phone = $request->input('phone');
        $patient->gender = $request->input('gender');
        $patient->cccd = $request->input('cccd');
        $patient->birthday = $request->input('age');
        $patient->address = $request->input('address');
        $patient->occupation = $request->input('occupation');
        $patient->national = $request->input('national');
        $patient->insurance_number = $request->input('insurance_number');
        $patient->emergency_contact = $request->input('emergency_contact');
        $patient->save();



        return redirect()->route('system.patient')->with('success', 'Thêm bệnh nhân thành công.');
    }

    public function addMedical($patient_id)
    {

        $patient = Patient::where('patients.patient_id', $patient_id)->first();
        $specialty = Specialty::get();



        return response()->json([
            'success' => true,
            'patient' => $patient,
            'specialty' => $specialty,
        ]);
    }

    public function getDoctor($specialty_id)
    {
        $dayNow = Carbon::now()->format('Y-m-d');

        $schedule = Schedule::join('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('schedules.day', '=', $dayNow)
            ->where('sclinics.specialty_id', $specialty_id)
            ->get();
        return response()->json([
            'success' => true,
            'schedule' => $schedule,
        ]);
    }

    public function saveMedical(MedicalRequest $request)
    {
        // dd($request->all());

        $phone = $request->input('phone');

        $user = User::where('users.phone', $phone)->first();
        // dd($user);
        $email = $user->email;
       
        $book = new Book();
        $book->book_id = strtoupper(Str::random(10));
        $book_id = $book->book_id;

        $book->name = $request->input('name');
        $book->phone = $phone;
        $book->email = $email;
        $book->shift_id  = $request->input('shift_id');
        $book->specialty_id = $request->input('specialty_id');
        $book->day = $request->input('day');
        $book->symptoms = $request->input('symptoms');
        $book->status = 1;

        $book->save();

        $medical = new MedicalRecord();
        $medical->medical_id = strtoupper(Str::random(10));
        $medical->patient_id = $request->input('patient_id');
        $medical->book_id = $book_id;
        $medical->symptom = $request->input('symptoms');
        $medical->blood_pressure = $request->input('blood_pressure');
        $medical->respiratory_rate = $request->input('respiratory_rate');
        $medical->weight = $request->input('weight');
        $medical->height = $request->input('height');
        $medical->patient_id  = $request->input('patient_id');
        $medical->date = Carbon::now()->format('Y-m-d H:i:s');
        $medical->status = 0;
        $medical->save();

        return response()->json(['success' => true, 'message' => 'Tạo hồ sơ thành công!']);
        }
}