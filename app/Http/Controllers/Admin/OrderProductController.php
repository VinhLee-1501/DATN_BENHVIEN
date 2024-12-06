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
            )->orderBy('order_products.created_at', 'desc');

        if ($request->filled('name')) {
            $ordersquery->
               where('order_products.order_username', 'like', '%' . $request->name . '%');
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
                'payment_products.payment_method',
                'order_products.created_at',
                'users.email',
            )
            ->first();
        // dd($orderProduct);
        if ($orderProduct->order_status == 0) {
            $orderProduct->order_status == 1;
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
