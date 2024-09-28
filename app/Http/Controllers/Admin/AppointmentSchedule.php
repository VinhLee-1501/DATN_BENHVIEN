<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\UpdateRequest;
use App\Models\Book;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use  Illuminate\Http\Request;

class AppointmentSchedule extends Controller
{
    public function index()
    {
        $book = Book::get();
        return view('admin.appointmentschedule.index', ['book' => $book]);
    }

    public function edit($id)
    {
        $book = Book::join('schedules', 'schedules.shift_id', 'books.shift_id')->join('users', 'users.user_id', 'schedules.user_id')->where('books.book_id', $id)->select('books.*', 'users.firstname', 'users.lastname')->groupBy('books.book_id')->first();

        return view('admin.appointmentschedule.edit', ['book' => $book]);
    }

    public function update($id, Request $request)
    {
//        dd($id);

        $book = Book::where('book_id', $id)->first();
//        $book->name = input('name');
//        $book->phone = input('phone');
//        $book->email = input('email');
//        $book->symptoms = input('symptoms');
        $book->day = $request->input('day');
        $optionUser = $request->input('user_id');

        $date = Carbon::parse($request->input('day'));

        if ($date < now()) {
            return redirect()->route('admin.editAppointmentSchedule', $id)->with('error', 'Ngày đặt lịch không hợp lệ');
        }

        $scheduleDate = Schedule::whereDate('day', $date)->first();
        $user = User::join('schedules', 'users.user_id', 'schedules.user_id')->where('users.user_id', $optionUser)->whereDate('schedules.day', $date)->first();

        if (!$user) {
            return redirect()->route('admin.editAppointmentSchedule', $id)->with('error', 'Không có bác sĩ khám vào ngày này');
        }

        $book->shift_id = $scheduleDate->shift_id;

        $bookCount = Book::join('schedules', 'schedules.shift_id', 'books.shift_id')
            ->where('books.shift_id', $scheduleDate->shift_id)
            ->whereDate('schedules.day', $date)->count();

        if ($bookCount > 5) {
            return redirect()->route('admin.editAppointmentSchedule', $id)->with('error', 'Khống có');
        }

        $book->save();
//        dd($book);
        return redirect()->route('admin.appointmentSchedule')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('admin.appointmentSchedule')->with('success', 'Xóa thành công');
    }
}
