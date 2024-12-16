<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TreatmentDetail;
use App\Models\MedicalRecord;
use App\Models\TreatmentService;
use Illuminate\Http\Request;
use App\Models\ImgTreatmentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\TreatmentDetail\TreatmentDetailRequest;
use Intervention\Image\Facades\Image;

class BorderlineResultController extends Controller
{
    public function index(Request $request)
    {
        $queryMedicalRecord = MedicalRecord::select(
            'medical_records.medical_id',
            'patients.first_name',
            'patients.last_name',
            'users.firstname as user_firstname',
            'users.lastname as user_lastname',
            'services.name as service_name',
            'specialties.name as specialty_name',
            'treatment_services.service_id',
            'treatment_services.treatment_id',
        )
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->join('books', 'books.book_id', '=', 'medical_records.book_id')
            ->join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->join('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->join('treatment_details', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->join('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->groupBy(
                'medical_records.medical_id',
                'patients.first_name',
                'patients.last_name',
                'users.firstname',
                'users.lastname',
                'specialties.name',
                'services.name',
                'treatment_services.treatment_id',
                'treatment_services.service_id'
            )->orderBy('treatment_details.medical_id', 'DESC');
        if ($request->filled('name')) {

            $name = str_replace('+', ' ', $request->name);
            $name = trim($name);

            $queryMedicalRecord->where(function ($query) use ($name) {

                $nameParts = explode(' ', $name);

                foreach ($nameParts as $part) {
                    $query->where(function ($subQuery) use ($part) {
                        $subQuery->where('patients.first_name', 'like', '%' . $part . '%')
                            ->orWhere('patients.last_name', 'like', '%' . $part . '%');
                    });
                }

                $query->orWhere(DB::raw("CONCAT(patients.first_name, ' ', patients.last_name)"), 'like', '%' . $name . '%');
            });
        }


        if ($request->filled('doctor')) {

            $doctor = str_replace('+', ' ', $request->doctor);
            $doctor = trim($doctor);

            $queryMedicalRecord->where(function ($query) use ($doctor) {

                $nameParts = explode(' ', $doctor);

                foreach ($nameParts as $part) {
                    $query->where(function ($subQuery) use ($part) {
                        $subQuery->where('users.firstname', 'like', '%' . $part . '%')
                            ->orWhere('users.lastname', 'like', '%' . $part . '%');
                    });
                }

                $query->orWhere(DB::raw("CONCAT(users.firstname, ' ', users.lastname)"), 'like', '%' . $doctor . '%');
            });
        }


        if ($request->filled('MedicalRecord')) {
            $queryMedicalRecord->where('medical_records.medical_id', 'like', '%' . $request->MedicalRecord . '%');
        }
        if ($request->filled('specialty')) {
            $queryMedicalRecord->where('specialties.name', 'like', '%' . $request->specialty . '%');
        }

        $MedicalRecord = $queryMedicalRecord->paginate(10)->appends($request->query());

        return view('System.treatmentdetail.index', ['MedicalRecord' => $MedicalRecord]);
    }

    public function delete($id)
    {

        $MedicalRecord = MedicalRecord::findOrFail($id);

        $MedicalRecord->delete();

        return redirect()->route('system.borderline-result')->with('success', 'Xóa thành công.');
    }

    public function detail($treatment_id, $service_id)
    {
        $MedicalRecord = TreatmentDetail::select(
            'treatment_details.*',
            'patients.first_name',
            'patients.last_name',
            'patients.gender',
            'patients.address',
            'patients.birthday',
            'sclinics.name as clinic_name',
            'specialties.name as specialty_name',
            'services.name as service_name',
            'users.firstname',
            'users.lastname',
            'treatment_services.note',
            'treatment_services.result',
            'services.service_id'
        )
            ->leftJoin('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->leftJoin('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->leftJoin('books', 'books.book_id', '=', 'medical_records.book_id')
            ->leftJoin('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->leftJoin('sclinics', 'sclinics.sclinic_id', '=', 'schedules.sclinic_id')
            ->leftjoin('users', 'users.user_id', '=', 'schedules.user_id')
            ->leftJoin('specialties', 'specialties.specialty_id', '=', 'sclinics.specialty_id')
            ->leftjoin('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
            ->leftJoin('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->leftjoin('img_treatment_service', 'img_treatment_service.treatment_id', '=', 'treatment_services.treatment_id')
            ->where('treatment_services.treatment_id', $treatment_id)
            ->where('treatment_services.service_id', $service_id)
            ->groupBy(
                'treatment_details.treatment_id',
                'treatment_details.row_id',
                'treatment_services.note',
                'treatment_services.result',
                'treatment_services.deleted_at',
                'treatment_services.created_at',
                'treatment_services.updated_at',

                'patients.patient_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.address',
                'patients.cccd',
                'patients.insurance_number',
                'patients.emergency_contact',
                'patients.occupation',
                'patients.national',
                'patients.phone',
                'patients.deleted_at',
                'patients.created_at',
                'patients.updated_at',

                'sclinics.row_id',
                'sclinics.sclinic_id',
                'sclinics.description',
                'sclinics.status',
                'sclinics.specialty_id',
                'sclinics.deleted_at',
                'sclinics.created_at',
                'sclinics.updated_at',

                'specialties.row_id',
                'specialties.name',
                'specialties.status',
                'specialties.specialty_id',
                'specialties.deleted_at',
                'specialties.created_at',
                'specialties.updated_at',

                'services.name',
                'services.service_id',
                'services.row_id',
                'services.price',
                'services.status',
                'services.directory_id',
                'services.deleted_at',
                'services.created_at',
                'services.updated_at',

                'users.row_id',
                'users.user_id',
                'users.firstname',
                'users.lastname',
                'users.avatar',
                'users.email',
                'users.password',
                'users.birthday',
                'users.phone',
                'users.google_id',
                'users.zalo_id',
                'users.facebook_id',
                'users.role',
                'users.status',
                'users.email_verified_at',
                'users.remember_token',
                'users.created_at',
                'users.updated_at',


            )->first();
        $images = ImgTreatmentService::join('treatment_services', 'treatment_services.treatment_id', '=', 'img_treatment_service.treatment_id')
            ->where('treatment_services.treatment_id', $treatment_id)
            ->where('img_treatment_service.service_id', $service_id)
            ->pluck('img', 'img_id');
        return view('System.treatmentdetail.detail', ['MedicalRecord' => $MedicalRecord, 'images' => $images]);
    }

    public function update(Request $request, $treatment_id, $service_id)
    {
        $MedicalRecord = TreatmentService::where('treatment_id', $treatment_id)
            ->where('service_id', $service_id)
            ->first();

        $MedicalRecord->note = $request->input('note');
        $MedicalRecord->result = $request->input('result');
        $MedicalRecord->save();
    }
    public function uploadfile(Request $request)
    {
        if ($request->hasFile('image')) {

            $treatment_id = $request->input('treatment_id');
            $files = $request->file('image');
            $service_id = $request->input('service_id');

            foreach ($files as $file) {

                // Lấy thời gian thực và tạo tên mới cho ảnh
                $timestamp = now()->format('YmdHis'); // Định dạng thời gian: NămThángNgàyGiờPhútGiây
                $extension = $file->getClientOriginalExtension(); // Lấy đuôi file
                $fileName = $timestamp . '_' . uniqid() . '.' . $extension; // Tên file với thời gian và ID duy nhất

                // Lưu file vào thư mục
                $file->storeAs('uploads/TreatmentService', $fileName, 'public');

                // Lưu vào cơ sở dữ liệu
                ImgTreatmentService::create([
                    'img' => $fileName,
                    'treatment_id' => $treatment_id,
                    'service_id' => $service_id,
                ]);
            }
        }
    }

    public function fetchImages(Request $request)
    {
        $imagePaths = $request->input('image_paths');
        $images = [];

        foreach ($imagePaths as $imagePath) {

            // Đường dẫn tới file trên server
            $filePath = storage_path('app/public/uploads/TreatmentService/' . $imagePath); // Chú ý tới việc sửa đường dẫn đúng

            error_log('Checking file: ' . $filePath);

            if (file_exists($filePath)) {

                // Xây dựng URL mà client có thể truy cập (đảm bảo URL đúng và dễ sử dụng)
                $url = asset('storage/uploads/TreatmentService/' . $imagePath);

                $images[] = [
                    'url' => $url, // URL có thể truy cập của ảnh
                    'name' => basename($filePath), // Chỉ lưu tên tệp
                ];
            } else {
                error_log('File does not exist: ' . $filePath);
            }
        }

        return response()->json([
            'images' => $images
        ]);
    }



    public function revertfile(Request $request)
    {

        $treatment_id = $request->input('treatment_id');
        $file_name = $request->input('file_name'); // Lấy tên tệp từ yêu cầu

        $file_path = storage_path('app/public/uploads/TreatmentService/' . $file_name); // Đảm bảo đường dẫn chính xác

        if (file_exists($file_path)) {
            unlink($file_path); // Xóa tệp
            // Xóa bản ghi trong database
            ImgTreatmentService::where('treatment_id', $treatment_id)->where('img', $file_name)->delete();
            return response()->json(['message' => 'File deleted successfully']);
        } else {
            return response()->json(['error' => 'File not found']);
        }
    }
}