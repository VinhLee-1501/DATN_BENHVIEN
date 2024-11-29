<?php

namespace App\Http\Requests\Admin\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorCreateRequest extends FormRequest
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
            'firstname' => 'required|string|max:255|regex:/^[^0-9]*$/',
            'lastname' => 'required|string|max:255|regex:/^[^0-9]*$/',
            'phone' => 'nullable|required|max:11|string|unique:users,phone',
            'email' => 'nullable|required|email|unique:users,email',
            'specialty_id' => 'required|exists:specialties,specialty_id',
            'avatar' => 'nullable|image|max:2048',
            'degree' => 'nullable|string',
            'work_experience' => 'nullable',
            'description' => 'nullable',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'firstname' => 'Tên',
            'lastname' => 'Họ',
            'phone' => 'số điện thoại',
            'email' => 'email',
            'birthday' => 'ngày sinh',
            'specialty_id' => 'chuyên khoa',
            'avatar' => 'ảnh đại diện',
            'degree' => 'Bằng casp',
            'work_experience' => 'kinh nghiệm làm việc',
            'description' => 'mô tả',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
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

            'phone.string' => 'Trường :attribute phải là chuỗi ký tự.',
            'phone.unique' => 'Trường :attribute đã tồn tại.',
            'phone.required' => 'Trường :attribute là bắt buộc.',
            'phone.max' => 'Trường :attribute không được vượt quá :max ký tự.',

            'email.required' => 'Trường :attribute là bắt buộc.',
            'email.email' => 'Trường :attribute không đúng định dạng.',
            'email.unique' => 'Trường :attribute đã tồn tại.',

            'birthday.date' => 'Trường :attribute phải là ngày hợp lệ.',

            'specialty_id.required' => 'Trường :attribute là bắt buộc.',
            'specialty_id.exists' => 'Trường :attribute không hợp lệ.',

            'avatar.image' => 'Trường :attribute phải là tệp hình ảnh.',
            'avatar.max' => 'Trường :attribute không được lớn hơn :max KB.',

            'degree.string' => 'Trường :attribute phải là chuỗi ký tự.',

            'work_experience.string' => 'Trường :attribute phải là chuỗi ký tự.',

            'description.string' => 'Trường :attribute phải là chuỗi ký tự.',

        ];
    }
}
