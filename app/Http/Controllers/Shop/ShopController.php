<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Products\CartProduct;
use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShopController extends Controller
{
    public function index()
    {
        return view('Shop.index');
    }

    public function checkout()
    {
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
            ->where('products.product_id', $id)
            ->select(
                'products.*',
                'sale_products.discount',
                'sale_products.time_start as dateStartSale',
                'sale_products.time_end as dateEndSale'
            )
            ->first();

        $productByCategory = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('categories.category_id', $productById->category_id)
            ->select(
                'products.*',
                'img_products.img as imgProduct',
                'sale_products.discount',
                'sale_products.time_start as dateStartSale',
                'sale_products.time_end as dateEndSale'
            )
            ->limit(4)
            ->get();
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
        $prodcutsActive = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->where('products.status', 1)
            ->select(
                'products.*',
                'img_products.img as imgProduct',
                'sale_products.discount',
                'sale_products.time_start as dateStartSale',
                'sale_products.time_end as dateEndSale'
            )
            ->paginate(8);

        // Sale products
        $SelectProductWithsaleProduct
            = Product::join('sale_products', 'sale_products.product_id', '=', 'products.product_id')
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('img_products', 'img_products.product_id', '=', 'products.product_id')
            ->whereDate('sale_products.time_end', '>', NOW())
            ->select(
                'products.*',
                'img_products.img as imgProduct',
                'sale_products.discount',
                'sale_products.time_end as dateCreateSale',
                'categories.name as categoryName'
            )
            ->limit(6)
            ->get();

        // Count product
        $countProducts = count($prodcutsActive);
        return view('Shop.grid', [
            'categories' => $categories,
            'SelectProductWithsaleProduct' => $SelectProductWithsaleProduct,
            'countProducts' => $countProducts,
            'prodcutsActive' => $prodcutsActive,
        ]);
    }
    public function cart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để truy cập giỏ hàng.');
        }

        $cartItems = CartProduct::join('products', 'products.product_id', '=', 'cart_products.product_id')
            ->where('cart_products.user_id', $user->user_id)
            ->select('products.name as productName', 'products.price', 'cart_products.*')
            ->get();


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
