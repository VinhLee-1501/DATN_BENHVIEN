<?php

namespace App\Http\Requests\Admin\Specialty;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateRequest extends FormRequest
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
            'specialtyName' => 'required|unique:specialties,name',
        ];
    }


    public function messages(): array{
        return [
            'specialtyName.required' => ':attribute không được bỏ trống',
            'specialtyName.unique' => ':attribute đã tồn tại',
        ];
    }

    public function attributes(): array{
        return [
            'specialtyName' => 'Tên chuyên khoa',
        ];
    }
}
