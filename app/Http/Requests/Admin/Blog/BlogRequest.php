<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép người dùng gửi request
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'regex:/^[\p{L}\p{N}\s\-]+$/u',
            ],
            'content' => 'required|string',
            'author' => 'required|string',
            'status' => 'nullable|integer|in:0,1',
            'thumbnail' => 'nullable',
            'date' => 'nullable',
            'describe' => 'required'

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'content.required' => 'Nội dung là bắt buộc.',
            'author.required' => 'Tác giả là bắt buộc.',
            'thumbnail.required' => 'Ảnh đại diện là bắt buộc.',
            'date.required' => 'Cần nhập ngày xuât bản',
            'describe.required' => 'Cần nhập mô tả',
            'title.regex' => 'Tiêu đề không có ký tự đặc biệt'
        ];
    }
}
