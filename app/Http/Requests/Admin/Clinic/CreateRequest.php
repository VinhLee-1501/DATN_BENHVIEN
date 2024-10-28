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
            'name' => 'required|unique:sclinics,name',
            'specialty_id' => 'required',
            'status' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên phòng khám không được để trống.',
            'name.unique' => 'Tên phòng khám đã tồn tại.',
            'specialty_id.required' => 'Chưa chọn chuyên khoa.',
            'status.required' => 'Chưa chọn trạng thái.'
        ];
    }
}
