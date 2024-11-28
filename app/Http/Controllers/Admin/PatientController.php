<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Http\Requests\Admin\patient\PatientRequest;
use App\Models\Patient;
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



        // Thông báo thành công và chuyển hướng về trang danh sách bệnh nhân
        return redirect()->route('system.patient')->with('success', 'Thông tin bệnh nhân đã được cập nhật thành công.');
    }
}