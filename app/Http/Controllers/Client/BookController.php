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

    // Xử lý yêu cầu booking


    public function handleBooking(BookingRequest $request)
    {
        $book = new Book();
        $book->book_id = $this->generateUserId();
        $book->name = $request->name;
        $book->phone = $request->phone;
        $book->email = $request->email;
        $book->symptoms = $request->symptoms;
        $book->day = $request->day;
        $book->hour = $request->hour;
        $book->shift_id = $request->shift_id ?? null;
        $book->specialty_id = $request->specialty_id;
        $book->role = $request->role;
        // Validate reCAPTCHA

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $responseBody = $response->json();

        if (!$responseBody['success']) {
            return redirect()->route('client.booking')
                ->withErrors(['g-recaptcha-response' => 'Vui lòng xác minh reCAPTCHA.'])
                ->withInput();
        }
        $validatedData = $request->validated();


        
        $specialty = Specialty::where('specialty_id', $request->specialty_id)
            ->where('status', 1)
            ->get(); 

        if (!$specialty) {
            return redirect()->back()->with('error', 'Chuyên khoa không tồn tại hoặc đã bị khóa.');
        }

        $book->user_id = Auth::check() ? Auth::user()->user_id : null;
        $book->save();

       
        Mail::to($book->email)->send(new BookingConfirmation($book, $specialty));

        $this->sendSmsConfirmation($book);

        return redirect()->back()->with('success', 'Đặt lịch thành công');
    }

    private function sendSmsConfirmation($booking): void
    {
       
        $config = new Configuration(getenv('INFOBIP_API_BASE_URL'), getenv('INFOBIP_API_KEY'));
        $smsApi = new SmsApi(config: $config); 

       
        $message = new SmsTextualMessage(
            from: 'Code', 
            destinations: [
                new SmsDestination(to: '84' . ltrim($booking->phone, '0'))  // Đảm bảo đúng định dạng
            ],
            text: "Xác nhận đặt lịch khám thành công. Thông tin: {$booking->day} vào lúc {$booking->hour}\nBạn có thể xem chi tiết tại: https://khuonghapc06329.id.vn/."
        );

        $request = new SmsAdvancedTextualRequest(messages: [$message]);

        try {
           
            $smsApi->sendSmsMessage($request);
        } catch (ApiException $apiException) {
            
            Log::error("Không thể gửi SMS: " . $apiException->getMessage());
        } catch (Exception $e) {
           
            Log::error("Lỗi không xác định khi gửi SMS: " . $e->getMessage());
        }
    }

    protected function generateUserId()
    {
        return strtoupper(Str::random(10));
    }
}