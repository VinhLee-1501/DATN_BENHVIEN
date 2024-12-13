<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Specialty\UpdateRequest;
use App\Http\Requests\Admin\Specialty\CreateRequest;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SpecialtyController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialty::query();

        if ($nameSpecialty = request('nameSpecialty')) {
            $query->where('name', 'like', '%' . $nameSpecialty . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }



        // dd($query);

        $specialties = $query->orderByRaw('status = 0 DESC')
            ->orderBy('row_id', 'DESC')
            ->paginate(10)
            ->appends(request()->query());

        $specialtiesDoctorCount = Specialty::select(
            'specialties.specialty_id',
            'specialties.name',
            DB::raw('COUNT(users.user_id) AS user_count')
        )
            ->leftJoin('users', 'users.specialty_id', '=', 'specialties.specialty_id')
            ->where('users.role', 2)
            ->groupBy(
                'specialties.specialty_id',
                'specialties.name',
                'specialties.status',
                'specialties.deleted_at',
                'specialties.created_at',
                'specialties.updated_at',

            )
            ->orderBy('user_count', 'DESC')
            ->get();

        return view('System.specialties.index', [
            'specialties' => $specialties,
            'specialtiesDoctorCount' => $specialtiesDoctorCount
        ]);
    }



    public function store(CreateRequest $request)
    {
        $specialty = new Specialty();

        // dd($request->input('specialtyName'));
        $specialty->specialty_id = strtoupper(Str::random('10'));
        $specialty->name = $request->input('specialtyName');
        $specialty->status = $request->input('specialtyStatus', false);

        $specialty->save();

        return response()->json(['success' => true, 'message' => 'Thêm dữ liệu thành công']);
    }

    public function edit($id)
    {
        $specialty = Specialty::where('specialty_id', $id)->first();

        return response()->json([
            'specialty_id' => $specialty->specialty_id,
            'specialtyName' => $specialty->name,
            'specialtyStatus' => $specialty->status
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        // dd($request->input('specialtyName'));
        $specialty = Specialty::where('specialty_id', $id)->first();

        if (!$specialty) {
            return response()->json(['error' => 'Không tìm thấy bản ghi'], 400);
        }


        $specialty->name = $request->input('specialtyName');
        $specialty->status = $request->input('specialtyStatus');

        $specialty->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật dữ liệu thành công']);
    }

    public function detail(Request $request, $id)
    {
        $query = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('users.role', 2)
            ->where('users.specialty_id', $id)
            ->select(
                'users.user_id',
                'users.firstname',
                'users.lastname',
                'users.email',
                'users.phone',
                'specialties.name',
                'users.avatar',
                'users.specialty_id'
            );
        $name = Specialty::where('specialty_id', $id)
            ->get(['name', 'specialty_id']);


        // Kiểm tra xem có bác sĩ nào thuộc chuyên khoa này không
        $doctorsSpecialtyCount = $query->count(); // Đếm số bác sĩ trong chuyên khoa
        if ($doctorsSpecialtyCount == 0) {

            return redirect()->route('system.specialty')->with('error', 'Khoa này chưa có bác sĩ');
        } else {
            if ($request->filled('firstname')) {
                $query->where('users.firstname', 'like', '%' . $request->firstname . '%');
            }
            if ($request->filled('lastname')) {
                $query->where('users.lastname', 'like', '%' . $request->lastname . '%');
            }
            if ($request->filled('phone')) {
                $query->where('users.phone', 'like', '%' . $request->phone . '%');
            }

            // Lấy dữ liệu bác sĩ thuộc chuyên khoa và phân trang
            $doctorsSpecialty = $query->paginate(10)->appends($request->all());

            return view('System.specialties.detail', [
                'doctorsSpecialty' => $doctorsSpecialty,
                'name' => $name
            ]);
        }
    }





    public function destroy($id)
    {
        $specialty = Specialty::where('specialty_id', $id)->first();
        $specialty->delete();
        return redirect()->route('system.specialty')->with('success', 'Xóa thành công');
    }
}