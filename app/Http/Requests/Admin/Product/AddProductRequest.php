<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**|max
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:products,name',
            'product_images' => 'nullable|array',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
            'category_id' => 'required',
            'active_ingredient' => 'required',
            'unit_of_measurement' => 'required|max:50',
            'code_product' => 'required|unique:products,code_product|max:50',
            'used' => 'required',
            'description' => 'required',
            'brand' => 'required',
            'price' => 'required|numeric|min:0',
            'manufacture' => 'required|max:255',
            'registration_number' => 'required|max:50|unique:products,registration_number',
        ];
    }

    public function messages(): array
    {
        return [
            'code_product.required' => ':attribute không được để trống',
            'code_product.unique' => ':attribute đã tồn tại',
            'code_product.max' => ':attribute tối đa 50 ký tự',

            'name.required' => ':attribute không được để trống',
            'name.unique' => ':attribute đã tồn tại',
            'name.max' => ':attribute tối đa 255 ký tự',

            'product_images.array' => ':attribute phải là mảng',
            'product_images.*.image' => ':attribute phải là định dạng ảnh',
            'product_images.*.mimes' => ':attribute phải là jpeg, png, jpg, gif hoặc svg',

            'category_id.required' => ':attribute không được để trống',
            'description.required' => ':attribute không được để trống',
            

            'active_ingredient.required' => ':attribute không được để trống',

            'unit_of_measurement.required' => ':attribute không được để trống',
            'unit_of_measurement.max' => ':attribute tối đa 50 ký tự',

          
            'used.required' => ':attribute không được để trống',

            'price.required' => ':attribute không được để trống',
            'price.numeric' => ':attribute phải là số',
            'price.min' => ':attribute phải lớn hơn hoặc bằng 0',

            'manufacture.required' => ':attribute không được để trống',
            'manufacture.max' => ':attribute tối đa 255 ký tự',

            'brand.required' => ':attribute không được để trống',

            'registration_number.required' => ':attribute không được để trống',
            'registration_number.max' => ':attribute tối đa 50 ký tự',
            'registration_number.unique' => ':attribute đã tồn tại',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên thuốc',
            'product_images' => 'Ảnh sản phẩm',
            'category_id' => 'Nhóm thuốc',
            'active_ingredient' => 'Hoạt tính',
            'unit_of_measurement' => 'Đơn vị',
            'code_product' => 'Mã sản phẩm',
            'used' => 'Công dụng',
            'description' => 'Mô tả',
            'price' => 'Giá',
            'brand' => 'Thương hiệu',
            'manufacture' => 'Nhà sản xuất',
            'registration_number' => 'Số đăng ký',
        ];
    }
}