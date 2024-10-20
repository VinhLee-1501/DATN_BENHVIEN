<?php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangePasswordRequest extends FormRequest
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
        return [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:3|confirmed', // Đảm bảo mật khẩu mới có ít nhất 8 ký tự và được xác nhận
        ];
    }

    /**
     * Định nghĩa thông điệp lỗi tùy chỉnh cho các quy tắc xác thực.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Bạn phải nhập mật khẩu hiện tại.',
            'current_password.string' => 'Mật khẩu hiện tại phải là chuỗi ký tự.',

            'new_password.required' => 'Bạn phải nhập mật khẩu mới.',
            'new_password.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];
    }

    /**
     * Định nghĩa tên các thuộc tính cho thông điệp lỗi.
     */
    public function attributes(): array
    {
        return [
            'current_password' => 'Mật khẩu hiện tại',
            'new_password' => 'Mật khẩu mới',
        ];
    }
}
