<?php

namespace App\Http\Requests\Admin\Schedule;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateRequest extends FormRequest
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
            'user_id' => 'required',
            'sclinic_id' => 'required',
            'day' => 'required|date|after_or_equal:today',
            'note' => 'required',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => ':attribute không được để trống',
            'sclinic_id.required' => ':attribute không được để trống',
            'day.required' => ':attribute không được để trống',
            'day.date' => ':attribute không hợp lệ',
            'day.after_or_equal' => ':attribute phải lớn hơn hoặc bằng ngày hiện tại',

        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'Bác sĩ',
            'sclinic_id' => 'Phòng khám',
            'day' => 'Ngày khám',

        ];
    }
}