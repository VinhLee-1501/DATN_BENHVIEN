<?php

namespace App\Http\Requests\Admin;

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
    public function rules()
    {
        $userId = $this->route('user_id'); // Lấy user_id từ route để phân biệt giữa thêm mới và chỉnh sửa

        // Nếu là phương thức thêm mới (POST)
        if ($this->isMethod('post')) {
            return [
                'role' => 'required|in:0,1,2',
                'email' => 'required|email|unique:users,email', // Kiểm tra tính duy nhất khi thêm mới
                'phone' => 'required|regex:/^[0-9]{10}$/|unique:users,phone', // Kiểm tra tính duy nhất khi thêm mới
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'password' => 'required|min:8|confirmed',
            ];
        }

        // Nếu là phương thức chỉnh sửa (PATCH/PUT)
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            return [
                'role' => 'required|in:0,1,2',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($userId, 'user_id'), // Bỏ qua email của chính user hiện tại
                ],
                'phone' => [
                    'required',
                    'regex:/^[0-9]{10}$/',
                    Rule::unique('users')->ignore($userId, 'user_id'), // Bỏ qua số điện thoại của user hiện tại
                ],
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'password' => 'nullable|min:8|confirmed', // Mật khẩu không bắt buộc khi chỉnh sửa
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
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại tối đa 10 ký tự.',
            'phone.unique' => 'Số điện thoại đã tồn tại',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'firstname.required' => 'Tên không được để trống.',
            'firstname.string' => 'Tên phải là chuỗi ký tự.',
            'firstname.max' => 'Tên tối đa 40 ký tự.',

            'lastname.required' => 'Họ không được để trống.',
            'lastname.string' => 'Họ phải là chuỗi ký tự.',
            'lastname.max' => 'Họ tối đa 10 ký tự.',
        ];
    }

}
