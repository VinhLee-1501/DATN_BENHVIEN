<?php

namespace App\Http\Requests\Admin\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class EditAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $userId = $this->route('user_id'); // Lấy user_id từ route
        $account = User::where('user_id', $userId)->first();

        return [
            'specialty_id' => 'nullable|string',
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'role'       => 'required',
            'email'      => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($account->row_id, 'row_id'),
            ],
            'password'   => 'nullable|min:8',
            'phone'      => [
                'required',
                'string',
                Rule::unique('users', 'phone')->ignore($account->row_id, 'row_id'),
            ],
        ];
    }



    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',

            'firstname.required' => 'Tên không được để trống.',
            'firstname.string' => 'Tên phải là ký tự.',

            'lastname.required' => 'Họ không được để trống.',
            'lastname.string' => 'Họ phải là ký tự.',

            'role.required' => 'Vai trò không được để trống.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ];
    }
}
