<?php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone' =>  'required|numeric|digits_between:10,15',
            'password' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => ':attribute không được để trống',
            'phone.numeric' => ':attribute phải là số',
            'phone.digits_between' => ':attribute phải có từ 10 đến 15 chữ số',

            'password.required' => ':attribute không được để trống',
            'password.max' => ':attribute tối đa 255 ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
        ];
    }
}
