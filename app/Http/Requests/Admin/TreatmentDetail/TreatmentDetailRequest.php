<?php

namespace App\Http\Requests\Admin\TreatmentDetail;

use Illuminate\Foundation\Http\FormRequest;

class TreatmentDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép người dùng gửi request
    }

    public function rules(): array
    {
        return [
            'note' => [
                'required',
                'regex:/^[\pL\pN\s\pP]*$/u',
                'max:255' 
            ],
            'result' => [
                'required',
                'regex:/^[\pL\pN\s\pP]*$/u', 
                'max:255' 
            ],
            'image' => 'required', 
        ];
        
    }

    public function messages(): array
    {
        return [
            'note.required' => 'Ghi chú không được để trống.',
            'note.regex' => 'Ghi chú không được chứa ký tự đặc biệt.',
            'note.max' => 'Ghi chú không được dài quá 255 ký tự.',
            'result.required' => 'Kết quả không được để trống.',
            'result.regex' => 'Kết quả không được chứa ký tự đặc biệt.',
            'result.max' => 'Kết quả không được dài quá 255 ký tự.',
            'image.required' => 'Ảnh không được để trống.',
        ];
    }
}
