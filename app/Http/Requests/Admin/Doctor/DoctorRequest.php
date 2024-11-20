<?php

namespace App\Http\Requests\Admin\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;


class DoctorRequest extends FormRequest
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
        $userId = $this->route('id');
        $account = User::where('user_id', $userId)->first();


        return [
            'firstname' => 'required|string|max:255|regex:/^[^0-9]*$/',
            'lastname' => 'required|string|max:255|regex:/^[^0-9]*$/',
            'phone' => [
                'required',
                'string',
                'max:11',

                Rule::unique('users', 'phone')->ignore($account->row_id, 'row_id'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($account->row_id, 'row_id'),
            ],
            'degree' => 'nullable|string',
            'work_experience' => 'nullable|string', // Số năm kinh nghiệm
            'description' => 'nullable|string', // Giới hạn mô tả
        ];
    }

    public function attributes()
    {
        return [
            'firstname' => 'Tên',
            'lastname' => 'Họ',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'degree' => 'Bằng cấp',
            'work_experience' => 'Kinh nghiệm làm việc',
            'description' => 'mô tả',
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => 'Trường :attribute là bắt buộc.',
            'firstname.string' => 'Trường :attribute phải là chuỗi ký tự.',
            'firstname.max' => 'Trường :attribute không được vượt quá :max ký tự.',
            'firstname.regex' => 'Trường :attribute không được chứa số.',

            'lastname.required' => 'Trường :attribute là bắt buộc.',
            'lastname.string' => 'Trường :attribute phải là chuỗi ký tự.',
            'lastname.max' => 'Trường :attribute không được vượt quá :max ký tự.',
            'lastname.regex' => 'Trường :attribute không được chứa số.',

            'phone.required' => 'Trường :attribute là bắt buộc.',
            'phone.string' => 'Trường :attribute phải là chuỗi ký tự.',
            'phone.unique' => 'Trường :attribute đã tồn tại.',
            'phone.max' => 'Trường :attribute không được vượt quá :max ký tự.',

            'email.required' => 'Trường :attribute là bắt buộc.',
            'email.email' => 'Trường :attribute không đúng định dạng.',
            'email.unique' => 'Trường :attribute đã tồn tại.',

            'degree.string' => 'Trường :attribute phải là chuỗi ký tự.',
            'work_experience.string' => 'Trường :attribute phải là chuỗi ký tự.',
            'description.string' => 'Trường :attribute phải là chuỗi ký tự.',
        ];
    }

}
