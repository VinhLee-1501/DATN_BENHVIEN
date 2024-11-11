<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\CreateRequest;
use App\Http\Requests\Admin\Coupon\UpdateRequest;
use App\Models\Products\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){
            
        $couponActive = Coupon::paginate(10);
        return view('System.coupon.index', [
            'couponActive' => $couponActive,
        ]);
    }

    public function create(){

    }

    public function store(CreateRequest $request){
        $coupon = new Coupon();

        $coupon->coupon_code = $request->input('couponCode');
        $coupon->discount = $request->input('discount');
        $coupon->time_start = $request->input('timeStart');
        $coupon->time_end = $request->input('timeEnd');
        $coupon->save();

        return response()->json(['success' => true, 'message' => 'Thêm mã giảm giá thành công']);
    }

    public function edit($id){
        $coupon = Coupon::find($id);

        return response()->json([
            'coupon' => $coupon
        ]);
    }

    public function update(UpdateRequest $request, $id){
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['error' => true, 'message' => 'Không tìm thấy mã giảm giá.'], 404);
        }

        $coupon->coupon_code = $request->input('couponCode');
        $coupon->discount = $request->input('discount');
        $coupon->time_start = $request->input('timeStart');
        $coupon->time_end = $request->input('timeEnd');

        $coupon->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật mã giảm giá thành công']);

    }

    public function destroy($id){
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công');
    }
}