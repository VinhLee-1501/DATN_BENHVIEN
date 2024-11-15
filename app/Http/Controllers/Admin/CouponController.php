<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\CreateRequest;
use App\Http\Requests\Admin\Coupon\UpdateRequest;
use App\Models\Products\Category;
use App\Models\Products\CategorySale;
use App\Models\Products\Coupon;
use App\Models\Products\Product;
use App\Models\Products\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search', '');

        // Lấy các blog_id cần xóa từ request
        $delete = $request->input('coupon_id', []);

        // Xử lý xóa các bài viết
        if (!empty($delete)) {
            Coupon::whereIn('coupon_id', $delete)->delete();
            return redirect()->route('system.coupon')->with('success', 'Đã xóa các bài viết được chọn.');
        }

        // Lấy số lượng phần tử trên mỗi trang, mặc định là 5
        $itemsPerPage = $request->input('itemsPerPage', 5);

        // Nếu có từ khóa tìm kiếm, thực hiện tìm kiếm và phân trang
        if ($search) {
            $coupons = Coupon::where('discount_code', 'LIKE', "%$search%")
                ->orderBy('created_at', 'desc')
                ->paginate($itemsPerPage); // Sử dụng $itemsPerPage cho phân trang
        } else {
            // Nếu không tìm kiếm, chỉ phân trang theo $itemsPerPage
            $coupons = Coupon::orderBy('created_at', 'desc')->paginate($itemsPerPage);
        }

        // Trả về view với các tham số cần thiết
        return view('System.coupon.index', [
            'coupons' => $coupons,
            'search' => $search
        ]);
    }

    public function resetsearch()
    {
        return redirect()->route('system.coupon');
    }


    public function create()
    {
        return view('System.coupon.create');
    }

    public function store(CreateRequest $request)
    {
        $coupon = new Coupon();

        $coupon->discount_code = $request->input('discount_code');
        $coupon->note = $request->input('note');
        $coupon->type = $request->input('type');
        $coupon->percent = $request->input('percent');
        $coupon->use_limit = $request->input('use_limit');
        $coupon->min_purchase = $request->input('min_purchase');
        $coupon->time_start = $request->input('time_start');
        $coupon->time_end = $request->input('time_end');

        $coupon->save();


        // Nếu có sản phẩm
        if ($request->has('product_id') || $request->has('category_id')) {
            // Nếu có sản phẩm
            if ($request->has('product_id')) {
                foreach ($request->input('product_id') as $productId) {
                    $productsale = new ProductSale();
                    $productsale->coupon_id = $coupon->coupon_id;
                    $productsale->product_id = $productId;
                    $productsale->save();
                }
            }

            // Nếu có danh mục
            if ($request->has('category_id')) {
                foreach ($request->input('category_id') as $categoryId) {
                    $categorysale = new CategorySale();
                    $categorysale->coupon_id = $coupon->coupon_id;
                    $categorysale->category_id = $categoryId;
                    $categorysale->save();
                }
            }
        }

        // dd($request);

        return response()->json(['success' => true, 'message' => 'Thêm mã giảm giá thành công']);
    }


    public function edit($id)
    {
        $coupon = Coupon::selectRaw('coupons.*, 
        GROUP_CONCAT(CONCAT(product_sale.product_id, ":", products.name) SEPARATOR ", ") AS product_info,
        GROUP_CONCAT(CONCAT(category_sale.category_id, ":", categories.name) SEPARATOR ", ") AS category_info')
            ->leftJoin('product_sale', 'product_sale.coupon_id', '=', 'coupons.coupon_id')
            ->leftJoin('products', 'products.product_id', '=', 'product_sale.product_id')
            ->leftJoin('category_sale', 'category_sale.coupon_id', '=', 'coupons.coupon_id')
            ->leftJoin('categories', 'categories.category_id', '=', 'category_sale.category_id')
            ->where('coupons.discount_code', $id)
            ->whereNull('category_sale.deleted_at')
            ->whereNull('product_sale.deleted_at')
            ->groupBy('coupons.coupon_id')
            ->first();

           
        // Kiểm tra nếu request là AJAX
        if (request()->ajax()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'product_info' => $coupon->product_info,
                    'category_info' => $coupon->category_info,
                ]
            ]);
        }   
      
        return view('System.coupon.edit', ['coupon' => $coupon, 'old_dicount_code' => $coupon->discount_code]);
    }


    public function update(CreateRequest $request, $id)
    {

        $coupon = Coupon::where('discount_code', $id)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon không tồn tại']);
        }

        // Cập nhật các trường của coupon
        $coupon->discount_code = $request->input('discount_code');
        $coupon->note = $request->input('note');
        $coupon->type = $request->input('type');
        $coupon->percent = $request->input('percent');
        $coupon->use_limit = $request->input('use_limit');
        $coupon->min_purchase = $request->input('min_purchase');
        $coupon->time_start = $request->input('time_start');
        $coupon->time_end = $request->input('time_end');

        // Lưu lại coupon
        $coupon->save();

        // Nếu có sản phẩm hoặc danh mục
        if ($request->has('product_id') || $request->has('category_id')) {
            // Xóa các bản ghi cũ liên quan đến coupon trước khi thêm mới
            ProductSale::where('coupon_id', $coupon->coupon_id)->delete();
            CategorySale::where('coupon_id', $coupon->coupon_id)->delete();

            // Nếu có sản phẩm
            if ($request->has('product_id')) {
                foreach ($request->input('product_id') as $productId) {
                    $productsale = new ProductSale();
                    $productsale->coupon_id = $coupon->coupon_id; // Gắn coupon_id để liên kết với Coupon
                    $productsale->product_id = $productId;
                    $productsale->save();
                }
            }

            // Nếu có danh mục
            if ($request->has('category_id')) {
                foreach ($request->input('category_id') as $categoryId) {
                    $categorysale = new CategorySale();
                    $categorysale->coupon_id = $coupon->coupon_id; // Gắn coupon_id để liên kết với Coupon
                    $categorysale->category_id = $categoryId;
                    $categorysale->save();
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật mã giảm giá thành công']);
    }


    public function delete($id)
    {
        $coupon = Coupon::where('coupon_id', $id)->first();
        $coupon->delete();
        return redirect()->route('system.coupon')->with('success', 'Xóa thành công.');
    }

    public function listproduct(Request $request)
    {
        $search = $request->input('searchItem');

        $query = Product::select('product_id', 'name');


        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->paginate(10);

        return response()->json([
            'data' => $products->items(), // Đảm bảo trả về 'data' thay vì 'items'
            'last_page' => $products->lastPage(), // Trả về số trang cuối cùng
        ]);
    }

    public function listcategory(Request $request)
    {
        $search = $request->input('searchItem');

        $query = Category::select('category_id', 'name');


        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10);

        return response()->json([
            'data' => $categories->items(), // Đảm bảo trả về 'data' thay vì 'items'
            'last_page' => $categories->lastPage(), // Trả về số trang cuối cùng
        ]);
    }
}
