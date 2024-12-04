<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medical\CheckupPatientRequest;
use App\Models\MedicalRecord;
use App\Http\Requests\Admin\patient\PatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::leftJoin('medical_records', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->leftJoin('users', 'patients.phone', '=', 'users.phone') // Kết nối với bảng users
            ->select(
                'patients.*',
                'medical_records.medical_id',
                'medical_records.diaginsis',
                'users.avatar'

            )
            ->orderby('row_id', 'desc');

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
        if ($request->filled('insurance_number')) {
            $query->where('patients.insurance_number', $request->insurance_number);
        }
        

        $patientsWithRecords = $query->orderBy('patients.patient_id', 'desc')
            ->paginate(10)
            ->appends($request->all());
        return view('System.patients.index', ['patients' => $patientsWithRecords]);
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

    public function create(){
        return view('System.patients.create');
    }
    
    public function storePatient(CheckupPatientRequest $request)
    {

            $user = new User();
            $user->user_id = strtoupper(Str::random(10));
            $user->firstname = $request->input('first_name');
            $user->lastname = $request->input('last_name');

            $user->password = $user->user_id . '12345';
            $user->phone = $request->input('phone');;
            $user->role = 0;
            $user->save();
        
      
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

        return redirect()->route('system.checkupHealth.create')->with('success', 'Lưu thông tin bệnh nhân thành công.');
    }
}