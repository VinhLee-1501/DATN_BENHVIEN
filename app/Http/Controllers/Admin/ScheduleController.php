<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Schedule\CreateRequest;
use App\Models\Schedule;
use App\Models\Sclinic;
use App\Models\Specialty;
use App\Models\User;
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

    public function getClinics()
    {
        $clinics = Sclinic::all();
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
                'title' => $shift->firstname . ' ' . $shift->lastname,
                'start' => $shift->day,
                'id' => $shift->shift_id,
                'user_id' => $shift->userId,
                'sclinic_id' => $shift->sclinic_id,
                'note' => $shift->note,
                'phone' => $shift->phone,
                'specialty_name' => $shift->specialty_name
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
        $day = $request->input('day');
        $note = $request->input('note');
        $existingSchedule = Schedule::where('user_id', $userId)
            ->where('day', $day)
            ->first();
        if ($existingSchedule) {
            return response()->json(['error', 'Bác sĩ đã có lịch làm việc vào ngày này.']);
        }

        // Nếu không có lịch, thêm lịch mới
        $schedule = new Schedule();
        $schedule->shift_id = strtoupper(Str::random(10));
        $schedule->user_id = $userId;
        $schedule->sclinic_id = $sclinicId;
        $schedule->day = $day;
        $schedule->note = $note;
        $schedule->status = 1;
        $this->updateSclinic($schedule->sclinic_id);
        $schedule->save();

        // dd($schedule);

        return response()->json(['success' => true, 'message' => 'Thêm mới thành công.']);
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

        $sclinic = Sclinic::where('status', 0)
            ->select('sclinic_id', 'name')->get();
        $this->Sclinic($schedule->sclinic_id);
        return response()->json(['schedules' => $schedule, 'sclinic' => $sclinic, 'user' => $user]);
    }

    public function update(CreateRequest $request, $shift_id)
    {
        $schedule = Schedule::findOrFail($shift_id);

        // Cập nhật ngày, phòng khám, ghi chú
        $schedule->day = $request->input('day');
        $schedule->sclinic_id = $request->input('sclinic_id'); // Cập nhật phòng khám nếu có thay đổi
        $schedule->note = $request->input('note');

        // Lưu lại
        $schedule->update();

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công.']);
    }

    public function delete($shift_id)
    {

        $schedule = Schedule::findOrFail($shift_id);
        $id = $schedule->shift_id;

        $this->Sclinic($schedule->sclinic_id);

        $schedule->delete();
        return response()->json(['success' => true, 'message' => 'Xóa thành công.']);
    }
    public function Sclinic($sclinic_id)
    {

        $sclinic = Sclinic::find($sclinic_id);
        if ($sclinic) {
            $sclinic->status = 0;
            $sclinic->update();
        }
    }
}
