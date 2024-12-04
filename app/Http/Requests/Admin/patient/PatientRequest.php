<?php

namespace App\Http\Requests\Admin\patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Bật quyền để request có thể thực hiện
    }

    public function rules()
    {
        // Lấy patient_id từ route
        $id = $this->route('patient_id'); // lấy patient_id từ URL
        return [
            'patient_id'         => 'required|string|max:10|unique:patients,patient_id,' . $id . ',patient_id',
            'first_name'          => 'required|string|max:50',
            'last_name'          => 'required|string|max:50',
            'gender'             => 'required|boolean',
            'birthday'           => 'required|date',
            'address'            => 'required|string|max:255',
            'occupation'         => 'required|string|max:30',
            'national'           => 'required|string|max:255',
            'phone'              => 'required|numeric|digits_between:10,11|unique:patients,phone,' . $id . ',patient_id',
            'insurance_number'   => 'numeric|digits_between:1,10|unique:patients,insurance_number,' . $id . ',patient_id',
            'emergency_contact'  => 'required|numeric|digits_between:10,11',
        ];
    }


    public function messages()
    {
        return [
            'patient_id.required'        => 'Mã bệnh nhân là bắt buộc.',
            'patient_id.unique'          => 'Mã bệnh nhân đã tồn tại, vui lòng nhập mã khác.',
            'patient_id.max'             => 'Mã bệnh nhân không được vượt quá 10 ký tự.',

            'first_name.required'         => 'Tên là bắt buộc.',
            'fist_name.max'               => 'Tên không được vượt quá 50 ký tự.',

            'last_name.required'         => 'Họ là bắt buộc.',
            'last_name.max'               => 'Họ không được vượt quá 50 ký tự.',

            'gender.required'            => 'Vui lòng chọn giới tính.',
            'gender.boolean'             => 'Giới tính chỉ nhận giá trị 0 hoặc 1 (Nam hoặc Nữ).',

            'birthday.required'          => 'Ngày sinh là bắt buộc.',
            'birthday.date'              => 'Ngày sinh phải đúng định dạng ngày.',

            'address.required'           => 'Địa chỉ là bắt buộc.',
            'address.max'                => 'Địa chỉ không được vượt quá 255 ký tự.',

            'occupation.required'        => 'Nghề nghiệp là bắt buộc.',
            'occupation.max'             => 'Nghề nghiệp không được vượt quá 30 ký tự.',

            'national.required'          => 'Quốc tịch là bắt buộc.',
            'national.max'               => 'Quốc tịch không được vượt quá 255 ký tự.',

            'phone.required'             => 'Số điện thoại là bắt buộc.',
            'phone.numeric'              => 'Số điện thoại phải là số.',
            'phone.digits_between'       => 'Số điện thoại phải có từ 10 đến 11 chữ số.',
            'phone.unique'               => 'Số điện thoại đã tồn tại, vui lòng nhập số khác.',

            'insurance_number.required'  => 'Số bảo hiểm y tế là bắt buộc.',
            'insurance_number.numeric'   => 'Số bảo hiểm y tế phải là số.',
            'insurance_number.digits_between' => 'Số bảo hiểm y tế phải có từ 1 đến 10 chữ số.',
            'insurance_number.unique' => 'Số bảo hiểm y tế đã tồn tại',

            'emergency_contact.required' => 'Số điện thoại khẩn cấp là bắt buộc.',
            'emergency_contact.numeric'  => 'Số điện thoại khẩn cấp phải là số.',
            'emergency_contact.digits_between' => 'Số điện thoại khẩn cấp phải có từ 10 đến 11 chữ số.',
        ];
    }
}