<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Products\CartProduct;
use App\Models\Products\Category;
use App\Models\Products\ParentCategory;
use App\Models\Products\Product;
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
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->join('parent_categories', 'parent_categories.parent_id', '=', 'categories.parent_id')
            ->select(
                'products.*',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'sale_products.discount',
                'sale_products.time_start as dateStartSale',
                'sale_products.time_end as dateEndSale'
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
                'sale_products.discount',
                'sale_products.time_start',
                'sale_products.time_end'
            )
            ->orderBy('products.product_id', 'DESC');

        if ($parentId !== '*' && $parentId !== null) {
            $query->where('parent_categories.parent_id', $parentId);
        }

        $products = $query->limit(8)->get();

        $products->transform(function ($products) {
            $products->img_array = array_filter(explode(',', $products->img_array)); // Chuyển img_array thành mảng
            return $products;
        });

        if ($request->ajax()) {
            $html = '';
            foreach ($products as $product) {
                $html .= '
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"';
                if (isset($product->img_array[0])) {
                    $html .= ' data-setbg="' . asset('storage/uploads/products/' . $product->img_array[0]) . '"';
                } else {
                    $html .= ' data-setbg="' . asset('frontend/shop/img/featured/feature-1.jpg ') . '"';
                }
                $html .= '>
                            <ul class="featured__item__pic__hover">
                                <form action="' . route('shop.addProductTocart', $product->product_id) . '"
                                    method="POST" id="add-to-cart-form-' . $product->product_id . '" class="m-0">
                                    ' . csrf_field() . '
                                    <input type="text" name="quanlity" value="1" hidden>
                                    <button type="submit" class="btn-add-to-cart">
                                        <li><a href=""><i class="fa fa-shopping-cart mt-2"></i></a>
                                        </li>
                                    </button>
                                </form>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="' . route('shop.shop-details', $product->product_id) . '">' . $product->name . '</a></h6>
                            <h5>' . Number::currency($product->price, 'VND', 'vi') . '</h5>
                        </div>
                    </div>
                </div>';
            }
            return response()->json(['html' => $html]);
        }


        // Product sale limit 6
        $productSale = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->join('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->select('products.*', 'categories.name as nameCategory', 'sale_products.discount', DB::raw('MIN(img_products.img) as imgName')) // Lấy hình ảnh đầu tiên
            ->groupBy('products.product_id', 'categories.name', 'sale_products.discount', 'products.price', 'products.name')
            ->limit(6)
            ->get();
        $chunkedProductsSale = $productSale->chunk(3);

        // Product new
        $productNew = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->select('products.*', 'categories.name as nameCategory', 'sale_products.discount', DB::raw('MIN(img_products.img) as imgName'))
            ->groupBy('products.product_id', 'categories.name', 'sale_products.discount', 'products.price', 'products.name')
            ->orderBy('products.created_at', 'DESC')
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


    public function checkout()
    {
    }
    public function checkout()
    {
        return view('Shop.checkout');
    }
    public function contact()
    {
    public function contact()
    {
        return view('Shop.contact');
    }

    public function detail($id)
    {

        $productById = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.product_id', $id)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'sale_products.discount',
                'sale_products.time_start as dateStartSale',
                'sale_products.time_end as dateEndSale'
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
                'sale_products.discount',
                'sale_products.time_start',
                'sale_products.time_end'
            )
            ->first();

        if ($productById) {
            $productById->img_array = array_filter(explode(',', $productById->img_array));
        }


        $productByCategory = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('categories.category_id', $productById->category_id)
            ->select(
                'products.*',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'sale_products.discount',
                'sale_products.time_start as dateStartSale',
                'sale_products.time_end as dateEndSale'
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
                'sale_products.discount',
                'sale_products.time_start',
                'sale_products.time_end'
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
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->select('products.*', 'categories.name as nameCategory', 'sale_products.discount', DB::raw('MIN(img_products.img) as imgName'))
            ->groupBy('products.product_id', 'categories.name', 'sale_products.discount', 'products.price', 'products.name')
            ->orderBy('products.created_at', 'DESC')
            ->paginate(8);

        // Sale products
        $SelectProductWithsaleProduct
            =
            Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->join('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->join(
                'img_products',
                'img_products.product_id',
                '=',
                'products.product_id'
            )
            ->select(
                'products.*',
                'categories.name as nameCategory',
                'sale_products.discount',
                DB::raw('MIN(img_products.img) as imgNameSale')
            )
            ->groupBy('products.product_id', 'categories.name', 'sale_products.discount', 'products.price', 'products.name')
            ->limit(6)
            ->get();

        // Product new
        $productNew = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->join('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->select('products.*', 'categories.name as nameCategory', 'sale_products.discount', DB::raw('MIN(img_products.img) as imgName')) // Lấy hình ảnh đầu tiên
            ->groupBy('products.product_id', 'categories.name', 'sale_products.discount', 'products.price', 'products.name')
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

        $cartItems = CartProduct::join('products', 'products.product_id', '=', 'cart_products.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('cart_products.user_id', $user->user_id)
            ->select(
                'cart_products.*',
                'products.product_id',
                'products.name as productName',
                'products.price',
                'categories.name as nameCategory',
                DB::raw('GROUP_CONCAT(img_products.img) as img_array'),
                'sale_products.discount',
                'sale_products.time_start as dateStartSale',
                'sale_products.time_end as dateEndSale'
            )
            ->groupBy(
                'cart_products.cart_id',
                'cart_products.name',
                'cart_products.quantity',
                'cart_products.total_price',
                'cart_products.product_id',
                'cart_products.user_id',
                'products.product_id',
                'categories.category_id',
                'categories.name',
                'products.name',
                'products.price',
                'sale_products.discount',
                'sale_products.time_start',
                'sale_products.time_end'
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
        // dd($id);
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để truy cập giỏ hàng.');
        }

        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('shop.cart')->with('error', 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = CartProduct::where('user_id', $user->user_id)
            ->where('product_id', $product->product_id)
            ->first();

        $quanlity = $request->input('quanlity');
        if ($cartItem) {
            $cartItem->quantity += $quanlity;
            $cartItem->total_price = $cartItem->total_price + $product->price;
            $cartItem->save();
        } else { 
            CartProduct::create([
                'user_id' => $user->user_id,
                'product_id' => $product->product_id,
                'total_price' => $product->price,
                'quantity' => $quanlity,
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

        // Cập nhật số lượng cho sản phẩm
        if ($request->has('quantity')) {
            foreach ($request->quantity as $productId => $quantity) {
                $cartItem = CartProduct::where('user_id', $user->user_id)
                    ->where('cart_id', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity = $quantity;
                    $cartItem->total_price = $cartItem->quantity * $cartItem->productForeignKLey->price;
                    $cartItem->save();
                }
            }
        }

        // Xóa row cart
        if ($request->has('remove')) {
            foreach ($request->remove as $cartId => $removeItem) {
                $cartItem = CartProduct::where('user_id', $user->user_id)
                    ->where('cart_id', $cartId)
                    ->first();

                if ($cartItem) {
                    $cartItem->delete();
                }
            }
        }
        return redirect()->route('shop.cart')->with('success', 'Giỏ hàng đã được cập nhật.');
    }


    public function blog()
    {
        return view('Shop.blog');
    }
}
