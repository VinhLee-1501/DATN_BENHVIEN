<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Booking\BookingRequest; // Import BookingRequest
use App\Models\Book;
use App\Models\Patient;     // Model cho bảng 'books'
use App\Models\Specialty;  // Model cho bảng 'specialties'
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;

class BookController extends Controller
{
    // Hiển thị popup booking và chuyên khoa
    public function booking()
    {
        $showPopup = 'booking';

        return view('client.index', [
            'showPopup' => $showPopup,
        ]);
    }

    // Xử lý yêu cầu booking
    public function handleBooking(BookingRequest $request)  // Sử dụng BookingRequest
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


        $specialty = Specialty::where('specialty_id', $request->specialty_id)
            ->where('status', 1)
            ->get();


        if (!$specialty) {
            return redirect()->back()->with('error', 'Chuyên khoa không tồn tại hoặc đã bị khóa.');
        }


        $book->user_id = Auth::check() ? Auth::user()->user_id : null; // Gán null nếu chưa đăng nhập


        $book->save();


        Mail::to($book->email)->send(new BookingConfirmation($book, $specialty));


        return redirect()->back()->with('success', 'Đặt lịch thành công');
    }


    protected function generateUserId()
    {
        return strtoupper(Str::random(10));
    }
}
