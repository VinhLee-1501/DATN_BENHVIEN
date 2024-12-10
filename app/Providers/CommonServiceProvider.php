<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Specialty;
use App\Models\Patient;
use App\Models\Products\CartDetail;
use App\Models\Products\CartProduct;
use App\Models\Products\ParentCategory;
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

        // // Chia sẻ danh mục với tất cả các view
        View::share('parent_categories', ParentCategory::where('status', 1)->get());

        // // đếm số lượng sản phẩm có trong cart
        View::composer('*', function ($view) {
            $user = Auth::user();
            // Kiểm tra nếu có người dùng đã đăng nhập, thì đếm số lượng sản phẩm trong giỏ của họ
            $cartCount = $user ? CartDetail::join('cart_products', 'cart_products.cart_id', '=', 'cart_details.cart_id')
                ->where('user_id', $user->user_id)->count('cart_detail_id') : 0;
            $view->with('cartCount', $cartCount);
        });
    }
}