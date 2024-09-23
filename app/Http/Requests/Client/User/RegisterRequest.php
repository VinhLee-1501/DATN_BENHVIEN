<?php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép tất cả người dùng gửi yêu cầu
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:3|confirmed',
            'phone' => 'required|string|min:10|unique:users,phone',
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => ':attribute không để trống',
            'firstname.string' => ':attribute phải là chuỗi ký tự',
            'firstname.max' => ':attribute tối đa 50 ký tự',

            'lastname.required' => ':attribute không để trống',
            'lastname.string' => ':attribute phải là chuỗi ký tự',
            'lastname.max' => ':attribute tối đa 50 ký tự',


            'email.required' => ':attribute không để trống',
            'email.email' => ':attribute không đúng định dạng. Vd: abc@gmail.com',
            'email.max' => ':attribute tối đa 255 ký tự',
            'email.unique' => ':attribute đã tồn tại',

            'password.required' => ':attribute không để trống',
            'password.string' => ':attribute phải là chuỗi ký tự',
            'password.min' => ':attribute tối thiểu 3 ký tự',
            'password.confirmed' => ':attribute không trùng khớp với xác nhận mật khẩu',

            'phone.required' => ':attribute không để trống',
            'phone.string' => ':attribute phải là chuỗi ký tự',
            'phone.min' => ':attribute phải có ít nhất 10 ký tự',
            'phone.unique' => ':attribute đã tồn tại',
        ];
    }

    public function attributes(): array
    {
        return [
            'firstname' => 'Tên',
            'lastname' => 'Họ',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'password_confirmation' => 'Xác nhận mật khẩu',
            'phone' => 'Số điện thoại',
        ];
    }
}
