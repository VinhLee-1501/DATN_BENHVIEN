<?php

namespace App\Http\Requests\Admin\Clinic;

use Illuminate\Foundation\Http\FormRequest;

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
            'sclinicName' => 'required|unique:sclinics,name',
            'specialtyName' => 'required',
            'description' => 'required',
            'statusSclinic' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'sclinicName.required' => 'Tên phòng khám không được để trống.',
            'sclinicName.unique' => 'Tên phòng khám đã tồn tại.',
            'specialtyName.required' => 'Chưa chọn chuyên khoa.',
            'description.required' => 'Mô tả không được để trống',
            'statusSclinic.required' => 'Chưa chọn trạng thái.'
        ];
    }
}
