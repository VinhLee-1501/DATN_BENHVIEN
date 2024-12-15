<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AddProductRequest;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Models\Products\Category;
use App\Models\Products\ImgProduct;
use App\Models\Products\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   public function index(Request $request)
   {
      // Lấy giá trị của query string 'tab', mặc định là 'nav-home'
      $activeTab = $request->query('tab', 'nav-home');

      $query = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
         ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
         ->select(
            'products.*',
            'categories.name as nameCategory',
            DB::raw('GROUP_CONCAT(img_products.img) as img_array')
         )
         ->whereNull('products.deleted_at')
         ->groupBy(
            'products.product_id',
            'products.name',
            'products.code_product',
            'products.unit_of_measurement',
            'products.active_ingredient',
            'products.used',
            'products.description',
            'products.price',
            'products.brand',
            'products.manufacture',
            'products.registration_number',
            'products.status',
            'products.category_id',
            'products.deleted_at',
            'products.created_at',
            'products.updated_at',
            'categories.category_id',
            'categories.name',
            'categories.status',
            'categories.img',
            'categories.parent_id',
            'categories.deleted_at',
            'categories.created_at',
            'categories.updated_at',

            'products.quantity'
         )
         ->orderBy('products.status', 'desc');

      // Tìm kiếm theo tên sản phẩm
      if ($request->filled('name')) {
         $query->where('products.name', 'like', '%' . $request->name . '%');
      }

      // Tìm kiếm theo mã sản phẩm
      if ($request->filled('code_product')) {
         $query->where('products.code_product', 'like', '%' . $request->code_product . '%');
      }

      // Tìm kiếm theo giá
      if ($request->filled('price_from')) {
         $query->where('products.price', '>=', $request->price_from);
      }
      if ($request->filled('price_to')) {
         $query->where('products.price', '<=', $request->price_to);
      }

      // Tìm kiếm theo ngày
      if ($request->filled('date_from') && $request->filled('date_to')) {
         $query->whereBetween('products.created_at', [$request->date_from, $request->date_to]);
      } elseif ($request->filled('date_from')) {
         $query->whereDate('products.created_at', '>=', $request->date_from);
      } elseif ($request->filled('date_to')) {
         $query->whereDate('products.created_at', '<=', $request->date_to);
      }



      // Phân trang cho sản phẩm còn hàng (status = 1)
      $product = $query->clone()->where('products.status', 1)->where('products.quantity', '>', 0)->paginate(10)->appends($request->query());

      // Phân trang cho sản phẩm hết hàng (status = 0)
      $productEnd = $query->clone()->where('products.status', 0)->orwhere('products.quantity', 0)->paginate(10)->appends($request->query());

      // Lấy danh sách các barcode
      $generatorHTML = new BarcodeGeneratorHTML();
      $barcodes = [];
      foreach ($product as $item) {
         $barcodes[$item->product_id] = $generatorHTML->getBarcode($item->code_product, $generatorHTML::TYPE_CODE_128);
      }

      $barcodeEnd = [];
      foreach ($productEnd as $item) {
         $barcodeEnd[$item->product_id] = $generatorHTML->getBarcode($item->code_product, $generatorHTML::TYPE_CODE_128);
      }

      return view('System.products.index', [
         'product' => $product,
         'barcodes' => $barcodes,
         'barcodeEnd' => $barcodeEnd,
         'productEnd' => $productEnd,
         'activeTab' => $activeTab,
      ]);
   }





   public function create()
   {
      $category = Category::where('status', 1)->get();
      return response()->json(['category' => $category]);
   }

   public function store(AddProductRequest $request)
   {

      $name = $request->input('name');
      $code_product = $request->input('code_product');
      $unit_of_measurement = $request->input('unit_of_measurement');
      $active_ingredient = $request->input('active_ingredient');
      $used = $request->input('used');
      $description = $request->input('description');
      $price = $request->input('price');
      $brand = $request->input('brand');
      $manufacture = $request->input('manufacture');
      $registration_number = $request->input('registration_number');
      $category_id = $request->input('category_id');

      if (!$name || !$category_id || !$active_ingredient || !$unit_of_measurement || !$code_product || !$used || !$description || !$price || !$manufacture || !$registration_number) {
         return response()->json(['error' => true, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
      }


      $product = new Product();

      $product->category_id = $category_id;
      $product->name = $name;
      $product->code_product = $code_product;
      $product->unit_of_measurement = $unit_of_measurement;
      $product->active_ingredient = $active_ingredient;
      $product->used = $used;
      $product->description = $description;
      $product->price = $price;
      $product->brand = $brand;
      $product->manufacture = $manufacture;
      $product->registration_number = $registration_number;
      $product->status = 1;

      $product->save();
      $product_id = $product->product_id;


      if ($request->hasFile('product_images')) {

         foreach ($request->file('product_images') as $file) {

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('uploads/products', $fileName, 'public');

            $img = new ImgProduct();
            $img->product_id = $product_id;
            $img->img = $fileName;
            $img->save();
         }
      }



      return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm thành công']);
   }


   public function edit($product_id)
   {
      $category = Category::where('status', 1)->get();

      $product = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
         ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
         ->select(
            'products.*',
            'categories.name as nameCategory',
            DB::raw('GROUP_CONCAT(img_products.img) as img_array')
         )
         ->where('products.product_id', $product_id)
         ->whereNull('products.deleted_at')
         ->groupBy(
            'products.product_id',
            'products.name',
            'products.code_product',
            'products.unit_of_measurement',
            'products.active_ingredient',
            'products.used',
            'products.description',
            'products.price',
            'products.brand',
            'products.manufacture',
            'products.registration_number',
            'products.status',
            'products.category_id',
            'products.deleted_at',
            'products.created_at',
            'products.updated_at',
            'categories.category_id',
            'categories.name',
            'categories.status',
            'categories.img',
            'categories.parent_id',
            'categories.deleted_at',
            'categories.created_at',
            'categories.updated_at',
            'products.quantity'
         )
         ->first();

      if (!$product) {
         return response()->json(['success' => false, 'message' => 'Không tìm thấy thuốc.']);
      }

      // Chia tách img_array và loại bỏ giá trị không hợp lệ
      $product->img_array = array_filter(explode(',', $product->img_array));

      // Chuyển đổi các đường dẫn ảnh thành URL đầy đủ
      $product->img_array = array_map(function ($img) {
         return asset('storage/uploads/products/' . $img);
      }, $product->img_array);

      return response()->json([
         'success' => true,
         'product' => $product,
         'category' => $category,
         'img_array' => $product->img_array // Đưa img_array vào kết quả trả về
      ]);
   }



   public function update(Request $request, $id)
   {

      $product = Product::find($id);
      if (!$product) {
         return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm.'], 404);
      }

      // Cập nhật thông tin sản phẩm

      $product->product_id = $id;
      $product->name = $request->input('name_up');
      $product->code_product = $request->input('codeProduct');
      $product->category_id = $request->input('categoryId');
      $product->active_ingredient = $request->input('activeIngredient');
      $product->unit_of_measurement = $request->input('unitOfMeasurement');
      $product->used = $request->input('used');
      $product->description = $request->input('description');
      $product->price = $request->input('price');
      $product->brand = $request->input('brand');
      $product->status = $request->input('status');
      $product->quantity = $request->input('quantity');
      $product->manufacture = $request->input('manufacture');
      $product->registration_number = $request->input('registrationNumber');


      $product->update();

      $imagesToDelete = ImgProduct::where('product_id', $id)->forceDelete();

      if ($request->input('product_images_url')) {
         $existingImages = $request->input('product_images_url'); // Lấy URL ảnh hiện có

         foreach ($existingImages as $image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
               $imageName = basename($image);
               ImgProduct::create([
                  'product_id' => $id,
                  'img' => $imageName
               ]);
            }
         }
      }

      if ($request->hasFile('product_images_up')) {
         $files = $request->file('product_images_up');
         foreach ($files as $file) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/products', $imageName, 'public');

            ImgProduct::create([
               'product_id' => $id,
               'img' => $imageName
            ]);
         }
      }

      return response()->json([
         'success' => true,
         'message' => 'Cập nhật sản phẩm thành công.',

      ]);
   }


   public function delete($product_id)
   {

      $img = ImgProduct::where('product_id', $product_id)->delete();
      $product = product::findOrFail($product_id);
      $product->delete();


      return redirect()->route('system.product')->with('success', 'Xóa thành công.');
   }
}