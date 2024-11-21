<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Products\CartDetail;
use App\Models\Products\CartProduct;
use App\Models\Products\OrderProduct;
use App\Models\Products\PaymentProduct;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{

    public function bill()
    {
        $user = Auth::user();
        $user_id = $user->user_id;
        $order = OrderProduct::join('payment_products', 'payment_products.order_id', '=', 'order_products.order_id')
            ->join('users', 'users.user_id', '=', 'order_products.user_id')
            ->where('users.user_id', $user_id)
            ->whereNull('order_products.deleted_at')
            ->orderBy('order_products.created_at', 'desc')
            ->first();
        if ($order) {
            $cart_id = $order->cart_id;
            $product = Product::join('cart_details', 'cart_details.product_id', '=', 'products.product_id')
                ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
                ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
                ->join('cart_products', 'cart_products.cart_id', 'cart_details.cart_id')
                ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
                ->where('cart_products.cart_id', $cart_id)
                ->select(
                    'cart_products.*',
                    'cart_details.*',
                    'products.*',
                    'coupons.discount_code',
                    'coupons.percent',
                    'coupons.time_start as dateStartSale',
                    'coupons.time_end as dateEndSale',
                    DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(img_products.img ORDER BY img_products.img SEPARATOR ","), ",", 1) as img_first')
                )
                ->groupBy(
                    'cart_products.cart_id',
                    'products.product_id',
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
                    'cart_details.cart_detail_id',
                    'coupons.discount_code',
                    'coupons.percent',
                    'coupons.time_start',
                    'coupons.time_end'
                )
                ->get();



            $order_user = OrderProduct::join('payment_products', 'payment_products.order_id', '=', 'order_products.order_id')
                ->join('cart_products', 'cart_products.cart_id', '=', 'order_products.cart_id')
                ->join('cart_details', 'cart_details.cart_id', '=', 'cart_products.cart_id')
                ->join('products', 'products.product_id', '=', 'cart_details.product_id')
                ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
                ->where('order_products.user_id', $user_id)
                ->whereNull('order_products.deleted_at')
                ->select(
                    'order_products.*',
                    'payment_products.payment_method',
                    'payment_products.payment_status',
                    'payment_products.payment_id',
                    'cart_products.cart_id',
                    DB::raw('GROUP_CONCAT(DISTINCT products.product_id ORDER BY products.product_id SEPARATOR ",") as product_ids')
                )
                ->groupBy('order_products.order_id', 'cart_products.cart_id', 'payment_products.payment_id', 'payment_products.payment_method', 'payment_products.payment_status',)
                ->get();
        } else {
            $product = [];
            $order_user = [];
        }

        return view('Shop.order', ['order' => $order, 'product' => $product, 'order_user' => $order_user]);
    }



    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function handleMomoPaymentResponse(Request $request)
    {
        // Lấy thông tin phản hồi từ MoMo
        $resultCode = $request->query('resultCode'); // Mã kết quả (0 = thành công)

        $orderId = OrderProduct::latest()->pluck('order_id')->first();
        if ($resultCode == 0) {

            $payment = new PaymentProduct();
            $payment->payment_method = 2; // MoMo
            $payment->payment_status = 1; // Thành công
            $payment->order_id = $orderId; // Thành công
            $payment->save();

            return redirect()->route('shop.bill')->with('message', 'Thanh toán thành công!');
        } else {
            $payment = new PaymentProduct();
            $payment->payment_method = 2; // MoMo
            $payment->payment_status = 2; // Thất bại
            $payment->order_id = $orderId; // Thành công
            $payment->save();

            return redirect()->route('shop.bill')->with('message', 'Thanh toán không thành công!');
        }
    }



    public function handlePaymentReturn(Request $request)
    {

        // dd(query('vnp_ResponseCode'));
        $vnp_ResponseCode = $request->query('vnp_ResponseCode');
        $vnp_TransactionStatus = $request->query('vnp_TransactionStatus');
        $vnp_TxnRef = $request->query('vnp_TxnRef');

        $order_id = OrderProduct::latest()->pluck('order_id')->first();
        // dd($vnp_ResponseCode, $vnp_TransactionStatus);

        if ($vnp_ResponseCode == '00') {
            $payment = new PaymentProduct();
            $payment->txn_ref = $vnp_TxnRef;
            $payment->order_id = $order_id;
            $payment->payment_method = 1;
            $payment->payment_status = 1;
            $payment->save();
            return redirect()->route('shop.bill')->with('message', 'Thanh toán thành công!');
        } else {
            $payment = new PaymentProduct();
            $payment->txn_ref = $vnp_TxnRef;
            $payment->order_id = $order_id;
            $payment->payment_method = 1;
            $payment->payment_status = 2;
            $payment->save();

            return redirect()->route('shop.bill')->with('message', 'Thanh toán không thành công!');
        }
    }


    public function order(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->user_id;
        $order = new OrderProduct();
        $order->quantity = $request->input('quantity');
        $order->price_old = $request->input('total');
        $order->price_sale = $request->input('total_final');
        $order->order_status = $request->input('coupon_id');;
        $order->order_status = 0;
        $order->order_username = $request->input('first_name') . ' ' . $request->input('last_name');
        $order->order_phone = $request->input('phone');
        $order->order_address = $request->input('address') . ', ' . $request->input('ward_name') . ', ' . $request->input('district_name') . ', ' . $request->input('province_name');
        $order->note = $request->input('note');
        $order->cart_id  = $request->input('cart_id');
        $order->user_id   = $user_id;
        $order->save();

        $cart_id = $order->cart_id;
        CartDetail::where('cart_id', $cart_id)->delete();
        CartProduct::where('cart_id', $cart_id)->delete();

        $price = $request->input("total_final");
        $code = rand(00, 99999);
        if ($request->input('payment_option') == 'vnpay') {
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://127.0.0.1:8000/cua-hang/hoa-don";
            $vnp_TmnCode = "ZAZD6H5N"; //Mã website tại VNPAY 
            $vnp_HashSecret = "VG6VICU7L6V62EHHPKMPR7UG45FBK918"; //Chuỗi bí mật

            $vnp_TxnRef = $code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = 'Thanh toán hóa đơn';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $price * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            $payment_status = 0;

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "payment_status" => $payment_status,

            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                if ($order) {
                    $this->handlePaymentReturn($request);
                } else {
                    dd('Lưu đơn hàng không thành công');
                }
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
        } elseif ($request->input('payment_option') === 'momo') {

            // Cấu hình thông tin gửi yêu cầu thanh toán
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderInfo = "Thanh toán qua MoMo";
            $amount = $price;
            $orderId = time() . "";
            $redirectUrl = "http://127.0.0.1:8000/cua-hang/payment/momo/return";
            $ipnUrl = "http://127.0.0.1:8000/cua-hang/hoa-don";
            $extraData = "";
            $requestId = time() . "";
            $requestType = "payWithATM";

            // Tạo rawHash và signature
            $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                'storeId' => "MomoTestStore",
                'requestType' => $requestType,
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'signature' => $signature
            ];

            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);

            return redirect()->to($jsonResult['payUrl']);
        } elseif ($request->input('payment_option') === 'cash') {
            $order_id = OrderProduct::latest()->pluck('order_id')->first();
            $payment = new PaymentProduct();
            $payment->order_id = $order_id;
            $payment->payment_method = 0;
            $payment->payment_status = 0;
            $payment->save();



            return redirect()->route('shop.bill')->with('success', 'Đặt hàng thành công');
        }
    }
}