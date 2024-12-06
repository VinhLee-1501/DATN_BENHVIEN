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
            'emergency_contact' => 'size:10|regex:/^[0-9]{10,15}$/',
            'age' => 'required|date',
            'address' => 'required',
            'cccd' => 'required|digits:12',
            'phone' => 'required|size:10|regex:/^[0-9]{10,15}$/|unique:patients,phone',
            'national' => 'required',
            'email' => 'required|email',
           
            
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => ':attribute không để trống',
            'last_name.required' => ':attribute không để trống',
            'first_name.required' => ':attribute không để trống',
            'age.required' => ':attribute không để trống',
            'address.required' => ':attribute không để trống',
            'cccd.digits' => ':attribute phải là số và có 12 chữ số.',
            'cccd.required' => ':attribute không để trống',
            'phone.size' => ':attribute phải đủ 10 số',
            'phone.required' => ':attribute không để trống',
            'phone.unique' => ':attribute đã được sử dụng',
            'emergency_contact.size' => ':attribute phải đủ 10 số',
            'emergency_contact.regex' => ':attribute phải là số hợp lệ',
            'phone.regex' => ':attribute phải là số hợp lệ',  
            'national.required' => ':attribute không để trống',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',

        ];
    }

    public function attributes(): array
    {
        return [
            'patient_id' => 'Mã bệnh nhân',
            'first_name' => 'Họ',
            'last_name' => 'Tên',
            'phone' => 'Số điện thoại',
            'age' => 'Ngày sinh',
            'address' => 'Địa chỉ',
            'cccd' => 'CCCD/CMND',
            'national' => 'Quốc tịch',
            'emergency_contact' => 'SĐT khẩn cấp',
        ];
    }
}