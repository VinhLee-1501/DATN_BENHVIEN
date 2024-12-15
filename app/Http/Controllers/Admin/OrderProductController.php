<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderProductConfirmation;
use App\Models\Order;
use App\Models\Products\CartDetail;
use App\Models\Products\CartProduct;
use App\Models\Products\OrderProduct;
use App\Models\Products\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\select;

class OrderProductController extends Controller
{
    public function index(Request $request)
    {

        $activeTab = $request->query('tab', 0);

        $ordersquery = OrderProduct::select(
            'order_products.order_id',
            'order_products.order_phone',
            'order_products.order_username',
            'order_products.created_at',
            DB::raw('SUM(order_products.quantity) as total_quantity'),
            'order_products.price_old',
            'order_products.price_sale',
            'order_products.order_status',
            'order_products.order_address',
            'coupons.percent',
            DB::raw('GROUP_CONCAT(cart_details.product_id) as product_ids'),
            DB::raw('GROUP_CONCAT(products.name SEPARATOR ";") as product_names'),
            DB::raw('GROUP_CONCAT(products.price) AS product_prices'),
            'payment_products.payment_method',
            'users.email',
        )
            ->leftjoin('cart_details', 'order_products.cart_id', '=', 'cart_details.cart_id')
            ->leftjoin('products', 'cart_details.product_id', '=', 'products.product_id')
            ->leftjoin('payment_products', 'order_products.order_id', '=', 'payment_products.order_id')
            ->leftjoin('users', 'order_products.user_id', '=', 'users.user_id')
            ->leftjoin('coupons', 'order_products.coupon_id', '=', 'order_products.coupon_id')
            ->groupBy(
                'order_products.order_id',
                'order_products.order_phone',
                'order_products.price_old',
                'order_products.price_sale',
                'order_products.order_status',
                'order_products.order_address',
                'payment_products.payment_method',
                'order_products.created_at',
                'users.email',
                'order_products.order_username',
                'coupons.percent',
            )->orderBy('order_products.created_at', 'desc');

        if ($request->filled('name')) {
            $ordersquery->where('order_products.order_username', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('code_order')) {
            $ordersquery->where('order_products.order_id', 'like', '%' . $request->code_order . '%');
        }

        if ($request->filled('price_from')) {
            $ordersquery->where(function ($query) use ($request) {
                $query->where('order_products.price_old', '>=', $request->price_from)
                    ->orWhere(function ($query) use ($request) {
                        $query->whereNull('order_products.price_old')
                            ->where('order_products.price_sale', '>=', $request->price_from);
                    });
            });
        }

        if ($request->filled('price_to')) {
            $ordersquery->where(function ($query) use ($request) {
                $query->where('order_products.price_old', '<=', $request->price_to)
                    ->orWhere(function ($query) use ($request) {
                        $query->whereNull('order_products.price_old')
                            ->where('order_products.price_sale', '<=', $request->price_to);
                    });
            });
        }


        if ($request->filled('date_from') && $request->filled('date_to')) {
            $ordersquery->whereBetween('order_products.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $ordersquery->whereDate('order_products.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $ordersquery->whereDate('order_products.created_at', '<=', $request->date_to);
        }

        $ordersPendings = $ordersquery->clone()->where('order_products.order_status', 0)->paginate(10)->appends($request->query());

        $ordersShippings = $ordersquery->clone()->where('order_products.order_status', 1)->paginate(10)->appends($request->query());

        $ordersCompleteds = $ordersquery->clone()->where('order_products.order_status', 2)->paginate(10)->appends($request->query());
        // dd($ordersPendings);
        return view('System.orderproduct.index', [
            'ordersPendings' => $ordersPendings,
            'ordersShippings' => $ordersShippings,
            'ordersCompleteds' => $ordersCompleteds,
            'activeTab' => $activeTab,
        ]);
    }

    public function resetsearch()
    {

        return redirect()->route('system.orderproduct');
    }

    public function updateStatus($id)
    {
        $orderProduct  = OrderProduct::select(
            'order_products.order_id',
            'order_products.order_username',
            'order_products.created_at',
            DB::raw('GROUP_CONCAT(order_products.quantity) as total_quantity'),
            'order_products.price_old',
            'order_products.price_sale',
            'order_products.order_status',
            'order_products.order_address',
            'order_products.order_phone',
            DB::raw('GROUP_CONCAT(cart_details.product_id) as product_ids'),
            DB::raw('GROUP_CONCAT(products.name SEPARATOR ";") as product_names'),
            DB::raw('GROUP_CONCAT(products.price) AS product_prices'),
            'payment_products.payment_method',
            'users.email',
        )
            ->leftjoin('cart_details', 'order_products.cart_id', '=', 'cart_details.cart_id')
            ->leftjoin('products', 'cart_details.product_id', '=', 'products.product_id')
            ->leftjoin('payment_products', 'order_products.order_id', '=', 'payment_products.order_id')
            ->leftjoin('users', 'order_products.user_id', '=', 'users.user_id')
            ->where('order_products.order_id', $id)
            ->groupBy(
                'order_products.order_id',
                'order_products.order_phone',
                'order_products.price_old',
                'order_products.price_sale',
                'order_products.order_status',
                'order_products.order_address',
                'order_products.order_username',
                'order_products.order_phone',
                'order_products.order_address',
                'order_products.note',
                'order_products.cart_id',
                'order_products.product_id',
                'order_products.coupon_id',
                'order_products.user_id',
                'order_products.deleted_at',
                'order_products.updated_at',
                'payment_products.payment_method',
                'order_products.created_at',
                'users.email',
            )
            ->first();

        $order = OrderProduct::where('order_id', $id)->first();
        $cart_id = $order->cart_id;

        $cart = CartDetail::withTrashed()
        ->where('cart_id', $cart_id)
        ->whereNotNull('cart_details.deleted_at')
        ->get();

        foreach($cart as $item){
            $product_id = $item->product_id;
            $quantitycart = $item->quantity;
            $product = Product::where('product_id', $product_id)->first();
            $quantity = $product->quantity - $quantitycart;
            $product->quantity = $quantity;
            $product->update();
            
        }


        if ($orderProduct->order_status == '0') {
            $orderProduct->order_status = 1;
            $orderProduct->save();
            Mail::to($orderProduct->email)->send(new OrderProductConfirmation($orderProduct));

            return redirect()->route('system.orderproduct')->with('success', 'Xác nhân đơn hàng.');
        } elseif ($orderProduct->order_status == 1) {
            $orderProduct->order_status = 2;
            $orderProduct->save();
        }

        return redirect()->route('system.orderproduct')->with('success', 'Xác nhân đơn hàng.');
    }

    public function delete($id)
    {
        $orderProduct = OrderProduct::where('order_id', $id)->first();
        $orderProduct->delete();
        return redirect()->route('system.orderproduct')->with('success', 'Hủy đơn hàng thành công.');
    }
}