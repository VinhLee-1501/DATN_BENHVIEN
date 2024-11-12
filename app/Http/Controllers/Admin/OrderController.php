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

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsPerPage', 5);

        $query = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'orders.treatment_id')
            ->join('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select(
                'orders.role',
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

        // Thêm điều kiện tìm kiếm vào truy vấn nếu có
        if ($search) {
            $query->where('orders.order_id', 'LIKE', "%$search%");
        }

        // Thực hiện truy vấn với groupBy và orderBy, sau đó phân trang với append
        $orders = $query->groupBy(
            'orders.role',
            'orders.row_id',
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
        )->orderBy('orders.created_at', 'desc')
            ->paginate($itemsPerPage)
            ->appends(['search' => $search]); // Đảm bảo giữ lại tham số search trong phân trang

        // Trả về view với biến `orders`
        return view('System.order.index', [
            'orders' => $orders,
            'search' => $search
        ]);
    }

    public function indexUn(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsPerPage', 5);

        $query = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'orders.treatment_id')
            ->join('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select(
                'orders.role',
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

        // Thêm điều kiện tìm kiếm vào truy vấn nếu có
        if ($search) {
            $query->where('orders.order_id', 'LIKE', "%$search%");
        }

        // Thực hiện truy vấn với groupBy và orderBy, sau đó phân trang với append
        $orders = $query->groupBy(
            'orders.role',
            'orders.row_id',
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
        )->orderBy('orders.created_at', 'desc')
            ->paginate($itemsPerPage)
            ->appends(['search' => $search]); // Đảm bảo giữ lại tham số search trong phân trang

        // Trả về view với biến `orders`
        return view('System.order.index', [
            'ordersun' => $orders,
            'search' => $search
        ]);
    }



    public function resetsearch()
    {

        return redirect()->route('system.order');
    }

    public function edit($id)
    {
        $orders = Order::join('treatment_services', 'treatment_services.treatment_id', '=', 'orders.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'orders.treatment_id')
            ->join('medical_records', 'medical_records.medical_id', '=', 'treatment_details.medical_id')
            ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->where('orders.order_id', $id)
            ->select(
                'orders.role',
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
                'orders.role',
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

        if (!$orders) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        return view('System.order.edit', ['orders' => $orders]);
    }


    public function update(Request $request, $id)
    {
        // Lấy đơn hàng dựa vào row_id
        $order = Order::where('row_id', $id)->firstOrFail();

        // Lấy hình thức thanh toán
        $role = $request->input('payment');

        // Cập nhật trạng thái và hình thức thanh toán
        $order->update([
            'status' => 1,
            'role' => $role,
        ]);
        // Trả về phản hồi JSON
        //  $this->print_order($id);

        // Trả về phản hồi JSON
        return redirect()->route('system.order')->with('success', 'Đơn hàng đã được xác nhận.');
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
                'orders.role',
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
                'orders.role',
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

    public function checkout_online()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_Returnurl = env('VNPAY_RETURN_URL');
        
        $vnp_TxnRef = rand(00,9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Nội dung thanh toán';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = 10000 * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        // //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
        // $vnp_Bill_City=$_POST['txt_bill_city'];
        // $vnp_Bill_Country=$_POST['txt_bill_country'];
        // $vnp_Bill_State=$_POST['txt_bill_state'];
        // // Invoice
        // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
        // $vnp_Inv_Email=$_POST['txt_inv_email'];
        // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
        // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
        // $vnp_Inv_Company=$_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type=$_POST['cbo_inv_type'];
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
            // "vnp_ExpireDate"=>$vnp_ExpireDate,
            // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
            // "vnp_Bill_Email"=>$vnp_Bill_Email,
            // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
            // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
            // "vnp_Bill_Address"=>$vnp_Bill_Address,
            // "vnp_Bill_City"=>$vnp_Bill_City,
            // "vnp_Bill_Country"=>$vnp_Bill_Country,
            // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
            // "vnp_Inv_Email"=>$vnp_Inv_Email,
            // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
            // "vnp_Inv_Address"=>$vnp_Inv_Address,
            // "vnp_Inv_Company"=>$vnp_Inv_Company,
            // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
            // "vnp_Inv_Type"=>$vnp_Inv_Type
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
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
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }
}
