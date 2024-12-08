<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Booking\BookingRequest;
use App\Models\Book;
use App\Models\Patient;
use App\Models\Specialty;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingConfirmation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
use Illuminate\Support\Facades\Log;
use Infobip\ApiException;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    // Hiển thị popup booking và chuyên khoa
    public function booking()
    {
        $showPopup = 'booking';
        $doctor = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('role', 2)
            ->select('users.*', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->limit(6)
            ->get();

        return view('client.index', [
            'showPopup' => $showPopup,
            'doctor' => $doctor
        ]);
    }



    public function handleBooking(BookingRequest $request)
    {
        $email = $request->email;

        // Lấy API key từ file .env qua config
        $apiKey = config('services.abstract.api_key');
        $url = "https://emailvalidation.abstractapi.com/v1/?api_key={$apiKey}&email={$email}";

        $response = Http::get($url);

        if ($response->ok()) {
            $emailData = $response->json();

            // Kiểm tra trạng thái `deliverability`
            if ($emailData['deliverability'] !== 'DELIVERABLE') {
                return redirect()->back()
                    ->withErrors(['email' => 'Email không hợp lệ hoặc không tồn tại.'])
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->withErrors(['email' => 'Không thể xác minh email. Vui lòng thử lại sau.'])
                ->withInput();
        }

        // Xác minh reCAPTCHA
        $recaptchaSecret = config('recaptcha.secret_key');
        $recaptchaResponse = $request->input('g-recaptcha-response');

        $recaptchaVerifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $recaptchaResult = $recaptchaVerifyResponse->json();

        if (!$recaptchaResult['success']) {
            return redirect()->back()
                ->withErrors(['g-recaptcha-response' => 'Vui lòng xác minh reCAPTCHA.'])
                ->withInput();
        }

        // Tiếp tục xử lý đặt lịch
        $book = new Book();
        $book->book_id = $this->generateUserId();
        $book->name = $request->name;
        $book->phone = $request->phone;
        $book->email = $email;
        $book->symptoms = $request->symptoms;
        $book->day = $request->day;
        $book->hour = $request->hour;
        $book->shift_id = $request->shift_id ?? null;
        $book->specialty_id = $request->specialty_id;
        $book->role = $request->role;

        $specialty = Specialty::where('specialty_id', $request->specialty_id)
            ->where('status', 1)
            ->get();

        if (!$specialty) {
            return redirect()->back()->with('error', 'Chuyên khoa không tồn tại hoặc đã bị khóa.');
        }

        $book->user_id = Auth::check() ? Auth::user()->user_id : null;
        $book->save();

        // Gửi email xác nhận
        Mail::to($book->email)->send(new BookingConfirmation($book, $specialty));

        return redirect()->back()->with('success', 'Đặt lịch thành công');
    }


    public function cancelBooking($book_id)
    {

        $book = Book::where('book_id', $book_id)->first();

        if (!$book) {
            return redirect()->back()->with('error', 'Lịch khám không tồn tại.');
        }

        if ($book->status == 4) {
            return redirect()->back()->with('error', 'Lịch khám đã bị hủy.');
        }

        $book->status = 4;
        $book->save();

        return redirect()->back()->with('success', 'Lịch khám đã được hủy.');
    }
    protected function generateUserId()
    {
        return strtoupper(Str::random(10));
    }
}
