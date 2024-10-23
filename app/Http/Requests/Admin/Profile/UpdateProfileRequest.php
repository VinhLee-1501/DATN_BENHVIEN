<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép gửi yêu cầu này không.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả người dùng gửi yêu cầu
    }

    /**
     * Định nghĩa các quy tắc xác thực cho yêu cầu.
     */
    public function rules(): array
    {

        $userId = Auth::user();


        if ($this->isMethod('patch') || $this->isMethod('put')) {
            return [
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
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

        // Mặc định sẽ không có quy tắc nào cho phương thức không phải PATCH/PUT
        return [];
    }

    /**
     * Định nghĩa thông điệp lỗi tùy chỉnh cho các quy tắc xác thực.
     */
    public function messages(): array
    {
        return [
            'firstname.required' => ':attribute không được để trống',
            'firstname.string' => ':attribute phải là chuỗi ký tự',
            'firstname.max' => ':attribute tối đa 50 ký tự',

            'lastname.required' => ':attribute không được để trống',
            'lastname.string' => ':attribute phải là chuỗi ký tự',
            'lastname.max' => ':attribute tối đa 50 ký tự',

            'email.required' => ':attribute không được để trống',
            'email.email' => ':attribute không đúng định dạng. Ví dụ: abc@gmail.com',
            'email.max' => ':attribute tối đa 255 ký tự',
            'email.unique' => ':attribute đã tồn tại',

            'phone.required' => ':attribute không được để trống',
            'phone.string' => ':attribute phải là chuỗi ký tự',
            'phone.min' => ':attribute phải có ít nhất 10 ký tự',
            'phone.unique' => ':attribute đã tồn tại',

            'birthday.required' => ':attribute không được để trống',
            'birthday.date' => ':attribute phải là ngày hợp lệ',
        ];
    }

    /**
     * Định nghĩa tên các thuộc tính cho thông điệp lỗi.
     */
    public function attributes(): array
    {
        return [
            'firstname' => 'Tên',
            'lastname' => 'Họ',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'birthday' => 'Ngày sinh',
        ];
    }
}
