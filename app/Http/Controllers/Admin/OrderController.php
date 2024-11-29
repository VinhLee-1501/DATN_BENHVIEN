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
        $search = $request->input('search', '');

        $tab = $request->input('tab');

        $delete = $request->input('order_id', []);

        if (!empty($delete)) {
            Order::whereIn('order_id', $delete)->delete();
            return redirect()->route('system.order')->with('success', 'Đã xóa các đơn hàng được chọn.');
        }

        $itemsPerPage = $request->input('itemsPerPage', 5);

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
            )
            ->where('orders.status', '=', '0');

        // Nếu có từ khóa tìm kiếm, thêm vào điều kiện tìm kiếm cho danh sách đơn hàng chưa thanh toán
        if ($search && $tab === '0') {
            $ordersUnpaidQuery->where('orders.order_id', 'LIKE', "%$search%");
        }

        // Lấy kết quả phân trang cho danh sách đơn hàng chưa thanh toán
        $ordersUnpaid = $ordersUnpaidQuery->groupBy(
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
        )->orderBy('orders.created_at', 'desc')->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
        ]);

        // Truy vấn danh sách đơn hàng đã thanh toán (`status = 1`)
        $ordersPaidQuery = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
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
            )
            ->where('orders.status', '=', '2');

        // Nếu có từ khóa tìm kiếm, thêm vào điều kiện tìm kiếm cho danh sách đơn hàng đã thanh toán
        if ($search && $tab === '2') {
            $ordersPaidQuery->where('orders.order_id', 'LIKE', "%$search%");
        }

        // Lấy kết quả phân trang cho danh sách đơn hàng đã thanh toán
        $ordersPaid = $ordersPaidQuery->groupBy(
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
        )->orderBy('orders.created_at', 'desc')->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
        ]);

        $ordersPerpaiddQuery = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
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
            )
            ->where('orders.status', '=', '1');

        // Nếu có từ khóa tìm kiếm, thêm vào điều kiện tìm kiếm cho danh sách đơn hàng đã thanh toán
        if ($search && $tab === '2') {
            $$ordersPerpaiddQuery->where('orders.order_id', 'LIKE', "%$search%");
        }

        // Lấy kết quả phân trang cho danh sách đơn hàng đã thanh toán
        $ordersPrepaid  = $ordersPerpaiddQuery->groupBy(
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
        )->orderBy('orders.created_at', 'desc')->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
        ]);

        // Trả về view với các biến khác nhau
        return view('System.order.index', [
            'ordersUnpaid' => $ordersUnpaid,
            'ordersPaid' => $ordersPaid,
            'ordersPrepaid' => $ordersPrepaid,
            'search' => $search,
            'itemsPerPage' => $itemsPerPage,
            'tab' => $tab
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
            ->orderBy('orders.created_at', 'desc')
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
            ->where('orders.row_id', $id)
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
        $cash_receiveds = $cash_received / 1000;
        $change_amount = $request->input('change_amount');
        $change_amounts = $change_amount / 1000;
        $cashier_name = $request->input('cashier_name');
        $total_amount = $request->input('total_amount');
       

        if ($payment == 0) {
            $order = Order::where('row_id', $id)->firstOrFail();

            $order->update([
                'cashier' => $cashier_name,
                'change_amount' => $change_amounts,
                'cash_received' => $cash_receiveds,
                'status' => 2,
                'payment' => $payment,
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
            $amount = $total_amount * 1000; // Chuyển đổi số tiền
            $ID = $id;
            $orderId = time() . ""; // Unique Order ID
            $redirectUrl = route('system.momo.callback');
            $ipnUrl = 'http://127.0.0.1:8000/system/order';

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
    }
    public function handleCallback(Request $request)
    {
        // Lấy dữ liệu từ query string

        $amount = $request->input('amount');

        $total_amount = $amount / 1000;

        $extraData = $request->input('extraData');

        // Giải mã extraData
        $extraDataDecoded = json_decode($extraData, true); // Chuyển JSON thành mảng PHP

        // Lấy các giá trị từ extraData
        $cashierName = $extraDataDecoded['cashier_name'] ?? null;
        $orderID = $extraDataDecoded['ID'] ?? null;

        // Kiểm tra và cập nhật trạng thái đơn hàng
        $order = Order::where('order_id', $orderID)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại.',
            ], 404);
        }

        $order->update([
            'cashier' => $cashierName,
            'status' => 2,
            'payment' => 1,
            'total_amount' => $total_amount,

        ]);

        return redirect()->route('system.order')->with('susses', 'Thanh toán hóa đơn thành công');
    }

    public function updateStatus($id)
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
            ->orderBy('orders.created_at', 'desc')
            ->first();
            $orderupdate = Order::where('order_id', $id)->first();
        if ($orders->status == 0) {
            $orderupdate->update(['status' => 1,  'cashier' => $user->firstname . ' ' . $user->lastname]);

            Mail::to($orders->email)->send(new OrdersPrepaidConfirmation($orders));

            return redirect()->route('system.order')->with('success', 'Đã xác nhận đơn hàng');
        } elseif ($orders->status == 1) {
            $orderupdate->update(['status' => 2,  'cashier' => $user->firstname . ' ' . $user->lastname]);
          
            Mail::to($orders->email)->send(new OrderConfirmation($orders));

            return redirect()->route('system.order')->with('success', 'Đã xác nhận đơn hàng');
        }
    }
}
