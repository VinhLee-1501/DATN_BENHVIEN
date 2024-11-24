<?php

namespace App\Http\Requests\Admin\Specialty;

use App\Models\Specialty;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $specialty;

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
        $id = $this->route('id');
        $this->specialty = Specialty::where('specialty_id', $id)->first();
        $rules = [
            'specialtyStatus' => 'boolean',
        ];

        if ($this->specialty && $this->input('specialtyName') !== $this->specialty->name) {
            $rules['specialtyName'] = 'required|unique:specialties,name|max:255';
        } else {
            $rules['specialtyName'] = 'required|max:255';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'specialtyName.required' => 'Tên chuyên khoa không được bỏ trống',
            'specialtyName.unique' => 'Tên chuyên khoa đã tồn tại',
            'specialtyName.max' => 'Tên chuyên khoa không được dài quá 255 ký tự',
            'specialtyStatus.boolean' => 'Trạng thái phải là 0 hoặc 1',
        ];
    }
}