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
            'cccd' => 'required|digits:12',
            'phone' => 'required|size:10|regex:/^[0-9]{10,15}$/|unique:patients,phone',
            'national' => 'required',
            'email' => 'required|email|unique:users,email',
  
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
            'phone.regex' => ':attribute phải là số hợp lệ',  
            'national.required' => ':attribute không để trống',
            'email.required' => ':attribute không được để trống.',
            'email.email' => ':attribute không đúng định dạng.',
            'email.unique' => ':attribute đã tồn tại.',

        ];
    }

    public function attributes(): array
    {
        return [
            'patient_id' => 'Mã bệnh nhân',
            'first_name' => 'Tên',
            'last_name' => 'Họ',
            'phone' => 'Số điện thoại',
            'age' => 'Ngày sinh',
            'address' => 'Địa chỉ',
            'cccd' => 'CCCD/CMND',
            'national' => 'Quốc tịch',
            'email' => 'Email',
            
        ];
    }
}