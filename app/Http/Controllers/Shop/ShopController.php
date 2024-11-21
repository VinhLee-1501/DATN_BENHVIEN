<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Products\CartDetail;
use App\Models\Products\CartProduct;
use App\Models\Products\Category;
use App\Models\Products\ParentCategory;
use App\Models\Products\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
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
            return response()->json(['html' => $html]);
        }

        // Product sale limit 6
        $productSale = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'coupons.discount_code',
                'coupons.percent',
                DB::raw('MIN(img_products.img) as imgName')
            ) // Lấy hình ảnh đầu tiên
            ->groupBy(
                'products.product_id',
                'categories.name',
                'coupons.discount_code',
                'coupons.percent',
                'products.price',
                'products.name'
            )
            ->limit(6)
            ->get();
        $chunkedProductsSale = $productSale->chunk(3);

        // Product new
        $productNew = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
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
                'products.price',
                'products.name'
            )
            ->orderBy('products.product_id', 'DESC')
            ->limit(6)
            ->get();
        $chunkedProductsNew = $productNew->chunk(3);

        return view(
            'Shop.index',
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
        return view('Shop.contact');
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
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
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
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status',
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


        return view('Shop.detail', [
            'productById' => $productById,
            'productByCategory' => $productByCategory,
        ]);
    }

    public function grid()
    {
        // Categories
        $categories = Category::limit(10)->get();
        // Products active
        $prodcutsActive =
            Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'coupons.discount_code',
                'coupons.percent',
                DB::raw('MIN(img_products.img) as imgName'),
                'coupons.time_start as dateStartSale',
                'coupons.time_end as dateEndSale',
            )
            ->groupBy(
                'products.product_id',
                'categories.name',
                'coupons.discount_code',
                'coupons.percent',
                'coupons.time_start',
                'coupons.time_end',
                'products.price',
                'products.name'
            )
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
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'coupons.discount_code',
                'coupons.percent',
                DB::raw('MIN(img_products.img) as imgNameSale')
            )
            ->groupBy('products.product_id', 'categories.name', 'coupons.discount_code', 'coupons.percent', 'products.price', 'products.name')
            ->limit(6)
            ->get();

        // Product new
        $productNew = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
            ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->select('products.*', 'categories.name as nameCategory', 'coupons.discount_code', DB::raw('MIN(img_products.img) as imgName'))
            ->groupBy('products.product_id', 'categories.name', 'coupons.discount_code', 'products.price', 'products.name')
            ->orderBy('products.created_at', 'DESC')
            ->limit(6)
            ->get();
        $chunkedProductsNew = $productNew->chunk(3);


        // Count product
        $countProducts = count($prodcutsActive);
        return view('Shop.grid', [
            'categories' => $categories,
            'SelectProductWithsaleProduct' => $SelectProductWithsaleProduct,
            'countProducts' => $countProducts,
            'prodcutsActive' => $prodcutsActive,
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
                'products.product_id',
                'categories.category_id',
                'categories.name',
                'products.name',
                'products.price',
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
        return view('Shop.cart', [
            'cartItems' => $cartItems,
        ]);
    }

    public function addProductToCart($id, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để truy cập giỏ hàng.');
        }

        $product = Product::find($id);
        // dd($product);
        if (!$product) {
            return redirect()->route('shop.cart')->with('error', 'Sản phẩm không tồn tại.');
        }

        $quantity = $request->input('quantity');
        // dd($quantity);

        // Kiểm tra user đã có giỏ hàng ?
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

        return redirect()->route('shop.cart')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
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
        return view('Shop.blog');
    }


    public function checkout(Request $request)
    {
        $user_id = $request->input('user_id');
        $total = $request->input('total');
        $user = User::where('user_id', $user_id)->first();

        $cart = CartProduct::where('user_id', $user_id)
            ->join('products', 'products.product_id', '=', 'cart_products.product_id')
            ->join('img_products', 'img_products.product_id', 'products.product_id')
            ->select(
                'cart_products.*',
                'products.*',
                DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(img_products.img), ",", 1) as img_first')
            )
            ->groupBy(
                'products.product_id',
                'cart_products.cart_id',
                'products.name',
                'products.code_product',
                'products.unit_of_measurement',
                'products.active_ingredient',
                'products.used',
                'products.description',
                'products.price',
                'products.manufacture',
                'products.registration_number',
                'products.status'
            )
            ->get();
        return view('Shop.checkout', ['user' => $user, 'total_price' => $total, 'cart' => $cart]);
    }
}
