<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderMedicine;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\OrderMedicine\OrderMedicineRequest;
use App\Models\Medicine;

class OrderMedicineController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query chính
        $orderMedicinesQuery = OrderMedicine::join('treatment_details', 'order_medicines.treatment_id', '=', 'treatment_details.treatment_id')
            ->leftJoin('treatment_medications', 'treatment_details.treatment_id', '=', 'treatment_medications.treatment_id')
            ->leftJoin('medical_records', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->leftJoin('patients', 'medical_records.patient_id', '=', 'patients.patient_id')
            ->leftJoin('medicines', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
            ->select(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                'patients.first_name as patient_firstname',
                'patients.last_name as patient_lastname',
                'medical_records.medical_id',
                DB::raw('SUM(medicines.price * treatment_medications.quantity) as total_medicine_price'),
                DB::raw('SUM(treatment_medications.quantity) as total_quantity'),
                'order_medicines.status',
                'order_medicines.created_at'
            )
            ->groupBy(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                'patients.first_name',
                'patients.last_name',
                'medical_records.medical_id',
                'order_medicines.status',
                'order_medicines.created_at'
            );

        if ($request->filled('name')) {
            $orderMedicinesQuery->where(function ($query) use ($request) {
                $query->where('patients.first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('patients.last_name', 'like', '%' . $request->name . '%')
                    ->orWhere(DB::raw("CONCAT(patients.first_name, ' ', patients.last_name)"), 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('code_order')) {
            $orderMedicinesQuery->where('order_medicines.order_medicine_id', 'like', '%' . $request->code_order . '%');
        }

        if ($request->filled('price_from')) {
            $orderMedicinesQuery->where('order_medicines.total_price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $orderMedicinesQuery->where('order_medicines.total_price', '<=', $request->price_to);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $orderMedicinesQuery->whereBetween('order_medicines.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $orderMedicinesQuery->whereDate('order_medicines.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $orderMedicinesQuery->whereDate('order_medicines.created_at', '<=', $request->date_to);
        }

        $ordersUnpaid = $orderMedicinesQuery
            ->paginate(10)
            ->appends($request->query());

        return view('System.ordermedicine.index', [
            'ordersUnpaid' => $ordersUnpaid,
        ]);
    }



    public function edit($id)
    {
        $user = Auth::user();

        // Lấy thông tin đơn hàng thuốc dựa trên order_medicine_id
        $orderMedicine = OrderMedicine::join('treatment_details', 'order_medicines.treatment_id', '=', 'treatment_details.treatment_id')
            ->leftJoin('treatment_medications', 'treatment_details.treatment_id', '=', 'treatment_medications.treatment_id')
            ->leftJoin('medical_records', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->leftJoin('patients', 'medical_records.patient_id', '=', 'patients.patient_id')
            ->leftJoin('medicines', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
            ->select(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                DB::raw('GROUP_CONCAT(medicines.name SEPARATOR "|") as medicine_names'),
                DB::raw('GROUP_CONCAT(medicines.price SEPARATOR "|") as medicine_prices'),
                DB::raw('GROUP_CONCAT(treatment_medications.quantity SEPARATOR "|") as medicine_quantities'),
                'patients.first_name as patient_firstname',
                'patients.last_name as patient_lastname',
                'patients.birthday as patient_birthday',
                'patients.patient_id as patient_patient_id',
                'patients.gender as patient_gender'
            )
            ->where('order_medicines.order_medicine_id', $id)
            ->groupBy(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                'patients.first_name',
                'patients.last_name',
                'patients.birthday',
                'patients.patient_id',
                'patients.gender'
            )
            ->first();

        // Kiểm tra nếu đơn hàng thuốc không tồn tại
        if (!$orderMedicine) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy đơn hàng thuốc.'], 404);
        }

        // Nếu là yêu cầu AJAX, trả về JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $orderMedicine,
                'user' => [
                    'first_name' => $user->firstname,
                    'last_name' => $user->lastname,
                ],
            ]);
        }

        // Nếu không phải AJAX, trả về view
        return view('System.order.edit', ['orderMedicine' => $orderMedicine]);
    }
    public function print_order($id)
    {
        $orderMedicine = OrderMedicine::join('treatment_details', 'order_medicines.treatment_id', '=', 'treatment_details.treatment_id')
            ->leftJoin('treatment_medications', 'treatment_details.treatment_id', '=', 'treatment_medications.treatment_id')
            ->leftJoin('medical_records', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->leftJoin('patients', 'medical_records.patient_id', '=', 'patients.patient_id')
            ->leftJoin('medicines', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
            ->select(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                DB::raw('GROUP_CONCAT(medicines.name SEPARATOR "|") as medicine_names'),
                DB::raw('GROUP_CONCAT(medicines.price SEPARATOR "|") as medicine_prices'),
                DB::raw('GROUP_CONCAT(treatment_medications.quantity SEPARATOR "|") as medicine_quantities'),
                'patients.first_name as patient_firstname',
                'patients.last_name as patient_lastname',
                'patients.birthday as patient_birthday',
                'patients.patient_id as patient_patient_id',
                'patients.gender as patient_gender'
            )
            ->where('order_medicines.order_medicine_id', $id)
            ->groupBy(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                'patients.first_name',
                'patients.last_name',
                'patients.birthday',
                'patients.patient_id',
                'patients.gender'
            )
            ->first();

        // Kiểm tra nếu không tìm thấy đơn hàng thuốc
        if (!$orderMedicine) {
            abort(404, 'Không tìm thấy đơn hàng thuốc.');
        }

        $pdf = Pdf::loadView('System.ordermedicine.pdfordermedicineonline', ['orders' => $orderMedicine]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('order_invoice_' . $orderMedicine->order_medicine_id . '.pdf');
    }
    public function print_orderOnline($id)
    {
        $orderMedicine = OrderMedicine::join('treatment_details', 'order_medicines.treatment_id', '=', 'treatment_details.treatment_id')
            ->leftJoin('treatment_medications', 'treatment_details.treatment_id', '=', 'treatment_medications.treatment_id')
            ->leftJoin('medical_records', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->leftJoin('patients', 'medical_records.patient_id', '=', 'patients.patient_id')
            ->leftJoin('medicines', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
            ->select(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                DB::raw('GROUP_CONCAT(medicines.name SEPARATOR "|") as medicine_names'),
                DB::raw('GROUP_CONCAT(medicines.price SEPARATOR "|") as medicine_prices'),
                DB::raw('GROUP_CONCAT(treatment_medications.quantity SEPARATOR "|") as medicine_quantities'),
                'patients.first_name as patient_firstname',
                'patients.last_name as patient_lastname',
                'patients.birthday as patient_birthday',
                'patients.patient_id as patient_patient_id',
                'patients.gender as patient_gender'
            )
            ->where('order_medicines.order_medicine_id', $id)
            ->groupBy(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                'patients.first_name',
                'patients.last_name',
                'patients.birthday',
                'patients.patient_id',
                'patients.gender'
            )
            ->first();

        // Kiểm tra nếu không tìm thấy đơn hàng thuốc
        if (!$orderMedicine) {
            abort(404, 'Không tìm thấy đơn hàng thuốc.');
        }

        $pdf = Pdf::loadView('System.ordermedicine.pdfordermedicineonline', ['orders' => $orderMedicine]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('order_invoice_' . $orderMedicine->order_medicine_id . '.pdf');
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
    public function handlepay(OrderMedicineRequest $request)
    {
        // dd($request->all());
        $payment = $request->input('payment_method');
        $id = $request->input('order_medicine_id');
        $cash_received = $request->input('cash_received');
        $change_amount = $request->input('change_amount');
        $cashier_name = $request->input('cashier_name');
        $total_amount = $request->input('total_amount');
        $change = $cash_received - $total_amount;

        if ($payment == 0 || $payment == 1) {
            $order = OrderMedicine::where('order_medicine_id', $id)->firstOrFail();

            $order->update([
                'cashier' => $cashier_name,
                'change_amount' => $change_amount,
                'cash_received' => $cash_received,
                'status' => 1,
                'payment' => $payment,
                'total_price' => $total_amount,
                'change' => $change
            ]);

            // Tạo URL PDF cho hóa đơn
            $pdfUrl = route('system.ordermedicine.print', ['id' => $id]);

            return response()->json([
                'success' => true,
                'pdf_url' => $pdfUrl,
            ]);
        }
    }
    public function delete($id)
    {
        $orderMedicine = OrderMedicine::where('order_medicine_id', $id)->first();
        $orderMedicine->delete();
        return redirect()->route('system.ordermedicine')->with('success', 'Xóa hóa đơn thành công.');
    }
    public function dispenseMedication($id)
    {
        // Lấy thông tin đơn thuốc
        $orderMedicine = OrderMedicine::join('treatment_details', 'order_medicines.treatment_id', '=', 'treatment_details.treatment_id')
            ->leftJoin('treatment_medications', 'treatment_details.treatment_id', '=', 'treatment_medications.treatment_id')
            ->leftJoin('medical_records', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
            ->leftJoin('patients', 'medical_records.patient_id', '=', 'patients.patient_id')
            ->leftJoin('medicines', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
            ->select(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                DB::raw('GROUP_CONCAT(medicines.name SEPARATOR "|") as medicine_names'),
                DB::raw('GROUP_CONCAT(medicines.price SEPARATOR "|") as medicine_prices'),
                DB::raw('GROUP_CONCAT(treatment_medications.quantity SEPARATOR "|") as medicine_quantities'),
                'patients.first_name as patient_firstname',
                'patients.last_name as patient_lastname',
                'patients.birthday as patient_birthday',
                'patients.patient_id as patient_patient_id',
                'patients.gender as patient_gender'
            )
            ->where('order_medicines.order_medicine_id', $id)
            ->groupBy(
                'order_medicines.order_medicine_id',
                'order_medicines.treatment_id',
                'order_medicines.price_service',
                'patients.first_name',
                'patients.last_name',
                'patients.birthday',
                'patients.patient_id',
                'patients.gender'
            )
            ->first();

        if ($orderMedicine) {
            // Split the string into arrays
            $medicineNames = explode('|', $orderMedicine->medicine_names);
            $medicinePrices = explode('|', $orderMedicine->medicine_prices);
            $medicineQuantities = explode('|', $orderMedicine->medicine_quantities);

            foreach ($medicineNames as $index => $medicineName) {
                // Lấy thông tin thuốc từ bảng medicines
                $medicine = Medicine::where('name', $medicineName)->first();

                if ($medicine) {
                    // Lấy số lượng thuốc đã cho đơn thuốc
                    $quantityToDeduct = $medicineQuantities[$index];
                    $availableQuantity = $medicine->amount - $quantityToDeduct;

                    // Kiểm tra nếu số lượng trong kho đủ để trừ
                    if ($availableQuantity >= 0) {
                        // Trừ số lượng thuốc
                        $medicine->amount = $availableQuantity;
                        $medicine->save();
                    } else {
                        return back()->with('error', 'Không đủ số lượng thuốc ' . $medicineName . ' để phát.');
                    }
                } else {
                    return back()->with('error', 'Thuốc ' . $medicineName . ' không tìm thấy.');
                }
            }

            // Cập nhật trạng thái đơn thuốc thành "đã phát thuốc"
            OrderMedicine::where('order_medicine_id', $id)
                ->update(['status' => 2]);

            // Điều hướng về trang danh sách đơn thuốc và thông báo thành công
            return redirect()->route('system.ordermedicine')->with('success', 'Đơn thuốc đã được phát thuốc thành công.');
        }

        return redirect()->route('system.ordermedicine')->with('error', 'Không tìm thấy đơn thuốc.');
    }
}
