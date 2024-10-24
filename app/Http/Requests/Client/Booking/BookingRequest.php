<?php

namespace App\Http\Requests\Client\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Định nghĩa các quy tắc xác thực cho yêu cầu này.
     */
    public function rules()
    {
        return [
            'day' => 'required|date|after_or_equal:today',
            'hour' => 'required|date_format:H:i|before_or_equal:16:00',
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'email' => 'required|nullable|email|max:255',
            'role' => 'required',
            'specialty_id' => 'required|exists:specialties,specialty_id',
            'symptoms' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi cho từng trường.
     */
    public function messages()
    {
        return [
            'day.required' => 'Vui lòng chọn ngày.',
            'day.date' => 'Ngày không hợp lệ.',
            'day.after_or_equal' => 'Ngày phải là hôm nay hoặc sau hôm nay.',
            'hour.required' => 'Vui lòng chọn giờ khám.',
            'hour.date_format' => 'Giờ khám phải đúng định dạng HH:MM.',
            'hour.before_or_equal' => 'Giờ khám không được sau 16:00 và trước giờ hiện tại',
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.string' => 'Họ tên không hợp lệ.',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 chữ số.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'specialty_id.required' => 'Vui lòng chọn chuyên khoa.',
            'specialty_id.exists' => 'Chuyên khoa không tồn tại hoặc đã bị khóa.',
            'symptoms.max' => 'Triệu chứng không được vượt quá 1000 ký tự.',
            'role.required' => 'Hình thức khám không được để trống'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $day = $this->input('day');
            $hour = $this->input('hour');

            // Chỉ kiểm tra giờ nếu ngày là ngày hôm nay
            if ($day === Carbon::today()->format('Y-m-d')) {
                $currentHour = Carbon::now()->format('H:i');

                if ($hour < $currentHour) {
                    $validator->errors()->add('hour', 'Giờ khám không được trước giờ hiện tại.');
                }
            }
        });
    }
}
