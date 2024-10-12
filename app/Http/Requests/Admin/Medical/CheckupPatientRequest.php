<?php

namespace App\Http\Requests\Admin\Medical;

use Illuminate\Foundation\Http\FormRequest;

class CheckupPatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required', 
            'age' => 'required|date',
            'address' => 'required',
            'phone' => 'required|size:10|regex:/^[0-9]{10,15}$/|unique:users,phone',
            'occupation' => 'required',
            'emergency_contact' => 'required',
            'national' => 'required',
            'insurance_number' => 'required|unique:patients,insurance_number',
            
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => ':attribute không để trống',
            'last_name.required' => ':attribute không để trống',
            'first_name.required' => ':attribute không để trống',
            'gender.required' => ':attribute không để trống',
            'age.required' => ':attribute không để trống',
            'address.required' => ':attribute không để trống',
            'phone.size' => ':attribute phải đủ 10 số',
            'phone.required' => ':attribute không để trống',
            'phone.regex' => ':attribute phải là số hợp lệ',
            'phone.unique' => ':attribute đã tồn tại',
            'occupation.required' => ':attribute không để trống',
            'emergency_contact.required' => ':attribute không để trống',
            'national.required' => ':attribute không để trống',
            'insurance_number.required' => ':attribute không để trống',
            'insurance_number.unique' => ':attribute đã tồn tại',

        ];
    }

    public function attributes(): array
    {
        return [
            'patient_id' => 'Mã bệnh nhân',
            'first_name' => 'Họ',
            'last_name' => 'Tên',
            'phone' => 'Số điện thoại',
            'gender' => 'Giới tính',
            'age' => 'Ngày sinh',
            'address' => 'Địa chỉ',
            'occupation' => 'Nghề nghiệp',
            'national' => 'Quốc tịch',
            'insurance_number' => 'Số bảo hiểm',
            'emergency_contact' => 'Liên hệ khẩn cấp',
        ];
    }
}
