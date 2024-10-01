<?php

namespace App\Http\Requests\Admin\Medicine;

use Illuminate\Foundation\Http\FormRequest;

class MedicineTypeRequest extends FormRequest
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
            'code' => 'required|max:10|unique:medicine_types,medicine_type_id',
            'name' => 'required|max:255|unique:medicine_types,name',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => ':attribute không để trống',
            'code.regex' => ':attribute phải là chuỗi ký tự chữ in hoa và số',
            'code.max' => ':attribute tối đa 10 ký tự',
            'code.unique' => ':attribute mã nhóm thuốc đã tồn tại',

            'name.required' => ':attribute không để trống',
            'name.unique' => ':attribute đã tồn tại',

        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'Mã nhóm thuốc',
            'name' => 'Tên nhóm thuốc',

        ];
    }
}
