<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Products\CartDetail;
use App\Models\Products\CartProduct;
use App\Models\Products\Category;
use App\Models\Products\Coupon;
use App\Models\Products\OrderProduct;
use App\Models\Products\ParentCategory;
use App\Models\Products\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;


class ShopController extends Controller
{
    public function index(Request $request)
    {
        $parentCategoryProductFillter = ParentCategory::get();

        // Filter product by parent_id to table parent_categories
        $parentId = $request->input('parent_id', '*');

        $query = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->join('parent_categories', 'parent_categories.parent_id', '=', 'categories.parent_id')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale'
            )->groupBy(
                'products.product_id',
                'categories.category_id',
                'categories.name',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.quantity',
                'products.created_at',
                'products.updated_at',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end'

            )
            ->orderBy('products.product_id', 'DESC');

        if (!empty($parentId) && $parentId !== '*') {
            $query->where('parent_categories.parent_id', $parentId);
        }

        $products = $query->limit(8)->get();

        if ($products->isNotEmpty()) {
            $products->transform(function ($product) {
                $product->img_array = array_filter(explode(',', $product->img_array));
                $product->isInSalePeriod = $product->dateStartSale <= Carbon::now() && $product->dateEndSale >= Carbon::now();
                return $product;
            });
        }

        if ($request->ajax()) {
            if ($products->isEmpty()) {
                return response()->json(['html' => '<p>Không có dữ liệu.</p>']);
            }

            $html = view('shop._product_card', ['products' => $products])->render();
            Log::info($html); // Xem nội dung của HTML được render
            return response()->json(['html' => $html]);
        }

        // Product sale limit 6
        $productSale = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'coupons.percent',
                'coupons.discount_code',
                DB::raw('MIN(img_products.img) as imgName')
            ) // Lấy hình ảnh đầu tiên
            ->groupBy(
                'products.product_id',
                'categories.name',
                'coupons.percent',
                'coupons.discount_code',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.description',
                'products.price',
                'products.quantity',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
            )
            ->limit(6)
            ->get();
        $chunkedProductsSale = $productSale->chunk(3);

        // Product new
        $productNew = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'coupons.discount_code',
                'coupons.percent',
                DB::raw('MIN(img_products.img) as imgName'),
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale'
            )
            ->groupBy(
                'products.product_id',
                'categories.name',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.quantity',
                'products.deleted_at',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
            )
            ->orderBy('products.product_id', 'DESC')
            ->limit(6)
            ->get();
        $chunkedProductsNew = $productNew->chunk(3);

        return view(
            'shop.index',
            [
                'parentCategoryProductFillter' => $parentCategoryProductFillter,
                'products' => $products,
                'chunkedProductsSale' => $chunkedProductsSale,
                'chunkedProductsNew' => $chunkedProductsNew
            ]
        );
    }


    public function contact()
    {
        return view('shop.contact');
    }

    public function detail($id)
    {

        $productById = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.product_id', $id)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale'
            )
            ->groupBy(
                'products.product_id',
                'categories.category_id',
                'categories.name',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.quantity',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end'
            )
            ->first();

        if ($productById) {
            $productById->img_array = array_filter(explode(',', $productById->img_array));
        }

        $productByCategory = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->where('categories.category_id', $productById->category_id)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale'
            )
            ->groupBy(
                'products.product_id',
                'categories.category_id',
                'categories.name',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.description',
                'products.quantity',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end'
            )
            ->limit(4)
            ->get();

        $productByCategory->transform(function ($productByCategory) {
            $productByCategory->img_array = array_filter(explode(',', $productByCategory->img_array)); // Chuyển img_array thành mảng
            return $productByCategory;
        });


        return view('shop.detail', [
            'productById' => $productById,
            'productByCategory' => $productByCategory,
        ]);
    }

    public function grid(Request $request)
    {
        $searchTerm = $request->input('search', '');
        // Categories
        $categories = Category::limit(10)->get();
        // Products active
        $productsActive = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'coupons.discount_code',
                'coupons.percent',
                DB::raw('MIN(img_products.img) as imgName'),
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale'
            )
            ->groupBy(
                'products.product_id',
                'categories.name',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.quantity',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
            )
            ->where('products.name', 'like', '%' . $searchTerm . '%')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(8);

        // Sale products
        $SelectProductWithsaleProduct
            =
            Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->join('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->join('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join(
                'img_products',
                'img_products.product_id',
                '=',
                'products.product_id'
            )
            ->where(function ($query) {
                $query->where('coupons.time_start', '<=', Carbon::now())
                    ->where('coupons.time_end', '>=', Carbon::now());
            })
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'coupons.discount_code',
                'coupons.percent',
                DB::raw('MIN(img_products.img) as imgNameSale')
            )
            ->groupBy(
                'products.product_id',
                'categories.name',
                'coupons.discount_code',
                'coupons.percent',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.quantity',
                'products.category_id',
                'products.deleted_at',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
            )
            ->limit(6)
            ->get();

        // Product new
        $productNew = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->select('products.*', 'categories.name as nameCategory', 'coupons.discount_code', DB::raw('MIN(img_products.img) as imgName'))
            ->groupBy(
                'products.product_id',
                'categories.name',
                'coupons.discount_code',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.quantity',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
            )
            ->orderBy('products.created_at', 'DESC')
            ->limit(6)
            ->get();
        $chunkedProductsNew = $productNew->chunk(3);


        // Count product
        $countProducts = count($productsActive);

        // dd($productsActive);
        return view('shop.grid', [
            'categories' => $categories,
            'SelectProductWithsaleProduct' => $SelectProductWithsaleProduct,
            'countProducts' => $countProducts,
            'productsActive' => $productsActive,
            'chunkedProductsNew' => $chunkedProductsNew,
        ]);
    }

    public function cart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để truy cập giỏ hàng.');
        }

        $cartItems = CartDetail::join('cart_products', 'cart_products.cart_id', '=', 'cart_details.cart_id')
            ->join('products', 'products.product_id', '=', 'cart_details.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('cart_products.user_id', $user->user_id)
            ->select(
                'cart_products.cart_id as cartId',
                'cart_products.user_id',
                'cart_details.*',
                'products.product_id',
                'products.name as productName',
                'products.price',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale'
            )
            ->groupBy(
                'cart_products.cart_id',
                'cart_products.user_id',
                'cart_details.cart_detail_id',
                'cart_details.quantity',
                'cart_details.cart_id',
                'cart_details.product_id',
                'cart_details.deleted_at',
                'cart_details.updated_at',
                'cart_details.created_at',
                'products.product_id',
                'categories.category_id',
                'categories.name',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.quantity',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end'
            )
            ->get();

        $cartItems->transform(function ($item) {
            $item->img_array = array_filter(explode(',', $item->img_array)); // Chuyển img_array thành mảng
            return $item;
        });

        // dd($cartItems);
        return view('shop.cart', [
            'cartItems' => $cartItems,
        ]);
    }

    public function addProductToCart($id, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần phải đăng nhập để truy cập giỏ hàng.'
            ]);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại.'
            ]);
        }

        $quantity = $request->input('quantity');
        $cartProduct = CartProduct::where('user_id', $user->user_id)->first();

        if (!$cartProduct) {
            $cartProduct = CartProduct::create([
                'user_id' => $user->user_id,
            ]);
        }

        $cartDetail = CartDetail::where('cart_id', $cartProduct->cart_id)
            ->where('product_id', $product->product_id)
            ->first();

        if ($cartDetail) {
            $cartDetail->quantity += $quantity;
            $cartDetail->save();
        } else {
            CartDetail::create([
                'cart_id' => $cartProduct->cart_id,
                'product_id' => $product->product_id,
                'quantity' => $quantity,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm vào giỏ hàng thành công.'
        ]);
    }



    public function updateCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để truy cập giỏ hàng.');
        }

        $cart = CartProduct::where('user_id', $user->user_id)->first();

        // Cập nhật số lượng cho sản phẩm
        if ($request->has('quantity')) {
            foreach ($request->quantity as $cartDetailId => $quantity) {
                $cartItem = CartDetail::where('cart_id', $cart->cart_id)
                    ->where('cart_detail_id', $cartDetailId)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity = $quantity;
                    $cartItem->save();
                }
            }
        }

        // Xóa row cart
        if ($request->has('remove')) {
            foreach ($request->remove as $cartDetailIdRemove => $isRemove) {
                if ($isRemove) {
                    $cartItem = CartDetail::where('cart_id', $cart->cart_id)
                        ->where('cart_detail_id', $cartDetailIdRemove)
                        ->first();
                    // dd($cartItem);
                    if ($cartItem) {
                        $cartItem->delete();
                    }
                }
            }
        }
        return redirect()->route('shop.cart')->with('success', 'Giỏ hàng đã được cập nhật.');
    }


    public function blog()
    {
        return view('shop.blog');
    }

    public function checkVoucher(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'total' => 'required',
            'code' => 'required',
        ], [
            'total.required' => 'Tổng số tiền là bắt buộc.',
            'code.required' => 'Mã giảm giá là bắt buộc.',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $coupon = Coupon::where('discount_code', $request->input('code'))->first();
        $currentDateTime = Carbon::now();

        if ($coupon) {

            if ($currentDateTime < $coupon->time_start || $currentDateTime > $coupon->time_end) {
                return response()->json(['error' => true, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.']);
            }

            if ($coupon->type != 0) {
                return response()->json(['error' => true, 'message' => 'Mã giảm giá không áp dụng cho hóa đơn này.']);
            }


            if ($request->total < $coupon->min_purchase) {
                return response()->json(['error' => true, 'message' => 'Mã giảm giá chỉ áp dụng cho hóa đơn từ ' . $coupon->min_purchase . ' trở lên.']);
            }

            if ($coupon->use_limit == 0) {
                return response()->json(['error' => true, 'message' => 'Mã giảm giá hết lượt sử dụng.']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Mã giảm giá hợp lệ.',
                'percent' => $coupon->percent,
                'total' => $request->total,
                'coupon' => $coupon->discount_code,
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Mã Giảm giá không hợp lệ'
            ]);
        }
    }


    public function checkout(Request $request)
    {

        if (!$request->input('cart_id')) {
            return redirect()->route('shop.cart')->with('message', 'Chưa có sản phẩm trong giỏ hàng');
        }
        $user_id = $request->input('user_id');
        $cart_id = $request->input('cart_id');
        $discount = $request->input('coupon');
        $total = $request->input('total');
        $sale = $request->input('sale_price_check');
        $user = User::where('user_id', $user_id)->first();
        $cart = CartProduct::where('cart_products.cart_id', $cart_id)
            ->join('cart_details', 'cart_details.cart_id', '=', 'cart_products.cart_id')
            ->join('products', 'products.product_id', '=', 'cart_details.product_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->whereNull('cart_details.deleted_at')
            ->select(
                'cart_products.*',
                'cart_details.*',
                'cart_details.quantity as quantitycart',
                'products.*',
                'coupons.discount_code',
                'coupons.percent as percent',
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale',
                DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(img_products.img ORDER BY img_products.img SEPARATOR ","), ",", 1) as img_first')
            )
            ->groupBy(
                'cart_products.cart_id',
                'cart_products.user_id',
                'cart_products.deleted_at',
                'cart_products.created_at',
                'cart_products.updated_at',
                'products.product_id',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.brand',
                'products.category_id',
                'products.deleted_at',
                'products.description',
                'products.price',
                'products.quantity',
                'products.manufacture',
                'products.registration_number',
                'products.status',
                'products.created_at',
                'products.updated_at',
                'cart_details.cart_detail_id',
                'cart_details.product_id',
                'cart_details.quantity',
                'cart_details.cart_id',
                'cart_details.deleted_at',
                'cart_details.updated_at',
                'cart_details.created_at',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end',
                'coupons.coupon_id',
                'coupons.type',
                'coupons.use_limit',
                'coupons.min_purchase',
                'coupons.note',
                'coupons.created_at',
                'coupons.updated_at',
                'coupons.deleted_at',
            )
            ->get();

        $coupon = Coupon::where('discount_code', $request->input('coupon'))->first();
        return view('shop.checkout', ['user' => $user, 'total_price' => $total, 'coupon' => $coupon, 'discount' => $discount, 'sale' => $sale, 'cart' => $cart]);
    }
    public function search(Request $request)
    {
        $search = $request->input('search');
        $products = Product::select('products.status', 'products.name', 'products.product_id')
            ->selectSub(function ($query) {
                $query->select('ip.img')
                    ->from('img_products as ip')
                    ->whereColumn('ip.product_id', 'products.product_id')
                    ->orderByRaw('LENGTH(ip.img) ASC')
                    ->orderBy('ip.img', 'ASC')
                    ->limit(1);
            }, 'img')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->where('products.name', 'LIKE', "%$search%")
            ->orderByDesc('products.product_id')
            ->limit(10)
            ->get();

        return response()->json([
            'products' => $products,
            'search' => $search
        ]);
    }

    public function getSuggestedProducts()
    {
        $products = Product::select('products.status', 'products.name', 'products.product_id')
            ->selectSub(function ($query) {
                $query->select('ip.img')
                    ->from('img_products as ip')
                    ->whereColumn('ip.product_id', 'products.product_id')
                    ->orderByRaw('LENGTH(ip.img) ASC')
                    ->orderBy('ip.img', 'ASC')
                    ->limit(1);
            }, 'img')
            ->where('products.status', 1)
            ->where('products.quantity', '>', 0)
            ->orderByDesc('products.product_id')
            ->limit(10)
            ->get();
        return response()->json([
            'products' => $products
        ]);
    }
}