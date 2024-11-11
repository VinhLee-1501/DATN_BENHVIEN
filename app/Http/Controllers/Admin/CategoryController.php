<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CategoryRequest;
use App\Models\Products\Category;
use App\Models\Products\ParentCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $category = Category::paginate(10);
        $categoryParent = ParentCategory::get();

        return view('System.categories.index', [
            'category' => $category,
            'categoryParent' => $categoryParent,
          
        ]);
    }

    public function create(){
        $parent = ParentCategory::get();
        return response()->json(['parent' => $parent]);
    }
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->category_id = $request->input('code');
        $category->parent_id = $request->input('parent_id');
        $category->name = $request->input('name');
        $category->status = 1;

        if ($request->hasFile('img')) { 
            $file = $request->file('img'); 

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('uploads/categories', $fileName, 'public');
            $category->img = $fileName;
        }  $fileName = time() . '_' . $file->getClientOriginalName();

        

        $category->save();
        return response()->json(['success' => true, 'message' => 'Thêm danh mục thành công']);
    }

    public function edit($category_id){
        $category = Category::where('category_id', $category_id)->first();
        $parent = ParentCategory::get();
        return response()->json([
            'success' => true,
            'parent' => $parent,
            'category' => $category,
         
        ]);
    }

    public function update(Request $request, $category_id)
    {
        $category = Category::where('category_id', $category_id)->first();

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
        }
        
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->status = $request->input('status');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/categories', $fileName, 'public');
            $category->img = $fileName;
        }

        $category->update(); 

        return response()->json(['success' => true, 'message' => 'Cập nhật danh mục thành công']);
    }


    
    public function delete($category_id)
    {

        $caetgory = Category::findOrFail($category_id);
        $caetgory->delete();


        return redirect()->route('system.category')->with('success', 'Xóa thành công.');
    }
}