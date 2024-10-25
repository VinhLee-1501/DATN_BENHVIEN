<?php

namespace App\Http\Requests\Admin\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
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
        $userId = $this->route('user_id'); // Lấy user_id từ route

        // Nếu là phương thức thêm mới (POST)
        if ($this->isMethod('post')) {
            return [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email|unique:users,email', // Kiểm tra tính duy nhất khi thêm mới
                'specialty_id' => 'nullable|string ',
                'phone' => 'required|min:10|unique:users,phone',
                'password' => 'required|min:8',
            ];
        }

        // Nếu là phương thức cập nhật (PATCH/PUT)
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            return [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($userId), // Bỏ qua email của người dùng hiện tại
                ],
                'phone' => [
                    'required',
                    'string',
                    'min:10',
                    Rule::unique('users')->ignore($userId), // Bỏ qua số điện thoại của người dùng hiện tại
                ],
                'birthday' => 'required|date',
            ];
        }

        return [];
    }





    public function messages(): array
    {
        return [

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại đã tồn tại',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

            'firstname.required' => 'Tên không được để trống.',
            'firstname.string' => 'Tên phải là chuỗi ký tự.',

            'lastname.required' => 'Họ không được để trống.',
            'lastname.string' => 'Họ phải là chuỗi ký tự.',


        ];
    }
}
