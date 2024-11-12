<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép người dùng gửi request
    }

    public function rules(): array
    {
        $serviceId = $this->route('id'); // Lấy ID từ route hoặc trường hidden trong form
        $rules = [
            'name' => [
                'required',
                'string',
                'regex:/^[\p{L}\p{N}\s\-]+$/u',
            ],
            'status' => 'required|integer|in:0,1',
            'price' => [
                'required',
                'regex:/^[1-9]\d*$/',
            ],
            'directory' => 'required'
        ];
    
        // Chỉ thêm unique nếu tên mới khác với old_name ban đầu
        if ($this->input('name') !== $this->input('old_name')) {
            $rules['name'][] = Rule::unique('services', 'name')->ignore($serviceId, 'id');
        }
    
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên dịch vụ là bắt buộc.',
            'name.string' => 'Tên dịch vụ phải là chuỗi ký tự.',
            'name.regex' => 'Tên dịch vụ không có ký tự đặc biệt.',
            'name.unique' => 'Tên đã được sử dụng.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',
            'status.in' => 'Trạng thái chỉ có thể là 0 hoặc 1.',
            'price.required' => 'Giá tiền là bắt buộc.',
            'price.regex' => 'Giá tiền phải là số dương và không có số 0 ở đầu (ví dụ: 1000).',
            'directory.required' => 'Nhóm dịch vụ là bắt buộc.'
        ];
    }
}
