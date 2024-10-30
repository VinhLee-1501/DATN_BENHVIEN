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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

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
            'avatar' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png',
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
            return redirect()->route('system.auth.login')->with('error', 'Bạn cần phải đăng nhập để cập nhật hồ sơ.');
        }

        $oldPhone = $user->phone;

        // Lấy specialty_id từ request
        $specialty_id = $request->input('specialty_id');

        // Cập nhật thông tin người dùng
        $updatedUser = $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'birthday' => $request->input('birthday'),
            'specialty_id' => $specialty_id,  // sử dụng specialty_id từ request
        ]);

        // Kiểm tra cập nhật thành công
        if (!$updatedUser) {
            return redirect()->back()->withErrors(['update' => 'Không thể cập nhật thông tin.']);
        }

        // Cập nhật thông tin bệnh nhân nếu số điện thoại thay đổi
        if ($oldPhone !== $request->input('phone')) {
            $patient = $user->patient;
            if ($patient) {
                $patient->update(['phone' => $request->input('phone')]);
            }
        }

        return redirect()->route('client.profile.index')->with('success', 'Cập nhật thông tin thành công');
    }
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để cập nhật hồ sơ.');
        }


        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);

            // Xóa avatar cũ nếu tồn tại
            if ($user->avatar) {
                Storage::disk('public')->delete('uploads/avatars/' . $user->avatar);
            }

            // Lưu avatar mới vào thư mục 'uploads/avatars'
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('uploads/avatars', $avatarName, 'public');

            // Gán tên file avatar mới vào user
            $user->avatar = $avatarName;

            // Cập nhật avatar trong cơ sở dữ liệu
            $user->save();
        }

        return redirect()->route('client.profile.index')->with('success', 'Cập nhật ảnh đại diện thành công!');
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
    public function forgotPassword()
    {

        $showPopup = 'forgot-password';
        return view('client.index', ['showPopup' => $showPopup]);
    }
    /**
     * Gửi email khôi phục mật khẩu với token ngẫu nhiên.
     */

    public function sendResetPasswordEmail(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'required' => 'Trường email là bắt buộc.',
            'email' => 'Trường email phải là một địa chỉ email hợp lệ.',
            'exists' => 'Địa chỉ email không tồn tại trong hệ thống.',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );


        $resetLink = url("/doi-mat-khau?token={$token}&email={$request->email}");


        Mail::send('emails.password-reset', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Khôi phục mật khẩu');
        });


        return back()->with('success', 'Gửi link khôi phục mật khẩu thành công! Vui lòng kiểm tra email của bạn.');
    }
    public function showResetForm(Request $request)
    {

        $email = $request->query('email');


        $resetRecord = DB::table('password_reset_tokens')

            ->where('email', $email)
            ->first();

        if (!$resetRecord) {
            return redirect()->route('client.login')->with('error', 'Yêu cầu không hợp lệ.');
        }

        // Tiếp tục xử lý nếu token và email hợp lệ
        return view('client.index', [

            'email' => $email,
            'showPopup' => 'reset-password',
        ]);
    }
    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'new_password' => ['required', 'confirmed', 'min:3'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->with(['error' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }

        //token có hiệu lực trong vòng 10 phút
        if (Carbon::parse($passwordReset->created_at)->addMinutes(10)->isPast()) {
            return back()->with(['error' => 'Token đã hết hạn.']);
        }


        $updated = User::resetUserPassword($request->email, $request->new_password);
        if ($updated) {

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            // Thông báo thành công
            return redirect()->route('client.login')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập.');
        } else {
            return back()->with(['error' => 'Có lỗi xảy ra trong quá trình đặt lại mật khẩu.']);
        }
    }
}
