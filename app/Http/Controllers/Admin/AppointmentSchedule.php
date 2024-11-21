<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\BookingUpdated;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationLink;
use App\Models\Book;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class AppointmentSchedule extends Controller
{
    public function index()
    {
        $book =
            $books = Book::leftJoin('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->leftJoin('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->leftJoin('users', 'users.user_id', '=', 'schedules.user_id')
            ->leftJoin('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->select('books.*', 'users.lastname', 'users.firstname', 'sclinics.name AS sclinicName', 'specialties.name AS specialtyName')
            ->orderBy('books.row_id', 'DESC')
            ->paginate(10);


        return view('System.appointmentschedule.index', ['book' => $book,]);
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

        
        if (!$book) {
            return response()->json(['error' => true, 'message' => 'Không tìm thấy bản ghi']);
        }
        
        $shiftId = $request->input('doctor_name');
        if(!$shiftId){
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
            return response()->json(['error' =>  true, 'message' => 'Giờ không hợp lệ']);
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
        // dd($book);
        event(new BookingUpdated($book));


        return response()->json(['success' => true, 'message' => 'Dữ liệu đã được cập nhật thành công.']);
    }


    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('system.appointmentSchedule')->with('success', 'Xóa thành công');
    }
}