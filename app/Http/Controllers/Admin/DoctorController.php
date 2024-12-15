<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialty;
use App\Models\ProfileDoctor;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Doctor\DoctorRequest;
use App\Http\Requests\Admin\Doctor\DoctorCreateRequest;
use App\Mail\DoctorCreated;
use App\Events\Admin\DoctorCreated as EventDoctor;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class DoctorController extends Controller
{
    public function index(Request $request)
    {

        $specialties = Specialty::all();

        $query = User::where('role', 2)
            ->where('users.status', 1)
            ->join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->leftJoin('profile_doctors', 'profile_doctors.user_id', '=', 'users.user_id')
            ->select(
                'users.*',
                'specialties.name as specialty_name',
                'profile_doctors.degree as profile_degree',
                'profile_doctors.description as profile_description',
                'profile_doctors.work_experience as profile_work_experience'
            )
            ->orderby('row_id', 'desc');

        // Tìm kiếm động
        if ($request->filled('firstname')) {
            $query->where('users.firstname', 'like', '%' . $request->firstname . '%');
        }
        if ($request->filled('lastname')) {
            $query->where('users.lastname', 'like', '%' . $request->lastname . '%');
        }
        if ($request->filled('phone')) {
            $query->where('users.phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('insurance')) {
            $query->where('users.insurance', 'like', '%' . $request->insurance . '%');
        }
        if ($request->filled('specialty_id')) {
            $query->where('users.specialty_id', $request->specialty_id);
        }

        $doctors = $query->paginate(10)->appends($request->all());

        return view('System.doctors.index', compact('doctors', 'specialties'));
    }



    public function edit($id)
    {
        $doctor = User::with('profileDoctor')->where('user_id', $id)->firstOrFail();
        return response()->json($doctor);
    }

    public function update(DoctorRequest $request, $id)
    {
        $doctor = User::where('user_id', $id)->firstOrFail();

        $doctor->update([
            'firstname' => $request->input('firstname', $doctor->firstname),
            'lastname' => $request->input('lastname', $doctor->lastname),
            'phone' => $request->input('phone', $doctor->phone),
            'email' => $request->input('email', $doctor->email),
        ]);

        if ($doctor->profileDoctor) {
            $doctor->profileDoctor->update([
                'degree' => $request->input('degree', $doctor->profileDoctor->degree),
                'work_experience' => $request->input('work_experience', $doctor->profileDoctor->work_experience),
                'description' => $request->input('description', $doctor->profileDoctor->description),
            ]);
        } else {
            $doctor->profileDoctor()->create([
                'degree' => $request->input('degree'),
                'work_experience' => $request->input('work_experience'),
                'description' => $request->input('description'),
            ]);
        }

        return redirect()->route('system.doctor')->with('success', 'Cập nhật bác sĩ thành công');
    }

    public function create()
    {
        $specialties = Specialty::all();
        return view('System.doctors.create', compact('specialties'));
    }

    public function store(DoctorCreateRequest $request)
    {
        // Tạo user_id ngẫu nhiên
        $userId = strtoupper(Str::random(10));

        // Tạo mật khẩu mặc định: firstname + user_id
        $password = bcrypt($request->phone . $userId);

        // Tạo tài khoản người dùng
        $user = User::create([
            'user_id' => $userId,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => 2, // Đặt vai trò là bác sĩ
            'specialty_id' => $request->specialty_id,
            'password' => $password,
            'birthday' => $request->birthday
        ]);

        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);

            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('uploads/avatars', $avatarName, 'public');

            $user->avatar = $avatarName;
            $user->save();
        }

        // Tạo hồ sơ bác sĩ
        ProfileDoctor::create([
            'description' => $request->description,
            'work_experience' => $request->work_experience,
            'degree' => $request->degree,
            'user_id' => $user->user_id,
        ]);

        event(new EventDoctor($user))
        ;
        // \Mail::to($user->email)->send(new DoctorCreated($user));
        // dd( $user->email);

        return redirect()->route('system.doctor')->with('success', 'Thêm bác sĩ thành công!');

    }






}



