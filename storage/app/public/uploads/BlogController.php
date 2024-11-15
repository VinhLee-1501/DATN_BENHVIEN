<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\Admin\Blog\ValidationRequest;
use Illuminate\Support\Str;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class BlogController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('System.blogs.create', ['user' => $user]);
    }



    public function store(ValidationRequest $request)
    {

        $blog = new Blog();
        $blog->title = $request->input('title');
        $content = $request->input('content');

        preg_match_all('/<img src="data:image\/(?<type>[^;]+);base64,(?<data>[^"]+)"/', $content, $matches);

        if (!empty($matches['data'])) {
            foreach ($matches['data'] as $key => $data) {

                $imageData = base64_decode($data);
                $imageName = 'image_' . time() . '_' . $key . '.' . $matches['type'][$key];

                $image = Image::make($imageData);

                $quality = 75;

                $image->encode($matches['type'][$key], $quality);

                Storage::disk('public')->put('uploads/' . $imageName, (string) $image);

                $content = str_replace($matches[0][$key], '<img src="http://127.0.0.1:8000/storage/uploads/' . $imageName . '"', $content);
            }
        }
        // Lưu nội dung đã cập nhật vào cơ sở dữ liệu
        $blog->content = $content;
        $blog->describe = $request->input('describe');
        $blog->author = $request->input('author');
        $blog->date = $request->input('date') ?? now();
        $blog->slug = Str::slug($request->input('title'));
        $blog->status = $request->input('status');


        if (!session()->has('uploaded_file_path')) {

            $firstImageData = $matches['data'][0];

            $blog->thumbnail = $firstImageData;
        } else {

            $path = session('uploaded_file_path');

            $blog->thumbnail = $path;

            session()->forget('uploaded_file_path');
        }

        $blog->save();


        return redirect()->route('system.blog')->with('success', 'Thêm mới thành công.');
    }


    public function uploadfile(Request $request)
    {
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');

            // Tạo tên cho tệp hình ảnh
            $imageName = time() . '_' . $file->getClientOriginalName();

            $filePath = 'uploads/' . $imageName;

            // Lưu tệp hình ảnh vào thư mục uploads
            Storage::disk('public')->put($filePath, file_get_contents($file->getRealPath()));

            // Lưu đường dẫn của tệp đã tải lên vào session
            session(['uploaded_file_path' => $filePath]);
        }
    }


    public function revertfile(Request $request)
    {
        if (Session()->has('uploaded_file_path')) {
            $filePath = session('uploaded_file_path');
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Nếu không có tên file, xóa session (nếu cần)
        session()->forget('uploaded_file_path');
    }


    public function updatestatus()
    {
        $currentDateTime = now();
        $blogs = Blog::where('status', 1)->get();

        foreach ($blogs as $blog) {
            if ($blog->date <= $currentDateTime) {
                $blog->status = 0;
                $blog->save();
            }
        }
    }


    public function index(Request $request)
    {
        $this->updatestatus();

        $search = $request->input('search', '');

        $delete = $request->input('blog_id', []);

        if (!empty($delete)) {
            Blog::whereIn('id', $delete)->delete();
            return redirect()->route('system.blog')->with('success', 'Đã xóa các bài viết được chọn.');
        }

        $itemsPerPage = request()->input('itemsPerPage', 5);

        if ($search) {
            $blogs = Blog::where('title', 'LIKE', "%$search%")
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            $blogs = Blog::orderBy('created_at', 'desc')->paginate($itemsPerPage);
        }

        return view('System.blogs.index', [
            'blogs' => $blogs,
            'search' => $search
        ]);
    }



    public function resetsearch()
    {
        // $oldsearch = session()->get('search', '');

        // session()->forget('search');

        // session()->flash('oldsearch', $oldsearch);

        return redirect()->route('system.blog');
    }



    public function edit($slug)
    {
        // $blog = Blog::where('blog_id', $blog_id)->first();
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('System.blogs.edit', ['blogs' => $blog]);
    }

    public function update(ValidationRequest $request, $id)
    {
        // $blog = Blog::where('blog_id', $blog_id)->firstOrFail();
        $blog = Blog::findOrFail($id);
        $blog->title = $request->input('title');
        $blog->slug = $request->input('title');
        $content = $request->input('content');

        preg_match_all('/<img src="data:image\/(?<type>[^;]+);base64,(?<data>[^"]+)"/', $content, $matches);

        if (!empty($matches['data'])) {
            foreach ($matches['data'] as $key => $data) {

                $imageData = base64_decode($data);
                $imageName = 'image_' . time() . '_' . $key . '.' . $matches['type'][$key];

                $image = Image::make($imageData);

                $quality = 75;

                $image->encode($matches['type'][$key], $quality);

                Storage::disk('public')->put('uploads/' . $imageName, (string) $image);

                $content = str_replace($matches[0][$key], '<img src="http://127.0.0.1:8000/storage/uploads/' . $imageName . '"', $content);
            }
        }
        // Lưu nội dung đã cập nhật vào cơ sở dữ liệu
        $blog->content = $content;
        $blog->author = $request->input('author');
        $blog->date = $request->input('date') ?? now();
        $blog->status = $request->input('status');


        if (!session()->has('uploaded_file_path')) {

            $firstImageData = $matches['data'][0];

            $blog->thumbnail = $firstImageData;
        } else {

            $base64Image = session('uploaded_file_path');

            $blog->thumbnail = $base64Image;

            session()->forget('uploaded_file_path');
        }

        $blog->update();


        return redirect()->route('system.blog')->with('success', 'Cập nhật thành công.');
    }
    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('system.blog')->with('success', 'Xóa thành công.');
    }

    public function blogviewclient(Request $request)
    {
        $this->updatestatus();

        $totalBlogs = Blog::where('status', 0)->count();

        $numberblog = $request->input('numberblog', 6);

        if ($request->input('showMore') == 'true') {
            $numberblog += 6;
        }

        $newblogs = Blog::where('status', 0)->orderBy('created_at', 'desc')->limit(4)->get();
        $blogs = Blog::where('status', 0)->orderBy('created_at', 'desc')->paginate($numberblog);
        $firstBlog = $blogs->first();

        return view('client.news', [
            'blogs' => $blogs,
            'newblogs' => $newblogs,
            'numberblog' => $numberblog,
            'totalBlogs' => $totalBlogs,
            'slug' => $firstBlog ? $firstBlog->slug : null // 
        ]);
    }

    public function detailblog($slug)
    {
        // Tìm kiếm blog dựa trên slug
        $blog = Blog::where('slug', $slug)->firstOrFail();
        // dd($blog);

        return view('client.detailnews', ['blog' => $blog]);
    }
}
