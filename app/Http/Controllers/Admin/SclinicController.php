<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clinic\CreateRequest;
use App\Http\Requests\Admin\Clinic\UpdateRequest;
use App\Models\Sclinic;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SclinicController extends Controller
{
    public function index(Request $request)
    {
        $selectSpecialty = $request->input('seclectSpecialty'); // Lấy giá trị từ select chuyên khoa
        $nameClinic = $request->input('nameClinic'); // Lấy giá trị từ tìm kiếm phòng khám

        $query = Sclinic::join('specialties', 'specialties.specialty_id', '=', 'sclinics.specialty_id')
            ->select('sclinics.*', 'specialties.name as specialtyName')
            ->orderByRaw('sclinics.status = 0 DESC')
            ->orderBy('row_id', 'DESC');

        if ($selectSpecialty) {
            $query->where('sclinics.specialty_id', $selectSpecialty);
        }

        if ($nameClinic) {
            $query->where('sclinics.name', 'like', '%' . $nameClinic . '%');
        }

        $clinics = $query->paginate(10)->appends($request->all());

        if ($request->ajax()) {
            return response()->json(['clinics' => $clinics->items()]);
        }

        $specialties = Specialty::all();

        return view('System.clinic.index', [
            'clinics' => $clinics,
            'specialties' => $specialties
        ]);
    }


    public function create()
    {
        $specialties = Specialty::all();

        return response()->json(['specialties' => $specialties]);
    }

    public function store(CreateRequest $request)
    {
        $specialtyId = $request->input('specialtyName');
        $clicnicCount = Sclinic::where('specialty_id', $specialtyId)->count();


        if ($clicnicCount >= 3) {
            return response()->json(['error' => true, 'message' => 'Một chuyên khao được tối đa 3 phòng khám!']);
        }

        $sclinic = new Sclinic();
        $sclinic->sclinic_id = strtoupper(Str::random('10'));
        $sclinic->name = $request->input('sclinicName');
        $sclinic->specialty_id = $request->input('specialtyName');
        $sclinic->description = $request->input('description');
        $sclinic->status = $request->input('statusSclinic') ? 1 : 0;
        $sclinic->save();

        return response()->json(['success' => true, 'message' => 'Phòng khám đã được thêm thành công!']);
    }

    public function edit($id)
    {
        $sclinic = Sclinic::where('sclinic_id', $id)->first();
        $specialties = Specialty::all();

        return response()->json([
            'sclinic' => $sclinic,
            'sclinicId' => $sclinic->sclinic_id,
            'sclinicName' => $sclinic->name,
            'specialtyName' => $sclinic->specialty_id,
            'statusSclinic' => $sclinic->status,
            'sclinicNote' => $sclinic->description,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $specialtyId = $request->get('specialtyName');
        $sclinic = Sclinic::where('sclinic_id', $id)->first();

        if ($sclinic->specialty_id !== $specialtyId) {
            $clicnicCount = Sclinic::where('specialty_id', $specialtyId)->count();

            if ($clicnicCount >= 3) {
                return response()->json(['error' => true, 'message' => 'Một chuyên khao được tối đa 3 phòng khám!']);
            }
        }
        $sclinic->name = $request->input('sclinicName');
        $sclinic->specialty_id = $request->input('specialtyName');
        $sclinic->description = $request->input('sclinicNote');
        $sclinic->status = $request->input('statusSclinic');

        $sclinic->save();


        return response()->json(['success' => true, 'message' => 'Thông tin phòng khám đã được cập nhật thành công!']);
    }
}
