<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép người dùng gửi request
    }

    public function rules(): array
    {
        // Lấy ID và tên cũ của bản ghi từ request
        $serviceId = $this->route('id');
        $oldName = $this->input('old_name');

        $rules = [
            'name' => [
                'required',
                'string',
                'regex:/^[\p{L}\p{N}\s\-]+$/u',
                'max:50'
                
            ],
            'status' => 'required|integer|in:0,1',
            'price' => [
                'required',
                'regex:/^[1-9]\d*$/',
                'min:1000',
                'integer'
            ],
            'directory' => 'required'
        ];

        // Chỉ kiểm tra unique nếu tên mới khác với tên cũ
        if ($this->input('name') !== $oldName) {
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
            'name.max' => 'Tên dịch vụ không thể vượt quá 50 kí tự',
            'name.unique' => 'Tên đã được sử dụng.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',
            'status.in' => 'Trạng thái chỉ có thể là 0 hoặc 1.',
            'price.required' => 'Giá tiền là bắt buộc.',
            'price.regex' => 'Giá tiền phải là số dương và không có số 0 ở đầu (ví dụ: 1000).',
            'price.min' => 'Giá tiền nhỏ nhất 1000.',
            'directory.required' => 'Nhóm dịch vụ là bắt buộc.'
        ];
    }
}
