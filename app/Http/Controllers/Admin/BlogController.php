<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\Admin\Blog\BlogRequest;
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



    public function store(BlogRequest $request)
    {
        try {
            $blog = new Blog();
            $blog->title = $request->input('title');
            $content = $request->input('content');

            preg_match_all('/<img src="data:image\/(?<type>[^;]+);base64,(?<data>[^"]+)"/', $content, $matches);

            if (!empty($matches['data'])) {
                foreach ($matches['data'] as $key => $data) {
                    $imageData = base64_decode($data);
                    $imageName = 'image_' . time() . '_' . $key . '.' . $matches['type'][$key];

                    // Tạo ảnh từ dữ liệu base64
                    $image = Image::make($imageData);

                    // Giảm chất lượng ảnh (nếu cần)
                    $quality = 50;
                    $image->encode($matches['type'][$key], $quality);

                    // Lưu ảnh vào thư mục public/uploads/blogs
                    Storage::disk('public')->put('uploads/blogs/' . $imageName, (string) $image);

                    // Thay thế đường dẫn ảnh trong nội dung
                    $content = str_replace($matches[0][$key], '<img src="' . asset('storage/uploads/blogs/' . $imageName) . '"', $content);
                }
            }

            $blog->content = $content;
            $blog->describe = $request->input('describe');
            $blog->author = $request->input('author');
            $blog->date = $request->input('date') ?? now();
            $blog->slug = Str::slug($request->input('title'));
            $blog->status = $request->input('status');

            if (!session()->has('upload_file')) {
                $firstImageData = $matches['data'][0]; // Dữ liệu base64 của ảnh đầu tiên

                // Gán chỉ dữ liệu base64 làm thumbnail
                $blog->thumbnail = $firstImageData;
            } else {
                $base64Image = session('upload_file');
                $blog->thumbnail = $base64Image;
                session()->forget('upload_file');
            }

            $blog->save();

            // Thành công, chuyển hướng tới trang danh sách bài viết
            return redirect()->route('system.blog')->with('success', 'Thêm mới thành công.');
        } catch (\Exception $e) {

            return redirect()->route('system.blogs.create')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }




    public function uploadfile()
    {
        if (request()->hasFile('thumbnail')) {
            $file = request()->file('thumbnail');

            // Kiểm tra kích thước tệp
            if ($file->getSize() > 500 * 1024) { // Kiểm tra nếu kích thước lớn hơn 800KB
                // Giảm dung lượng ảnh xuống 70%
                $image = Image::make($file->getRealPath())
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 70); // Định dạng và chất lượng ảnh
            } else {
                // Nếu kích thước nhỏ hơn hoặc bằng 800KB, không thay đổi gì
                $image = Image::make($file->getRealPath())
                    ->encode('jpg', 100); // Giữ nguyên chất lượng
            }

            // Lấy nội dung ảnh sau khi giảm dung lượng
            $fileData = $image->getEncoded();

            // Chuyển đổi nội dung ảnh sang base64
            $fileBase64 = base64_encode($fileData);

            // Lưu base64 vào session
            session(['upload_file' => $fileBase64]);
        }
    }


    public function revertfile()
    {
        session()->forget('upload_file');
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

        $tab = $request->input('tab');

        $itemsPerPage = 10;

        $blogQuery = Blog::where('status', 0)
            ->orderBy('created_at', 'desc');

        if ($search && $tab == 0) {
            $blogQuery->where('title', 'LIKE', "%$search%");
        }

        $blogs = $blogQuery->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage
        ]);

        $blogInactiveQuery = Blog::where('status', 1)
            ->orderBy('created_at', 'desc');

        if ($search && $tab == 1) {
            $blogInactiveQuery->where('title', 'LIKE', "%$search%");
        }

        $blogInactive = $blogInactiveQuery->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage
        ]);
        // Trả về view với các tham số cần thiết
        return view('System.blogs.index', [
            'blogs' => $blogs,
            'blogInactive' => $blogInactive,
            'search' => $search
        ]);
    }


    public function resetsearch()
    {
        return redirect()->route('system.blog');
    }



    public function edit($slug)
    {
        // $blog = Blog::where('blog_id', $blog_id)->first();
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('System.blogs.edit', ['blogs' => $blog]);
    }

    public function update(BlogRequest $request, $id)
    {
        // $blog = Blog::where('blog_id', $blog_id)->firstOrFail();
        try {
            $blog = Blog::findOrFail($id);
            $blog->title = $request->input('title');
            $blog->slug = $request->input('title');
            $content = $request->input('content');

            preg_match_all('/<img src="data:image\/(?<type>[^;]+);base64,(?<data>[^"]+)"/', $content, $matches);

            if (!empty($matches['data'])) {
                foreach ($matches['data'] as $key => $data) {
                    $imageData = base64_decode($data);
                    $imageName = 'image_' . time() . '_' . $key . '.' . $matches['type'][$key];

                    // Tạo ảnh từ dữ liệu base64
                    $image = Image::make($imageData);

                    // Giảm chất lượng ảnh (nếu cần)
                    $quality = 50;
                    $image->encode($matches['type'][$key], $quality);

                    // Lưu ảnh vào thư mục public/uploads/blogs
                    Storage::disk('public')->put('uploads/blogs/' . $imageName, (string) $image);

                    // Thay thế đường dẫn ảnh trong nội dung
                    $content = str_replace($matches[0][$key], '<img src="' . asset('storage/uploads/blogs/' . $imageName) . '"', $content);
                }
            }
            // Lưu nội dung đã cập nhật vào cơ sở dữ liệu
            $blog->content = $content;
            $blog->author = $request->input('author');
            $blog->date = $request->input('date') ?? now();
            $blog->status = $request->input('status');


            if (!session()->has('upload_file')) {

                $firstImageData = $matches['data'][0];

                $blog->thumbnail = $firstImageData;
            } else {

                $base64Image = session('upload_file');

                $blog->thumbnail = $base64Image;

                session()->forget('upload_file');
            }

            $blog->update();


            return redirect()->route('system.blog')->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {

            return redirect()->route('system.blogs.create')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }
    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        $content = $blog->content;

        preg_match_all('/<img[^>]+src=["\'](.*?)["\'][^>]*>/i', $content, $matches);

        $imageUrls = $matches[1];

        foreach ($imageUrls as $imageUrl) {
     
            $imageName = basename($imageUrl); 
            $relativePath = storage_path('app/public/uploads/blogs/' . $imageName);  

            if (file_exists($relativePath)) {
                // Kiểm tra quyền ghi vào tệp trước khi xóa
                if (is_writable($relativePath)) {
                    // Xóa tệp
                    if (unlink($relativePath)) {
                        echo "Đã xóa tệp: " . $relativePath;
                    } 
                }
            }
        }

        // Xóa bài viết khỏi database
        $blog->delete();

        return redirect()->route('system.blog')->with('success', 'Xóa thành công.');
    }

    public function blogviewclient()
    {
        $this->updatestatus();

        $newblogs = Blog::where('status', 0)->orderBy('created_at', 'desc')->limit(4)->get();
        $blogs = Blog::where('status', 0)->orderBy('created_at', 'desc')->paginate(6);
        $firstBlog = $blogs->first();

        // dd($totalBlogs);
        return view('client.news', [
            'blogs' => $blogs,
            'newblogs' => $newblogs,
            'slug' => $firstBlog ? $firstBlog->slug : null
        ]);
    }

    public function detailblog($slug)
    {

        $blog = Blog::where('slug', $slug)->firstOrFail();

        return view('client.detailnews', ['blog' => $blog]);
    }
}
