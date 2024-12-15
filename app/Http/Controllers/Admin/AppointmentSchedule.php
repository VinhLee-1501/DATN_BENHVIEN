<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\BookingUpdated;
use App\Http\Controllers\Controller;
use App\Jobs\SendBookingConfirmation;
use App\Mail\BookingConfirmationLink;
use App\Models\Book;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Sclinic;
use App\Models\TableShift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ->leftJoin('table_shifts', 'table_shifts.row_id', '=', 'books.table_shift_id')
            ->select(
                'books.*',
                DB::raw('MAX(users.lastname) as lastname'),
                DB::raw('MAX(users.firstname) as firstname'),
                DB::raw('MAX(sclinics.name) as sclinicName'),
                DB::raw('MAX(specialties.name) as specialtyName'),
                DB::raw('MAX(table_shifts.name) as shiftName'),
                DB::raw('MAX(table_shifts.note) as shiftNote')
            )
            ->groupBy(
                'books.row_id',
                'books.book_id',
                'books.name',
                'books.day',
                'books.phone',
                'books.hour',
                'books.email',
                'books.url',
                'books.role',
                'books.status',
                'books.specialty_id',
                'books.user_id',
                'books.shift_id',
                'books.table_shift_id',
                'books.symptoms',
                'books.deleted_at',
                'books.created_at',
                'books.updated_at',
            )
            ->orderByRaw('CASE WHEN books.status = 0 THEN 0 ELSE 1 END')
            ->orderBy('books.row_id', 'DESC');

        $activeTab = $request->query('tab', default: 'nav-home'); // Tab mặc định là 'nav-home'

        // Tìm kiếm theo tên, số điện thoại, trạng thái, ngày từ/đến
        if ($request->filled('name')) {
            $query->where('books.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('books.phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('status')) {
            $query->where('books.status', $request->status);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('books.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('books.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('books.created_at', '<=', $request->date_to);
        }

        $booksOnline = clone $query;
        $booksOffline = clone $query;

        $booksOnline = $booksOnline->where('books.role', 1)->paginate(10)->appends($request->all());
        $booksOffline = $booksOffline->where('books.role', 0)->paginate(10)->appends($request->all());

        // Trả về kết quả cho AJAX
        if ($request->ajax()) {
            return response()->json([
                'navHome' => view('System.appointmentschedule.offline', ['book' => $booksOffline])->render(),
                'navContact' => view('System.appointmentschedule.online', ['book' => $booksOnline])->render(),
            ]);
        }

        return view('System.appointmentschedule.index', ['booksOnline' => $booksOnline, 'booksOffline' => $booksOffline, 'activeTab' => $activeTab]);
    }


    public function edit(Request $request, $id)
    {
        $book = Book::where('book_id', $id)->first();
        $specialty_id = $book->specialty_id;
        $selectedDay = $request->input('appointment_time');
        $date = Carbon::parse($selectedDay, 'Asia/Ho_Chi_Minh')->setTimezone('UTC')->format('Y-m-d');

        // dd($date);

        $schedulesQuery = Schedule::leftJoin('table_shifts', 'table_shifts.shift_id', '=', 'schedules.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->whereDate('schedules.day', $book->day)
            ->where('users.specialty_id', $specialty_id)
            ->select('schedules.*')
            ->groupBy(
                'schedules.shift_id',
                'schedules.user_id',
                'schedules.note',
                'schedules.status',
                'schedules.day',
                'schedules.row_id',
                'schedules.sclinic_id',
                'schedules.created_at',
                'schedules.updated_at',
                'schedules.deleted_at'
            );

        if ($book->role == 1) {
            $schedulesQuery->where('table_shifts.status', 0);
        }

        $schedules = $schedulesQuery->get();
        // dd($schedulesQuery);
        // dd($schedules);

        return response()->json([
            'appointment_time' => $book->day,
            'hour' => $book->hour,
            'schedules' => $schedules,
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
        $role = $request->input('role');

        $doctorsQuery = User::join('schedules', 'schedules.user_id', '=', 'users.user_id')
            ->where('users.role', 2)
            ->where('users.specialty_id', $specialtyId)
            ->whereDate('schedules.day', $date)
            ->whereNull('schedules.deleted_at')
            ->select(
                'users.user_id',
                'users.firstname',
                'users.lastname',
                'schedules.shift_id'
            );

        if ($role == 1) {
            $doctorsQuery->where('schedules.status', 1);
            // ->where('table_shifts.status', 0);
        } else {
            $doctorsQuery->where('schedules.status', 0);
        }

        $doctors = $doctorsQuery
            ->groupBy(
                'users.user_id',
                'users.firstname',
                'users.lastname',
                'schedules.shift_id'
            )->get();
        $shift_id = $doctors[0]->shift_id;


        $shifts = TableShift::join('schedules', 'schedules.shift_id', '=', 'table_shifts.shift_id')
            ->where('table_shifts.shift_id', $shift_id)
            ->where('table_shifts.status', 0)
            ->select('table_shifts.*')
            ->get();

        // dd($shift);
        return response()->json(['doctors' => $doctors, 'shifts' => $shifts]);
    }

    public function update($id, Request $request)
    {

        $book = Book::where('book_id', $id)->first();
        $rowId = $request->input('row_id');
        // dd($rowId);
        // $user = Auth::user();

        if (!$book) {
            return response()->json(['error' => true, 'message' => 'Không tìm thấy bản ghi']);
        }

        $shiftId = $request->input('doctor_name');
        if (!$shiftId) {
            return response()->json(['error' => true, 'message' => 'Không tìm bác sĩ khám bệnh']);
        }
        $status = $request->input('status');
        $hour = $request->input('hour');

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $hourNow = Carbon::parse($hour)->format('H:i:s');
        $hourDeadline = Carbon::createFromTime(16, 0, 0)->toTimeString();

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
            ->first();

        if (!$schedule) {
            return response()->json(['error' => true, 'message' => 'Bác sĩ này không có lịch khám vào ngày này']);
        }

        $scheduleDate = Schedule::whereDate('day', $date)
            ->where('user_id', $doctorUserId)
            ->first();

        $shiftStatus = TableShift::where('row_id', $rowId)->first();

        if ($book->role == 1) {
            if ($shiftStatus->status == 1) {
                return response()->json(['error' => true, 'message' => 'Ca làm đã được đặt.']);
            } else {
                if ($book->table_shift_id) {
                    $tableShitId =
                        TableShift::where('row_id', $book->table_shift_id)->first();

                    $tableShitId->status = 0;
                    $tableShitId->save();
                }
                $shiftStatus->status = 1;
                $shiftStatus->save();
            }
        }

        $bookCount = Book::join('schedules', 'schedules.shift_id', 'books.shift_id')
            ->where('books.shift_id', $scheduleDate->shift_id)
            ->whereDate('schedules.day', $date)
            ->count();

        if ($bookCount > 30) {
            return response()->json(['error' => true, 'message' => 'Bác sĩ đã đầy lịch']);
        }

        $book->shift_id = $scheduleDate->shift_id;
        $book->day = $date;

        $book->status = $status;
        $book->hour = $hour;
        $book->url = $request->input('url');
        $book->table_shift_id = $rowId;
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
        // event(new BookingUpdated($book, $clicnic));
        SendBookingConfirmation::dispatch($book, $clicnic);
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