<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\Admin\Order\OrderRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Mail\OrdersPrepaidConfirmation;


class OrderController extends Controller
{

    public function index(Request $request)
    {

        $activeTab = $request->query('tab', 0);

        // Truy vấn danh sách đơn hàng chưa thanh toán (`status = 0`)
        $ordersUnpaidQuery = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'orders.treatment_id')
            ->join('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select(
                'orders.payment',
                'orders.row_id',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                DB::raw('GROUP_CONCAT(services.name SEPARATOR ", ") as service_names'),
                DB::raw('GROUP_CONCAT(services.price SEPARATOR ", ") as service_prices'),
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id'
            )->groupBy(
                'orders.payment',
                'orders.status',
                'orders.row_id',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id'
            )
            ->orderBy('orders.created_at', 'desc');;

        if ($request->filled('name')) {
            $ordersUnpaidQuery->where(function ($query) use ($request) {
                $query->where('patients.first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('patients.last_name', 'like', '%' . $request->name . '%')
                    ->orWhere(DB::raw("CONCAT(patients.first_name, ' ', patients.last_name)"), 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('code_order')) {
            $ordersUnpaidQuery->where('orders.order_id', 'like', '%' . $request->code_order . '%');
        }

        if ($request->filled('price_from')) {
            $ordersUnpaidQuery->where('orders.total_price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $ordersUnpaidQuery->where('orders.total_price', '<=', $request->price_to);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $ordersUnpaidQuery->whereBetween('orders.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $ordersUnpaidQuery->whereDate('orders.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $ordersUnpaidQuery->whereDate('orders.created_at', '<=', $request->date_to);
        }
        $ordersUnpaid = $ordersUnpaidQuery->where('orders.status', 0)->paginate(10)->appends($request->query());

        // status 1
        $ordersquery = Order::join('books', 'books.book_id', '=', 'orders.book_id')
            ->join('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->select(
                'orders.payment',
                'orders.row_id',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'books.day',
                'books.hour',
                'books.name',
                'books.phone',
                'books.email',
                'books.symptoms',
                'specialties.name as specialty',
                'users.firstname',
                'users.lastname'
            )
            ->orderBy('orders.created_at', 'desc');

        if ($request->filled('name')) {
            $ordersquery->where('books.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('code_order')) {
            $ordersquery->where('orders.order_id', 'like', '%' . $request->code_order . '%');
        }

        if ($request->filled('price_from')) {
            $multiplier = ($activeTab == 1) ? 0.3 : 0.7;
            $ordersquery->whereRaw('orders.total_price * ? >= ?', [$multiplier, $request->price_from]);
        }
        
        if ($request->filled('price_to')) {
            $multiplier = ($activeTab == 1) ? 0.3 : 0.7;
            $ordersquery->whereRaw('orders.total_price * ? <= ?', [$multiplier, $request->price_to]);
        }
            

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $ordersquery->whereBetween('orders.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $ordersquery->whereDate('orders.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $ordersquery->whereDate('orders.created_at', '<=', $request->date_to);
        }

        $ordersPrepaid = $ordersquery->clone()->where('orders.status', 1)->paginate(10)->appends($request->query());

        $ordersisPrepaid = $ordersquery->clone()->where('orders.status', 2)->paginate(10)->appends($request->query());


        // stauts 3
        $ordersPaidQuery = Order::leftJoin('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
            ->leftJoin('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->leftJoin('treatment_details', 'treatment_details.treatment_id', '=', 'orders.treatment_id')
            ->leftJoin('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->leftJoin('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->leftJoin('books', 'books.book_id', '=', 'orders.book_id')
            ->leftJoin('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->leftJoin('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->leftJoin('users', 'users.user_id', '=', 'schedules.user_id')
            ->select(
                'orders.payment',
                'orders.row_id',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'orders.total_amount',
                'books.day',
                'books.hour',
                'books.name',
                'books.phone',
                'books.email',
                'books.symptoms',
                'specialties.name as specialty',
                'users.firstname',
                'users.lastname',
                DB::raw('GROUP_CONCAT(services.name SEPARATOR ", ") as service_names'),
                DB::raw('GROUP_CONCAT(services.price SEPARATOR ", ") as service_prices'),
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id'
            )->groupBy(
                'orders.payment',
                'orders.status',
                'orders.row_id',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'orders.updated_at',
                'orders.total_amount',
                'books.day',
                'books.hour',
                'books.name',
                'books.phone',
                'books.email',
                'books.symptoms',
                'specialties.name',
                'users.firstname',
                'users.lastname',
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id'
            )
            ->orderBy('orders.created_at', 'desc');
        if ($request->filled('name')) {
            $ordersPaidQuery->where('patients.first_name', 'like', '%' . $request->name . '%')
                ->orWhere('patients.last_name', 'like', '%' . $request->name . '%')
                ->orWhere('books.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('code_order')) {
            $ordersPaidQuery->where('orders.order_id', 'like', '%' . $request->code_order . '%');
        }

        if ($request->filled('price_from')) {
            $ordersPaidQuery->where('orders.total_price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $ordersPaidQuery->where('orders.total_price', '<=', $request->price_to);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $ordersPaidQuery->whereBetween('orders.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $ordersPaidQuery->whereDate('orders.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $ordersPaidQuery->whereDate('orders.created_at', '<=', $request->date_to);
        }

        $ordersPaid = $ordersPaidQuery->where('orders.status', 3)->paginate(10)->appends($request->query());

       
        return view('System.order.index', [
            'ordersUnpaid' => $ordersUnpaid,
            'ordersisPrepaid' => $ordersisPrepaid,
            'ordersPaid' => $ordersPaid,
            'ordersPrepaid' => $ordersPrepaid,
            'activeTab' => $activeTab,
        ]);
    }

    public function delete($id)
    {
        $order = Order::where('order_id', $id)->first();
        $order->delete();
        return redirect()->route('system.order')->with('success', 'Xóa hóa đơn thành công.');
    }

    public function resetsearch()
    {

        return redirect()->route('system.order');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $orders = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'orders.treatment_id')
            ->join('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->join('users', 'users.phone', '=', 'patients.phone')
            ->where('orders.order_id', $id)
            ->select(
                'orders.payment',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.cashier',
                'orders.created_at',
                DB::raw('GROUP_CONCAT(services.name SEPARATOR "|") as service_names'),
                DB::raw('GROUP_CONCAT(services.price SEPARATOR "|") as service_prices'),
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id',
                'users.email'
            )
            ->groupBy(
                'orders.payment',
                'orders.status',
                'orders.cashier',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id',
                'users.email'
            )
            ->first();

        // Kiểm tra nếu là yêu cầu AJAX, trả về JSON
        if (request()->ajax()) {
            if ($orders) {
                return response()->json([
                    'success' => true,
                    'data' => $orders,
                    'user' => [
                        'first_name' => $user->firstname,
                        'last_name' => $user->lastname,
                    ],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng.'
                ]);
            }
        }

        // Nếu không phải AJAX, trả về view
        return view('System.order.edit', ['orders' => $orders]);
    }

    public function print_order($id)
    {

        $orders = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'orders.treatment_id')
            ->join('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->where('orders.order_id', $id)
            ->select(
                'orders.payment',
                'orders.payment',
                'orders.cashier',
                'orders.change_amount',
                'orders.cash_received',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                
                DB::raw('GROUP_CONCAT(services.name SEPARATOR "|") as service_names'), // Dùng dấu "|" để phân tách
                DB::raw('GROUP_CONCAT(services.price SEPARATOR "|") as service_prices'),
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id'

            )
            ->groupBy(
                'orders.payment',
                'orders.cashier',
                'orders.change_amount',
                'orders.cash_received',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'medical_records.medical_id',
                'treatment_details.treatment_id',
                'patients.first_name',
                'patients.last_name',
                'patients.gender',
                'patients.birthday',
                'patients.patient_id'
            )
            ->orderBy('orders.created_at', 'desc')
            ->first();

        $pdf = Pdf::loadView('System.order.pdforder', ['orders' => $orders]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('order_invoice_' . $orders->order_id . '.pdf');
    }

    public function print_orderOnline($id)
    {
        $orders = Order::join('books', 'books.book_id', '=', 'orders.book_id')
            ->join('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->select(
                'orders.payment',
                'orders.row_id',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'books.day',
                'books.hour',
                'books.name AS book_name',
                'books.phone AS book_phone',
                'books.email AS book_email',
                'books.symptoms AS book_symptoms',
                'specialties.name AS specialty',
                'users.firstname AS user_firstname',
                'users.lastname AS user_lastname'
            )
            ->where('orders.order_id', $id)
            ->orderByDesc('orders.created_at')
            ->first();

        $pdf = Pdf::loadView('System.order.pdforderonline', ['orders' => $orders]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('order_invoice_' . $orders->order_id . '.pdf');
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Chỉ sử dụng khi kiểm thử để bỏ qua chứng chỉ SSL

        $result = curl_exec($ch);

        // if ($result === false) {
        //     // Ghi lại lỗi từ cURL và trả về false
        //     $error = curl_error($ch);
        //     Log::error("cURL Error: " . $error);
        //     curl_close($ch);
        //     return false;
        // }

        curl_close($ch);
        return $result;
    }


    public function handlepay(OrderRequest $request)
    {
        $payment = $request->input('payment_method');
        $id = $request->input('order_id');
        $cash_received = $request->input('cash_received');
        $change_amount = $request->input('change_amount');
        $cashier_name = $request->input('cashier_name');
        $total_amount = $request->input('total_amount');

        if ($payment == 0) {
            $order = Order::where('order_id', $id)->firstOrFail();

            $order->update([
                'cashier' => $cashier_name,
                'change_amount' => $change_amount,
                'cash_received' => $cash_received,
                'status' => 3,
                'payment' => $payment,
                'total_amount' => $total_amount
            ]);

            // Tạo URL PDF cho hóa đơn
            $pdfUrl = route('system.order.print', ['id' => $id]);

            return response()->json([
                'success' => true,
                'pdf_url' => $pdfUrl,
            ]);
        } elseif ($payment == 1) { // Thanh toán qua MoMo
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderInfo = "Thanh toán qua MoMo";
            $amount = $total_amount; // Chuyển đổi số tiền
            $ID = $id;
            $orderId = time() . ""; // Unique Order ID
            $redirectUrl = route('system.momo.callback');
            $ipnUrl = route('system.order');

            $extraData = json_encode([
                'cashier_name' => $cashier_name,
                'ID' => $ID,
            ]);

            $requestId = time() . "";
            $requestType = "payWithATM";

            // Tạo chữ ký
            $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                'storeId' => "MomoTestStore",
                'requestType' => $requestType,
                'requestId' => $requestId,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'amount' => $amount,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'signature' => $signature,

            ];

            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);

            if ($jsonResult['resultCode'] === 0 && isset($jsonResult['payUrl'])) {
                return response()->json([
                    'success' => true,
                    'payUrl' => $jsonResult['payUrl'],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $jsonResult['message'] ?? 'Không thể tạo liên kết thanh toán.',
                ]);
            }
        }
        elseif ($payment == 2) {
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('system.vnpay.callback') . '?cashier_name=' . urlencode($cashier_name);;
            $vnp_TmnCode = "ZAZD6H5N"; // Mã website tại VNPAY 
            $vnp_HashSecret = "VG6VICU7L6V62EHHPKMPR7UG45FBK918"; // Chuỗi bí mật
        
            $vnp_TxnRef = $id;
            $vnp_OrderInfo = 'Thanh toán hóa đơn';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $total_amount * 100; // VNPAY yêu cầu số tiền phải nhân với 100
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB'; // Ví dụ ngân hàng
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
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
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
        
            // Trả về URL thanh toán VNPAY dưới dạng JSON
            return response()->json([
                'success' => true,
                'payUrl' => $vnp_Url
            ]);
        }           
    }
    public function handleCallback(Request $request)
    {
        // Lấy dữ liệu từ query string

        $amount = $request->input('amount');
        $message = $request->input('message');
        $extraData = $request->input('extraData');

        $extraDataDecoded = json_decode($extraData, true); // Chuyển JSON thành mảng PHP

        $cashierName = $extraDataDecoded['cashier_name'] ?? null;
        $orderID = $extraDataDecoded['ID'] ?? null;
        $order = Order::where('order_id', $orderID)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại.',
            ], 404);
        }

        if ($message === 'Successful.') {

            $order->update([
                'cashier' => $cashierName,
                'status' => 3,
                'payment' => 1,
                'total_amount' => $amount,

            ]);
            return redirect()->route('system.order')->with('success', 'Thanh toán hóa đơn thành công');
        }

    }

    public function handlecallbackVnpay(Request $request){
        
        $vnp_ResponseCode = $request->input('vnp_TransactionStatus');

        $order_id = $request->input('vnp_TxnRef');

        $cashier = $request->input('cashier_name');

        $price = $request->input('vnp_Amount');

        $total_amount = $price / 100;

        $order = Order::where('order_id', $order_id)->first();

        $formatted_data = str_replace('+', ' ', $cashier);

        if($vnp_ResponseCode == '00'){

           $order->update([
                'cashier' => $formatted_data,
                'status' => 3,
                'payment' => 2,
                'total_amount' => $total_amount 
           ]);
           return redirect()->route('system.order')->with('success', 'Thanh toán hóa đơn thành công');
        }
        return redirect()->route('system.order');
    }

    public function updateStatus($id)
    {
        $user = Auth::user();

        $orders = Order::join('books', 'books.book_id', '=', 'orders.book_id')
            ->join('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->join('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->select(
                'orders.payment',
                'orders.row_id',
                'orders.status',
                'orders.total_price',
                'orders.order_id',
                'orders.created_at',
                'books.day',
                'books.hour',
                'books.name',
                'books.phone',
                'books.email',
                'books.symptoms',
                'books.url',
                'specialties.name as specialty',
                'users.firstname',
                'users.lastname'
            )
            ->where('orders.order_id', $id)
            ->whereIn('orders.status', [1, 2])
            ->firstOrFail();

        if (!$orders) {
            return redirect()->route('system.order')->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Lưu thông tin người thu ngân
        $cashier = $user->firstname . ' ' . $user->lastname;

        // Kiểm tra trạng thái đơn hàng và cập nhật
        switch ($orders->status) {
            case 1:
                // Từ trạng thái "Đã trả trước" (1) chuyển sang "Đã xác nhận" (2)
                $orders->update([
                    'status' => 2,
                    'cashier' => $cashier,
                    'total_amount' => $orders->total_price,
                ]);
                // Mail::to($orders->email)->send(new OrdersPrepaidConfirmation($orders));
                return redirect()->route('system.order')->with('success', 'Đã xác nhận đơn hàng');

            case 2:
                // Từ trạng thái "Đã xác nhận" (2) chuyển sang "Đã hoàn tất" (3)
                $orders->update([
                    'status' => 3,
                    'cashier' => $cashier,
                    'total_amount' => $orders->total_price,
                ]);
                // Mail::to($orders->email)->send(new OrderConfirmation($orders));
                return redirect()->route('system.order')->with('success', 'Đã hoàn tất đơn hàng');

            default:
                return redirect()->route('system.order')->with('error', 'Trạng thái đơn hàng không hợp lệ.');
        }
    }
}