<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderProductConfirmation;
use App\Models\Products\OrderProduct;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class OrderProductController extends Controller
{
    public function index(Request $request) {

        $search = $request->input('search','');

        $itemsPerPage = $request->input('itemsPerPage', 5);

        $tab = $request->input('tab');
        
        $ordersPending  = OrderProduct::select(
            'order_products.order_id',
            'order_products.order_username',
            'order_products.created_at',
            DB::raw('SUM(order_products.quantity) as total_quantity'),
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
        ->join('cart_details', 'order_products.cart_id', '=', 'cart_details.cart_id')
        ->join('products', 'cart_details.product_id', '=', 'products.product_id')
        ->join('payment_products', 'order_products.order_id', '=', 'payment_products.order_id')
        ->join('users', 'order_products.user_id', '=', 'users.user_id')
        ->where('order_products.order_status', 0);  

        if ($search && $tab == 0) {
            $ordersPending ->where('order_products.order_id', 'LIKE', '%'. $search. '%');
        }

        $ordersPendings = $ordersPending->groupBy(
            'order_products.order_id',
            'order_products.order_phone',
            'order_products.price_old',
            'order_products.price_sale',
            'order_products.order_status',
            'order_products.order_address',
            'payment_products.payment_method',
            'order_products.created_at',
            'users.email',
        )->orderBy('order_products.created_at', 'desc')->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
        ]);


        $ordersShipping   = OrderProduct::select(
            'order_products.order_id',
            'order_products.order_phone',
            'order_products.order_username',
            'order_products.created_at',
            DB::raw('SUM(order_products.quantity) as total_quantity'),
            'order_products.price_old',
            'order_products.price_sale',
            'order_products.order_status',
            'order_products.order_address',
            DB::raw('GROUP_CONCAT(cart_details.product_id) as product_ids'),
            DB::raw('GROUP_CONCAT(products.name SEPARATOR ";") as product_names'),
            DB::raw('GROUP_CONCAT(products.price) AS product_prices'),
            'payment_products.payment_method',
            'users.email',
        )
        ->join('cart_details', 'order_products.cart_id', '=', 'cart_details.cart_id')
        ->join('products', 'cart_details.product_id', '=', 'products.product_id')
        ->join('payment_products', 'order_products.order_id', '=', 'payment_products.order_id')
        ->join('users', 'order_products.user_id', '=', 'users.user_id')
        ->where('order_products.order_status', 1);  

        if ($search && $tab == 1) {
            $ordersShipping  ->where('order_products.order_id', 'LIKE', '%'. $search. '%');
        }

        $ordersShippings = $ordersShipping ->groupBy(
            'order_products.order_id',
            'order_products.order_phone',
            'order_products.price_old',
            'order_products.price_sale',
            'order_products.order_status',
            'order_products.order_address',
            'payment_products.payment_method',
            'order_products.created_at',
            'users.email',
        )->orderBy('order_products.created_at', 'desc')->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
        ]);

        $ordersCompleted = OrderProduct::select(
            'order_products.order_id',
            'order_products.order_phone',
            'order_products.order_username',
            'order_products.created_at',
            DB::raw('SUM(order_products.quantity) as total_quantity'),
            'order_products.price_old',
            'order_products.price_sale',
            'order_products.order_status',
            'order_products.order_address',
            DB::raw('GROUP_CONCAT(cart_details.product_id) as product_ids'),
            DB::raw('GROUP_CONCAT(products.name SEPARATOR ";") as product_names'),
            DB::raw('GROUP_CONCAT(products.price) AS product_prices'),
            'payment_products.payment_method',
            'users.email',
        )
        ->join('cart_details', 'order_products.cart_id', '=', 'cart_details.cart_id')
        ->join('products', 'cart_details.product_id', '=', 'products.product_id')
        ->join('payment_products', 'order_products.order_id', '=', 'payment_products.order_id')
        ->join('users', 'order_products.user_id', '=', 'users.user_id')
        ->where('order_products.order_status', 2);  

        if ($search && $tab == 2) {
            $ordersCompleted->where('order_products.order_id', 'LIKE', '%'. $search. '%');
        }

        $ordersCompleteds = $ordersCompleted  ->groupBy(
            'order_products.order_id',
            'order_products.order_phone',
            'order_products.price_old',
            'order_products.price_sale',
            'order_products.order_status',
            'order_products.order_address',
            'payment_products.payment_method',
            'order_products.created_at',
            'users.email',
        )->orderBy('order_products.created_at', 'desc')->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
        ]);
     
        return view('System.orderproduct.index', [
            'ordersPendings' => $ordersPendings,
            'ordersShippings' => $ordersShippings,
            'ordersCompleteds' => $ordersCompleteds,
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
        ]);
    }

    public function resetsearch()
    {

        return redirect()->route('system.orderproduct');
    }

    public function updateStatus($id){
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
        ->join('cart_details', 'order_products.cart_id', '=', 'cart_details.cart_id')
        ->join('products', 'cart_details.product_id', '=', 'products.product_id')
        ->join('payment_products', 'order_products.order_id', '=', 'payment_products.order_id')
        ->join('users', 'order_products.user_id', '=', 'users.user_id')
        ->where('order_products.order_id', $id)
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
        )
        ->first();
        // dd($orderProduct);
        if($orderProduct->order_status == 0){
            $orderProduct->order_status = 1;
            $orderProduct->save();
            Mail::to($orderProduct->email)->send(new OrderProductConfirmation($orderProduct));
            return redirect()->route('system.orderproduct')->with('success', 'Xác nhân đơn hàng.');
        }elseif($orderProduct->order_status == 1){
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