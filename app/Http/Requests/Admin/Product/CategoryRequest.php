<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|max:255|unique:categories,name',
            'parent_id' => 'required',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => ':attribute không để trống',
            'name.unique' => ':attribute đã tồn tại',
            'parent_id.required' => ':attribute không để trống',
            'img.image' => 'Chọn 1 :attribute',
            'img.*.image' => ':attribute phải là định dạng ảnh',
            'img.*.mimes' => ':attribute phải là jpeg, png, jpg, gif, webp hoặc svg',


        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên danh mục',
            'parent_id' => 'Danh mục cha',
            'img' => 'ảnh',

        ];
    }
}