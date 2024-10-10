<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Specialty;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Đăng ký bất kỳ dịch vụ nào cho ứng dụng.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Định nghĩa bất kỳ logic nào cần thiết cho việc khởi động dịch vụ.
     *
     * @return void
     */
    public function boot()
    {
        // Chia sẻ biến $specialties cho tất cả các view
        View::share('specialties', Specialty::where('status', 1)->get());
    }
}
