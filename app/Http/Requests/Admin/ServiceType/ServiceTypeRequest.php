<?php

namespace App\Http\Requests\Admin\ServiceType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép người dùng gửi request
    }

    public function rules(): array
    {
        $directoryId = $this->route('id'); // Lấy ID hiện tại từ route hoặc request
        
        $rules = [
            'name' => [
                'required',
                'string',
                'regex:/^[\p{L}\p{N}\s\-]+$/u',
                'max:50'
            ],
            'status' => 'nullable|integer|in:0,1',
        ];
    
        // Chỉ kiểm tra unique nếu tên đã thay đổi
        if ($this->input('name') !== $this->input('old_name')) {
            $rules['name'][] = Rule::unique('service_directories', 'name')->ignore($directoryId, 'id');
        }
    
        return $rules;
    }
    

    public function messages(): array
    {
        return [
            'name.required' => 'Tên nhóm dịch vụ là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'name.regex' => 'Tên nhóm dịch vụ không có ký tự đặc biệt',
            'name.unique' => 'Tên không thể trùng',
            'name.max' => 'Tên danh mục dịch vụ không thể vượt quá 50 kí tự',
        ];
    }
}
