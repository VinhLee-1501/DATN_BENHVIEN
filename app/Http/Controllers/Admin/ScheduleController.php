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
        $schedule = Schedule::join('users', 'users.user_id', '=', 'schedules.user_id')
            ->join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->join('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->select(
                'users.lastname as lastname',
                'users.firstname as firstname',
                'users.avatar as avatar',
                'users.phone as phone',
                'schedules.*',
                'specialties.name as specialty_name',
                'sclinics.sclinic_id as sclinic_id',
                'sclinics.name as sclinic_name',
                'sclinics.description as specialty_description',
                'sclinics.status as specialty_status',
            )
            ->get();
        // dd($schedule);

        return view('Admin.schedules.index', compact('schedule'));
    }
    public function create(Request $reauest)
    {
        $user = User::where('role', 2)->get();
        $sclinic = Sclinic::where('status', 0)
        ->select('sclinic_id', 'name')->get();
        return view('admin.schedules.create', [
            'user' => $user,
            'sclinic' => $sclinic
        ]);
    }


    public function store(CreateRequest $request)
    {
        $userId = $request->input('user_id');
        $sclinicId = $request->input('sclinic_id');
        $day = $request->input('day');
        $note = $request->input('note');
        $existingSchedule = Schedule::where('user_id', $userId)
            ->where('day', $day)
            ->first();
        if ($existingSchedule) {
            return redirect()->back()->with('error' , 'Bác sĩ đã có lịch làm việc vào ngày này.');
        }

        // Nếu không có lịch, thêm lịch mới
        $schedule = new Schedule();
        $schedule->	shift_id = strtoupper(Str::random(10));
        $schedule->user_id = $userId;
        $schedule->sclinic_id = $sclinicId;
        $schedule->day = $day;
        $schedule->note = $note;
        $schedule->status = 1;
        $schedule->save();


        $this->updateSclinic($schedule->sclinic_id);

        return redirect()->route('admin.schedule')->with('success', 'Thêm mới thành công.');
    }


    public function updateSclinic($sclinic_id)
    {

        $sclinic = Sclinic::find($sclinic_id);
        if ($sclinic) {
            $sclinic->status = 1;
            $sclinic->update();
        }

    }

    public function edit($shift_id)
    {

        $schedule = Schedule::join('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
        ->join('users', 'users.user_id','=', 'schedules.user_id')
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
        ->where('shift_id',$shift_id)->first();
        $sclinic_id = $schedule->sclinic_id;

        $user = User::where('role', 2)->get();
        $sclinic = Sclinic::where('status', 0)
        ->select('sclinic_id', 'name')->get();
        $this->Sclinic($schedule->sclinic_id);
        return view('admin.schedules.edit', compact('schedule','user','sclinic'));
    }
    public function update(CreateRequest $request, $shift_id)
    {
        $schedule = Schedule::findOrFail( $shift_id);
        $schedule->day = $request->input('day');
        $schedule->user_id = $request->input('user_id');
        $schedule->sclinic_id = $request->input('sclinic_id');
        $schedule->note = $request->input('note');
        $sclinic_id = $request->input('sclinic_id');

        $this->updateSclinic($schedule->sclinic_id);

        $schedule->update();
        return redirect()->route('admin.schedule')->with('success', 'Cập nhật thành công.');
    }

    public function delete($shift_id)
    {

        $schedule =Schedule::findOrFail($shift_id);
        $id = $schedule->shift_id;

        $this->Sclinic($schedule->sclinic_id);

        $schedule->delete();
        return redirect()->route('admin.schedule')->with('success', 'Xóa thành công.');
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
