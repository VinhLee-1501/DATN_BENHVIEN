<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppointmentSchedule extends Controller
{
    public function index()
    {
        $book = Book::join('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->select('books.*',  'specialties.name as specialtyName')
            ->paginate(5);
        //       dd($book);

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
            'doctor_name' => $doctor,
            'specialty_id' => $specialty_id,
            'status' => $book->status
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
            return response()->json(['error' => 'Không tìm thấy bản ghi'], 400);
        }

        $status = $request->input('status');


        if ($status == 2) {
            $book->status = $status;
            $book->save();
            return response()->json(['success' => true, 'message' => 'Trạng thái đã được cập nhật thành công.']);
        }

        $date = Carbon::parse($request->input('appointment_time'));
        $currentDate = Carbon::now()->toDateString();

        if ($date < $currentDate) {
            return response()->json(['error' => 'Ngày đặt lịch không hợp lệ'], 400);
        }

        $doctorUserId = $request->input('doctor_name');

        $schedule = Schedule::where('user_id', $doctorUserId)
            ->whereDate('day', $date)
            ->first();
        //        Log::info("schedule:", $schedule);

        if (!$schedule) {
            return response()->json(['error' => 'Bác sĩ này không có lịch khám vào ngày này'], 400);
        }
        $scheduleDate = Schedule::whereDate('day', $date)
            ->where('user_id', $doctorUserId)
            ->first();

        $bookCount = Book::join('schedules', 'schedules.shift_id', 'books.shift_id')
            ->where('books.shift_id', $scheduleDate->shift_id)
            ->whereDate('schedules.day', $date)
            ->count();

        if ($bookCount > 5) {
            return response()->json(['error' => 'Khống có'], 400);
        }


        $book->shift_id = $scheduleDate->shift_id;
        $book->day = $date;

        $book->status = $status;
        // Lưu bản ghi
        $book->save();

        return response()->json(['success' => true, 'message' => 'Dữ liệu đã được cập nhật thành công.']);
    }


    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('system.appointmentSchedule')->with('success', 'Xóa thành công');
    }
}
