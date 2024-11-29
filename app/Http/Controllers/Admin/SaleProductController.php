<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaleProduct\CreateRequest;
use App\Http\Requests\Admin\SaleProduct\UpdateRequest;
use App\Models\Products\Product;
use App\Models\Products\SaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleProductController extends Controller
{
    public function index()
    {
        $saleProductActive = SaleProduct::join('products', 'products.product_id', '=', 'sale_products.product_id')
            ->where('sale_products.status', 1)
            ->paginate(10);

        $saleProductUnactive = SaleProduct::join('products', 'products.product_id', '=', 'sale_products.product_id')
            ->where('sale_products.status', 0)
            ->paginate(10);

        return view(
            'System.saleProduct.index',
            [
                'saleProductActive' => $saleProductActive,
                'saleProductUnactive' => $saleProductUnactive
            ]
        );
    }

    public function create()
    {
        $product = Product::get();

        return response()->json([
            'products' => $product
        ]);
    }

    public function store(CreateRequest $request)
    {
        $saleProduct = new SaleProduct();
        $saleProduct->sale_code = $request->input('saleCode');
        $saleProduct->product_id = $request->input('productId');
        $saleProduct->time_start = $request->input('timeStart');
        $saleProduct->time_end = $request->input('timeEnd');
        $saleProduct->discount = $request->input('discount');
        $saleProduct->status = $request->input('statusActive') === '1' ? 1 : 0;

        $saleProduct->save();
        return response()->json(['success' => true, 'message' => 'Thêm mã giảm giá thành công']);
    }

    public function edit($id)
    {
        $saleProduct = SaleProduct::where('sale_id', $id)->first();
        return response()->json([
            'saleProduct' => $saleProduct
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $saleProduct = SaleProduct::where('sale_id', $id)->first();
        $saleProduct->sale_code = $request->input('saleCode');
        $saleProduct->product_id = $request->input('productId');
        $saleProduct->time_start = $request->input('timeStart');
        $saleProduct->time_end = $request->input('timeEnd');
        $saleProduct->discount = $request->input('discount');
        $saleProduct->status = $request->input('statusActive') === '1' ? 1 : 0;
        $saleProduct->save();
        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }

    public function destroy($id){
        $saleProduct = SaleProduct::findOrFail($id);
        $saleProduct->delete();
        return redirect()->route('system.sale_product')->with('success', 'Xóa thành công');
    }
}