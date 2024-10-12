<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Specialty\CreateRequest;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialtiesDoctorCount = Specialty::select('specialties.specialty_id', 'specialties.name',
            DB::raw('COUNT(users.user_id) AS user_count'))
            ->leftJoin('users', 'users.specialty_id', '=', 'specialties.specialty_id')
            ->where('users.role', 2)
            ->groupBy('specialties.specialty_id', 'specialties.name')
            ->orderBy('user_count', 'DESC')
            ->get();
        $specialties = Specialty::where('status', 1)
                        ->orderBy('row_id', 'DESC')
                        ->get();
//        dd($specialties);
        return view('System.specialties.index', [
            'specialties' => $specialties,
            'specialtiesDoctorCount' => $specialtiesDoctorCount
        ]);
    }

    public function store(CreateRequest $request)
    {
        $specialty = new Specialty();

        $specialty->specialty_id = strtoupper(Str::random('10'));
        $specialty->name = $request->input('name');
        $specialty->status = $request->input('status', false);

//        Log::info('Specialty Created', $specialty->toArray());
        $specialty->save();

        return response()->json(['success' => true, 'message' => 'Thêm dữ liệu thành công']);
    }

    public function edit($id)
    {
        $specialty = Specialty::where('specialty_id', $id)->first();

//        Log::info('Specialty Created', $specialty->toArray());
        return response()->json([
            'specialty_id' => $specialty->specialty_id,
            'nameEdit' => $specialty->name,
            'statusEdit' => $specialty->status
        ]);
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::where('specialty_id', $id)->first();

        if (!$specialty) {
            return response()->json(['error' => 'Không tìm thấy bản ghi'], 400);
        }

        $nameEdit = substr($request->input('nameEdit'), 0, 255);

        $specialty->name = $nameEdit;
//        $specialty->name = $request->input('nameEdit');
        $specialty->status = $request->input('statusEdit');

        $specialty->save();
//        Log::info('Request Data', $specialty->toArray());

        return response()->json(['success' => true, 'message' => 'Cập nhật dữ liệu thành công']);
    }

    public function detail($id)
    {
//        dd($id);
        $doctorsSpecialty = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('users.role', 2)
            ->where('users.specialty_id', $id)
            ->select('users.user_id','users.firstname', 'users.lastname',
                'users.email', 'users.phone', 'specialties.name', 'users.avatar')
            ->get();
//        dd($doctorsSpecialty);
        if ($doctorsSpecialty->isEmpty()){
            return redirect()->route('system.specialty')->with('error', 'Không tìm thấy bác sĩ thuộc chuyên ngành này');
        }
//        dd($doctorsSpecialty);
        return view('System.specialties.detail', [
            'doctorsSpecialty' => $doctorsSpecialty
        ]);
    }

    public function destroy($id){
        $specialty = Specialty::where('specialty_id', $id)->first();
        $specialty->delete();
        return redirect()->route('system.specialty')->with('success', 'Xóa thành công');
    }
}
