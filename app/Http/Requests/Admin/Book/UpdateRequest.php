<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => 'required',
            'name' => 'required',
            'phone' => 'required|max:10',
            'email' => 'required',
            'symptoms' => 'required',
            'day' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => ':attribute không để trống',
            'phone.max' => ':attribute tối đa 10 ký tự',
            'phone.required' => ':attribute không để trống',
            'name.required' => ':attribute không để trống',
            'email.required' => ':attribute không để trống',
            'symptoms.required' => ':attribute Không để trống',
            'day.required' => ':attribute Không để trống',
        ];
    }

    public function attributes(): array
    {
        return [
            'book_id' => 'Mã định danh',
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'symptoms' => 'Triệu chứng',
            'day' => 'Ngày',
        ];
    }
}
