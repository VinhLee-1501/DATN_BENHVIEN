<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Khởi tạo mảng rules
        $rules = [
            'discount_code' => 'required|max:10|unique:coupons,discount_code',
            'status' => 'nullable|integer|in:0,1,2',
            'percent' => 'required|integer|min:0|max:100',
            'use_limit' => 'required|integer',
            'min_purchase' => 'nullable|integer',
            'product_id' => 'nullable',
            'category_id' => 'nullable',
            'time_start' => 'required|date',
            'time_end' => 'required|date',
            'note' => 'required|max:225',
        ];

        // Kiểm tra và thêm điều kiện cho 'name' nếu có
        $discount_code = $this->route('id'); // Lấy discount_code từ URL
        if ($this->input('discount_code') !== $this->input('old_code')) {
            // Nếu tên thay đổi, kiểm tra tên duy nhất trừ bản hiện tại
            $rules['discount_code'] = ['required', Rule::unique('coupons', 'discount_code')->ignore($discount_code, 'discount_code')];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'discount_code.required' => 'Mã giảm giá không được để trống',
            'discount_code.max' => 'Mã giảm giá không được vượt quá 10 ký tự',
            'discount_code.unique' => 'Mã giảm giá đã được đặt',
            'percent.required' => 'Phần trăm giảm giá không được để trống',
            'percent.min' => 'Phần trăm giảm giá không thể nhỏ hơn 0',
            'percent.max' => 'Phần trăm giảm giá không thể lớn hơn 100',
            'percent.integer' => 'Phần trăm giảm giá phải là số',
            'product_id.required' => 'Sản phẩm không được để trống',
            'category_id.required' => 'Danh mục không được để trống',
            'time_start.required' => 'Ngày bắt đầu không được để trống',
            'time_end.required' => 'Ngày kết thúc không được để trống',
            'time_start.date' => 'Ngày bắt đầu phải là một ngày hợp lệ',
            'time_end.date' => 'Ngày kết thúc phải là một ngày hợp lệ',
            'use_limit.required' => 'Số lần sử dụng không được để trống',
            'use_limit.integer' => 'Số lần sử dụng phải là một số nguyên',
            'note.required' => 'Mô tả không được để trống',
            'name.required' => 'Tên dịch vụ không được để trống',  // Thêm thông báo cho name nếu cần
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $type = $this->input('type');
            $time_start = $this->input('time_start');
            $time_end = $this->input('time_end');

            // Kiểm tra time_start không phải là ngày hôm qua
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            if ($time_start === $yesterday) {
                $validator->errors()->add('time_start', 'Ngày bắt đầu không thể là ngày hôm qua');
            }

            // Kiểm tra time_end không phải là ngày hôm qua hoặc ngày hôm nay
            $today = Carbon::today()->format('Y-m-d');
            if ($time_end === $yesterday || $time_end === $today) {
                $validator->errors()->add('time_end', 'Ngày kết thúc phải là ngày mai hoặc các ngày sau');
            }

            // Các kiểm tra khác (percent, product_id, category_id) vẫn giữ nguyên
            if ($type == 0 && !$this->filled('min_purchase')) {
                $validator->errors()->add('min_purchase', 'Phần trăm giảm giá không được để trống');
            }

            if ($type == 1 && !$this->filled('product_id')) {
                $validator->errors()->add('product_id', 'Sản phẩm không được để trống');
            }

            if ($type == 2 && !$this->filled('category_id')) {
                $validator->errors()->add('category_id', 'Danh mục không được để trống');
            }
        });
    }
}
