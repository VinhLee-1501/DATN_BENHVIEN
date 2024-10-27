<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\RegisterRequest;
use App\Http\Requests\Client\User\LoginRequest;
use App\Http\Requests\Client\User\UpdateProfileRequest;
use App\Http\Requests\Client\User\ChangePasswordRequest;
use App\Models\User;
use App\Models\Book;
use App\Models\Specialty;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Service;
use App\Models\TreatmentService;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class UserController extends Controller
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register()
    {
        $showPopup = 'register';
        return view('client.index', ['showPopup' => $showPopup]);
    }

    public function handleRegister(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $users = $this->userRepository->create([
            'user_id' => $this->generateUserId(), // Tạo user_id random
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'avatar' => 'https://topcode.vn/assets/images/avanta2.png',
            'email_verified_at' => now(),
        ]);

        if ($users) {
            return redirect()->route('client.register')->with('success', 'Đăng ký thành công!');
        } else {
            return redirect()->route('client.register')->with('error', 'Đăng ký thất bại. Vui lòng thử lại.');
        }
    }
    protected function generateUserId()
    {
        return strtoupper(Str::random(10)); // Chuỗi 10 ký tự ngẫu nhiên
    }
    public function login()
    {

        $showPopup = 'login';
        return view('client.index', ['showPopup' => $showPopup]);
    }

    public function authenticateLogin(LoginRequest $request)
    {
        $credentials = [
            'phone' =>  $request->input('phone'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            if (!empty(Auth::user()->email_verified_at)) {
                $request->session()->regenerate();

                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            }
        }
        return redirect()->back()
            ->with('error', 'Email hoặc mật khẩu không chinh xác');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('client.login')->with('success', 'Đăng xuất thành công');
    }
    public function index(Request $request)
    {
        // Lấy user_id của người dùng đã đăng nhập
        $userId = Auth::user()->user_id;
        $userPhone = Auth::user()->phone;

        // Lấy lịch sử y tế của người dùng
        $medicalHistory = Book::where('user_id', $userId)->get();
        foreach ($medicalHistory as $history) {
            $history->specialty = Specialty::where('specialty_id', $history->specialty_id)
                ->where('status', 1)
                ->first();
        }

        // Lấy dữ liệu lịch sử bệnh án cùng với thông tin bệnh nhân
        $medicalRecordHistory = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
            ->where('patients.phone', $userPhone) // Chỉ lấy bệnh án của người dùng này
            ->distinct()
            ->paginate(5);

        // Duyệt từng bệnh án để lấy thêm các thông tin chi tiết điều trị, dịch vụ và thuốc
        foreach ($medicalRecordHistory as $record) {
            // Lấy thông tin điều trị
            $record->treatment_details = DB::table('treatment_details')
                ->where('medical_id', $record->medical_id)
                ->get();

            // Lấy danh sách dịch vụ
            $record->services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
                ->where('treatment_services.treatment_id', $record->treatment_details[0]->treatment_id ?? null)
                ->get();

            // Lấy tổng giá của dịch vụ
            $record->total_price = TreatmentService::where('treatment_id', $record->treatment_details[0]->treatment_id ?? null)
                ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
                ->sum('services.price');

            // Lấy danh sách thuốc
            $record->medicines = Medicine::join('treatment_medications', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
                ->where('treatment_medications.treatment_id', $record->treatment_details[0]->treatment_id ?? null)
                ->get();
        }

        // Trả về view với các dữ liệu đã lấy
        return view('client.profile', [
            'userId' => $userId,
            'medicalHistory' => $medicalHistory,
            'medicalRecordHistory' => $medicalRecordHistory
        ]);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {

        $user = Auth::user();


        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để cập nhật hồ sơ.');
        }


        $oldPhone = $user->phone;


        $updatedUser = $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'), // Cập nhật email
            'birthday' => $request->input('birthday'),
        ]);


        if ($updatedUser && $oldPhone !== $request->input('phone')) {
            $patient = $user->patient;
            if ($patient) {
                $patient->update(['phone' => $request->input('phone')]);
            }
        }


        return $updatedUser
            ? redirect()->route('client.profile.index')->with(['info_success' => 'Cập nhật hồ sơ thành công!', 'activeTab' => 'update_info'])
            : redirect()->route('client.profile.index')->with(['info_error' => 'Cập nhật hồ sơ thất bại, vui lòng thử lại.', 'activeTab' => 'update_info']);
    }
    public function changePassword(ChangePasswordRequest $request)
    {

        $user = Auth::user();


        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }


        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu cũ.']);
        }


        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('change_password_success', 'Thay đổi mật khẩu thành công')->with('activeTab', 'change_password');
    }
}
