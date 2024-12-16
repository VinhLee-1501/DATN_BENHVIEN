<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Schedule\CreateRequest;
use App\Models\Schedule;
use App\Models\Sclinic;
use App\Models\Shift;
use App\Models\Specialty;
use App\Models\TableShift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        return view('System.schedules.index', ['specialties' => $specialties]);
    }

    public function getDoctors(Request $request)
    {
        $users = User::where('role', 2)
            ->where('specialty_id', $request->input('specialty_id'))
            ->get();
        // dd($users);
        return response()->json(['users' => $users]);
    }

    public function getClinics(Request $request)
    {
        $clinics = Sclinic::where('specialty_id', $request->input('specialty_id'))
            ->where('status', 1)
            ->get();
        return response()->json(['clinics' => $clinics]);
    }

    public function getData(Request $request)
    {
        $query = Schedule::join('users', 'users.user_id', '=', 'schedules.user_id')
            ->join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->join('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->select(
                'users.lastname as lastname',
                'users.firstname as firstname',
                'users.avatar as avatar',
                'users.phone as phone',
                'users.specialty_id as specialtyId',
                'users.user_id as userId',
                'schedules.*',
                'specialties.name as specialty_name',
                'sclinics.sclinic_id as sclinic_id',
                'sclinics.name as sclinic_name',
                'sclinics.description as specialty_description',
                'sclinics.status as specialty_status'
            )->where('users.role', 2);

        if ($request->has('specialty_id')) {
            $specialty_id = $request->input('specialty_id');
            $query->where('users.specialty_id', $specialty_id);
        }

        $schedule = $query->get();
        //        dd($schedule);
        $events = [];

        foreach ($schedule as $shift) {
            $events[] = [
                'shift_id' => $shift->shift_id,
                'title' =>  $shift->lastname . ' ' . $shift->firstname,
                'start' => $shift->day,
                'id' => $shift->shift_id,
                'user_id' => $shift->userId,
                'sclinic_id' => $shift->sclinic_id,
                'note' => $shift->note,
                'phone' => $shift->phone,
                'specialty_name' => $shift->specialty_name,
                'status' => $shift->status,
                'doctorData' => [
                    [
                        'user_id' => $shift->userId,
                        'sclinic_id' => $shift->sclinic_id,
                    ]
                ]
            ];
        }

        return response()->json($events);
    }

    public function create(Request $reauest)
    {
        $user = User::where('role', 2)->get();
        $sclinic = Sclinic::where('status', 0)
            ->select('sclinic_id', 'name')->get();
        return view('System.schedules.create', [
            'user' => $user,
            'sclinic' => $sclinic
        ]);
    }

    public function updateSclinic($sclinic_id)
    {

        $sclinic = Sclinic::find($sclinic_id);
        if ($sclinic) {
            $sclinic->status = 1;
            $sclinic->update();
        }

        return $sclinic;
    }

    public function store(Request $request)
    {
        $userId = $request->input('user_id');
        $sclinicId = $request->input('sclinic');
        //         dd($userId, $sclinicId);
        $specialtyId = $request->input('specialty_id');
        $day = $request->input('day');
        $dayStatus =
            Carbon::parse($day)->toDateString();;
        $note = $request->input('note');
        $status = $request->input('status');

        // Kiểm tra ngày
        $now = Carbon::now();
        if ($day < $now) {
            return response()->json(['error' => true, 'message' => 'Bạn không thể thêm sự kiện vào ngày trước ngày hiện tại.']);
        }
        // Kiểm tra số lượng lịch đã có cho chuyên khoa này trong ngày
        $existingSchedules = Schedule::where('user_id', $userId)
            ->where('day', $day)
            ->count();

        $existingDoctorWithStatus = Schedule::join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('users.specialty_id', $specialtyId)
            ->where('schedules.day', $dayStatus)
            ->where('schedules.status', 1)
            ->whereNull('schedules.deleted_at')
            ->exists();

        // Kiểm tra kết quả
        // dd($existingDoctorWithStatus);

        if ($existingDoctorWithStatus) {
            if ($status == 1) {
                return response()->json(['error' => true, 'message' => 'Đã tồn tại bác sĩ trong chuyên khoa này có lịch khám trực tuyến.']);
            }
        }

        // Kiểm tra xem số lượng tối đa có vượt quá 3 hay không
        if ($existingSchedules >= 3) {
            return response()->json(['error' => true, 'message' => 'Chuyên khoa này đã có tối đa 3 lịch vào ngày này.']);
        }

        // Kiểm tra xem bác sĩ đã có lịch làm việc trong ngày này chưa
        $existingSchedule = Schedule::where('user_id', $userId)
            ->where('day', $day)
            ->first();

        if ($existingSchedule) {
            return response()->json(['error' => true, 'message' => 'Bác sĩ đã có lịch làm việc vào ngày này.']);
        }

        // Kiểm tra xem bác sĩ đã được lên lịch cho phòng khác chưa
        $existingScheduleForAnotherClinic = Schedule::where('user_id', $userId)
            ->where('day', $day)
            ->where('sclinic_id', '!=', $sclinicId)
            ->first();

        if ($existingScheduleForAnotherClinic) {
            return response()->json(['error' => true, 'message' => 'Bác sĩ này đã được lên lịch cho phòng khác vào ngày này.']);
        }

        $existingRoomSchedule = Schedule::where('sclinic_id', $sclinicId)
            ->where('day', $day)
            ->exists();

        if ($existingRoomSchedule) {
            return response()->json(['error' => true, 'message' => 'Phòng này đã có bác sĩ khác được lên lịch vào ngày này.']);
        }

        // Nếu không có lịch, thêm lịch mới
        $schedule = new Schedule();
        $schedule->shift_id = strtoupper(Str::random(10));
        $schedule->user_id = $userId;
        $schedule->sclinic_id = $sclinicId;
        $schedule->day = $day;
        $schedule->note = $note;
        $schedule->status = $status;
        // $this->updateSclinic($schedule->sclinic_id);
        $schedule->save();

        $statusSchedule = Schedule::orderBy('row_id', 'DESC')->first();
        if ($statusSchedule && $statusSchedule->status == 1) {
            $shiftNotes = [
                '7h-8h',
                '8h15-9h15',
                '9h30-10h30',
                '10h45-11h45',
                '13h-14h',
                '14h15-15h15',
                '15h30-16h30',
            ];

            for ($i = 1; $i <= 7; $i++) {
                $shifts = new TableShift();
                $shifts->name = 'Ca' . $i;
                $shifts->status = 0;
                $shifts->shift_id = $statusSchedule->shift_id;
                $shifts->note = $shiftNotes[$i - 1];
                $shifts->save();
            }
        }
        // dd($schedule);

        return response()->json(['success' => true, 'message' => 'Thêm lịch khám thành công.']);
    }


    public function edit($shift_id)
    {
        $schedule = Schedule::join('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->select(
                'users.user_id as user_id',
                'users.lastname as lastname',
                'users.firstname as firstname',
                'sclinics.sclinic_id as sclinic_id',
                'sclinics.name as sclinic_name',
                'schedules.shift_id as shift_id',
                'schedules.day as day',
                'schedules.note as note',
            )
            ->where('shift_id', $shift_id)->first();
        $sclinic_id = $schedule->sclinic_id;

        $user = User::where('role', 2)
            ->where('user_id', $schedule->user_id)->first();
        // dd($user);

        $specialty_id = $user->specialty_id;

        $sclinic = Sclinic::where('status', 1)
            ->where('specialty_id', $specialty_id)
            ->select('sclinic_id', 'name')->get();
        // $this->Sclinic($schedule->sclinic_id);
        return response()->json(['schedules' => $schedule, 'sclinic' => $sclinic, 'user' => $user]);
    }

    public function update(Request $request, $shift_id)
    {
        $schedule = Schedule::findOrFail($shift_id);
        $userId = $schedule->user_id;
        $newSclinicId = $request->input('sclinic_id'); // Phòng khám mới
        $day = $request->input('day');
        $status = $request->input('status');
        $specialtyId = $request->input('specialty_id');

        // Kiểm tra xem bác sĩ đã được lên lịch cho phòng khác chưa
        $existingScheduleForAnotherClinic = Schedule::where('user_id', $userId)
            ->where('day', $day)
            ->where('sclinic_id', '!=', $newSclinicId)
            ->where('shift_id', '!=', $shift_id)
            ->first();
        if ($existingScheduleForAnotherClinic) {
            return response()->json(['error' => false, 'message' => 'Bác sĩ này đã được lên lịch cho phòng khác vào ngày này.']);
        }

        // Kiểm tra có bác sĩ nào lên lịch
        $existingRoomSchedule = Schedule::where('sclinic_id', $newSclinicId)
            ->where('day', $day)
            ->where('shift_id', '!=', $shift_id)
            ->exists();

        if ($existingRoomSchedule) {
            return response()->json(['error' => true, 'message' => 'Phòng này đã có bác sĩ khác được lên lịch vào ngày này.']);
        }

        $existingDoctorWithStatus = Schedule::join('users', 'users.user_id', '=', 'schedules.user_id')
            ->where('users.specialty_id', $specialtyId)
            ->where('schedules.day', $day)
            ->where('schedules.status', 1)
            ->exists();

        // Kiểm tra kết quả
        // dd($existingDoctorWithStatus);

        if ($existingDoctorWithStatus) {
            if ($status == 1) {
                return response()->json(['error' => true, 'message' => 'Đã tồn tại bác sĩ trong chuyên khoa này có lịch khám trực tuyến.']);
            }
        }

        $schedule->day = $day;
        $schedule->sclinic_id = $newSclinicId;
        $schedule->status = $request->input('check') ? 1 : 0;
        $schedule->note = $request->input('note');

        // Lưu lại
        $schedule->update();

        return response()->json(['success' => true, 'message' => 'Cập nhật lịch khám thành công.']);
    }
    public function Sclinic($sclinic_id)
    {
        $sclinic = Sclinic::find($sclinic_id);
        if ($sclinic) {
            $sclinic->status = 0;
            $sclinic->update();
        }
    }

    public function delete($shift_id)
    {
        $schedule = Schedule::findOrFail($shift_id);
        $id = $schedule->shift_id;

        $tableShifts = TableShift::where('shift_id', $id)->get();

        $schedule->delete();
        foreach ($tableShifts as $tableShift) {
            $tableShift->delete();
        }
        return response()->json(['success' => true, 'message' => 'Xóa lịch khám thành công.']);
    }
}
