<?php

namespace App\Http\Requests\Admin\Medical;

use Illuminate\Foundation\Http\FormRequest;

class CheckupHealthRequest extends FormRequest
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
            'blood_pressure' => 'required|numeric',
            'respiratory_rate' => 'required|numeric',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'symptoms' => 'required',
            'diaginsis' => 'required',
            're_examination_date' => 'required',
            'advice' => 'required',

        ];
    }

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
            'diaginsis.required' => ':attribute không để trống',
            're_examination_date.required' => ':attribute không để trống',
            // 're_examination_date.date' => ':attribute phải là một ngày hợp lệ',
            'advice.required' => ':attribute không để trống',

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
            'diaginsis' => 'Chuẩn đoán',
            're_examination_date' => 'Ngày tái khám',
            'advice' => 'Lời khuyên',
        ];
    }
}
