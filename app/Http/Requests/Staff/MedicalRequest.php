<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class MedicalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép request này
    }

    public function rules(): array
    {
        return [
            'specialty_id' => 'required',
            'shift_id' => 'required',
            'symptoms' => 'required',
            'blood_pressure' => 'required|numeric',
            'respiratory_rate' => 'required|numeric',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
        ];
    }
    /**
     * Custom validation messages for the rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [

            'blood_pressure.required' => ':attribute không để trống',
            'blood_pressure.numeric' => ':attribute phải là một số',
            'respiratory_rate.required' => ':attribute không để trống',
            'respiratory_rate.numeric' => ':attribute phải là một số',
            'height.required' => ':attribute không để trống',
            'height.numeric' => ':attribute phải là một số',
            'weight.required' => ':attribute không để trống',
            'weight.numeric' => ':attribute phải là một số',
            'symptoms.required' => ':attribute không để trống',
            'specialty_id.required' => ':attribute không để trống',
            'shift_id.required' => ':attribute không để trống',
  
            
        ];
    }
    public function attributes(): array
    {
        return [
            'blood_pressure' => 'Huyết áp',
            'respiratory_rate' => 'Nhịp thở',
            'height' => 'Chiều cao',
            'weight' => 'Cân nặng',
            'symptoms' => 'Triệu chứng',
            'specialty_id' => 'Chuyên khoa',
            'shift_id' => 'Bác sĩ',
           
            
        ];
    }
}