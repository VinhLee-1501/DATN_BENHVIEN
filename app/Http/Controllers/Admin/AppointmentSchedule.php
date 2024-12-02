<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\BookingUpdated;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationLink;
use App\Models\Book;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Sclinic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AppointmentSchedule extends Controller
{
    public function index(Request $request)
    {
        $query = Book::leftJoin('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->leftJoin('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->leftJoin('users', 'users.user_id', '=', 'schedules.user_id')
            ->leftJoin('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->select('books.*', 'users.lastname', 'users.firstname', 'sclinics.name AS sclinicName', 'specialties.name AS specialtyName')
            ->orderByRaw('CASE WHEN books.status = 0 THEN 0 ELSE 1 END')
            ->orderBy('books.row_id', 'DESC');

        // Tìm kiếm theo tên
        if ($request->filled('name')) {
            $query->where('books.name', 'like', '%' . $request->name . '%');
        }

        // Tìm kiếm theo số điện thoại
        if ($request->filled('phone')) {
            $query->where('books.phone', 'like', '%' . $request->phone . '%');
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('status')) {
            $query->where('books.status', $request->status);
        }
        // Tìm kiếm theo ngày
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('books.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('books.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('books.created_at', '<=', $request->date_to);
        }

        $books = $query->paginate(10)->appends($request->all());

        return view('System.appointmentschedule.index', ['book' => $books]);
    }



    public function edit($id)
    {
        $book = Book::where('book_id', $id)->first();
        $specialty_id = $book->specialty_id;
        $selectedDay = \request()->input('selectedDay');

        $doctor = User::where('role', 2)
            ->where('users.specialty_id', $specialty_id)
            ->join('schedules', 'schedules.user_id', '=', 'users.user_id')
            ->whereDate('schedules.day', $selectedDay)
            ->select('users.*', 'schedules.*')
            ->get();

        return response()->json([
            'appointment_time' => $book->day,
            'hour' => $book->hour,
            'doctor_name' => $doctor,
            'specialty_id' => $specialty_id,
            'status' => $book->status,
            'role' => $book->role,
            'email' => $book->email,
            'url' => $book->url
        ]);
    }

    public function getDoctorsByDate(Request $request)
    {
        $date = $request->input('date');
        $specialtyId = $request->input('specialty_id');

        $doctors = User::join('schedules', 'schedules.user_id', '=', 'users.user_id')
            ->where('users.role', 2)
            ->where('users.specialty_id', $specialtyId)
            ->whereDate('schedules.day', $date)
            ->select('users.user_id', 'users.firstname', 'users.lastname')
            ->get();

        return response()->json(['doctors' => $doctors]);
    }


    public function update($id, Request $request)
    {
        $book = Book::where('book_id', $id)->first();
        $user = Auth::user();


        if (!$book) {
            return response()->json(['error' => true, 'message' => 'Không tìm thấy bản ghi']);
        }

        $shiftId = $request->input('doctor_name');
        if (!$shiftId) {
            return response()->json(['error' => true, 'message' => 'Không tìm bác sĩ khám bệnh']);
        }
        $status = $request->input('status');
        $hour = $request->input('hour');
        // dd($hour, $status);

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $hourNow = Carbon::parse($hour)->format('H:i:s');
        $hourDeadline = Carbon::createFromTime(16, 0, 0)->toTimeString();

        // dd($hourNow);
        // dd($hourDeadline);

        if ($hourNow > $hourDeadline) {
            return response()->json(['error' => true, 'message' => 'Giờ không hợp lệ']);
        }

        if ($status == 2) {
            $book->status = $status;
            $book->save();
            return response()->json(['success' => true, 'message' => 'Trạng thái đã được cập nhật thành công.']);
        }

        $appointmentTime = $request->input('appointment_time');

        $date = Carbon::parse($appointmentTime)->toDateString();
        // dd($date);
        $currentDate = Carbon::now()->toDateString();

        if ($date < $currentDate) {
            return response()->json(['error' => true, 'message' => 'Ngày đặt lịch không hợp lệ']);
        }

        $doctorUserId = $request->input('doctor_name');

        $schedule = Schedule::where('user_id', $doctorUserId)
            ->whereDate('day', $date)
            ->get();
        // dd('đây là ' . $schedule);

        // $bookDay = Book::where('day', $date)->get();

        if (!$schedule) {
            return response()->json(['error' => true, 'message' => 'Bác sĩ này không có lịch khám vào ngày này']);
        }

        $scheduleDate = Schedule::whereDate('day', $date)
            ->where('user_id', $doctorUserId)
            ->first();
        // dd($scheduleDate);
        $bookCount = Book::join('schedules', 'schedules.shift_id', 'books.shift_id')
            ->where('books.shift_id', $scheduleDate->shift_id)
            ->whereDate('schedules.day', $date)
            ->count();

        if ($bookCount > 30) {
            return response()->json(['error' => true, 'message' => 'Bác sĩ đã đầy lịch']);
        }


        // dd($book);
        $book->shift_id = $scheduleDate->shift_id;
        $book->day = $date;

        $book->status = $status;
        $book->hour = $hour;
        $book->url = $request->input('url');
        // Lưu bản ghi
        $book->save();
        

        Order::create([
            'book_id' => $book->book_id,
            'order_id' => strtoupper(Str::random(10)),
            'payment' => 1,
            'status' => 1,
            'total_price' => 200000
        ]);
        $clicnic = Sclinic::join('schedules', 'schedules.sclinic_id', '=', 'sclinics.sclinic_id')
        ->join('books', 'books.shift_id', '=', 'schedules.shift_id')
        ->where('books.book_id', $book->book_id)
        ->select('sclinics.*')
        ->first();
        // dd($clicnic);
        event(new BookingUpdated($book, $clicnic));
        // Mail::to($book->email)->send(new BookingConfirmationLink($book, $clicnic));


        return response()->json(['success' => true, 'message' => 'Dữ liệu đã được cập nhật thành công.']);
    }


    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('system.appointmentSchedule')->with('success', 'Xóa thành công');
    }
}