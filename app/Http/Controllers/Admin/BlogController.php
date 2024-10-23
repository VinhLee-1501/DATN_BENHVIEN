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
        // date_default_timezone_set('Asia/Ho_Chi_Minh');

        // $months = [
        //     1 => 'Jan',
        //     2 => 'Feb',
        //     3 => 'Mar',
        //     4 => 'Apr',
        //     5 => 'May',
        //     6 => 'Jun',
        //     7 => 'Jul',
        //     8 => 'Aug',
        //     9 => 'Sep',
        //     10 => 'Oct',
        //     11 => 'Nov',
        //     12 => 'Dec'
        // ];


        // $year = date('Y');
        // $day = date('d');
        // $time = date('H:i:s');
        // $currentMonthNumber = date('n');
        // $currentMonthAbbr = $months[$currentMonthNumber];
        // $currentTimeWithMonth = "$currentMonthAbbr $year $day $time";
        // $uniqueId = strtolower(str_replace([' ', ':'], '', $currentTimeWithMonth));


        $blog = new Blog();
        $blog->title = $request->input('title');
        $content = $request->input('content');

        preg_match_all('/<img src="data:image\/(?<type>[^;]+);base64,(?<data>[^"]+)"/', $content, $matches);

        if (!empty($matches['data'])) {
            foreach ($matches['data'] as $key => $data) {

                $imageData = base64_decode($data);
                $imageName = 'image_' . time() . '_' . $key . '.' . $matches['type'][$key];

                // $image = Image::make($imageData);

                // // Bắt đầu với chất lượng 75%
                // $quality = 75;

                // // Nén hình ảnh cho đến khi kích thước tệp nhỏ hơn 500KB
                // do {
                //     // Nén hình ảnh
                //     $image->encode($matches['type'][$key], $quality);

                //     // Lưu hình ảnh tạm thời vào bộ nhớ
                //     $tempPath = tempnam(sys_get_temp_dir(), 'img');
                //     file_put_contents($tempPath, (string) $image);

                //     // Kiểm tra kích thước tệp
                //     $fileSize = filesize($tempPath);

                //     // Giảm chất lượng nếu kích thước lớn hơn 500KB
                //     $quality -= 5;
                // } while ($fileSize > 500 * 1024 && $quality > 0);
                Storage::disk('public')->put('uploads/' . $imageName, $imageData);

                $content = str_replace($matches[0][$key], '<img src="' . asset('storage/uploads/' . $imageName) . '"', $content);
            }
        }

        $blog->content = $content;
        $blog->describe = $request->input('describe');
        $blog->author = $request->input('author');
        $blog->date = $request->input('date') ?? now();
        $blog->slug = Str::slug($request->input('title'));
        // $blog->blog_id = $uniqueId;
        $blog->status = $request->input('status');

        if (!session()->has('uploaded_file_base64')) {

            $firstImageData = $matches['data'][0]; // Dữ liệu base64 của ảnh đầu tiên

            // Gán chỉ dữ liệu base64 làm thumbnail
            $blog->thumbnail = $firstImageData;
        } else {
            $base64Image = session('uploaded_file_base64');
            $blog->thumbnail = $base64Image;
            session()->forget('uploaded_file_base64');
        }

        $blog->save();


        return redirect()->route('system.blog')->with('success', 'Thêm mới thành công.');
    }


    public function uploadfile()
    {
        if (request()->hasFile('thumbnail')) {
            $file = request()->file('thumbnail');

            $fileData = file_get_contents($file->getRealPath());

            $fileBase64 = base64_encode($fileData);

            session(['uploaded_file_base64' => $fileBase64]);
        }
    }


    public function revertfile()
    {
        session()->forget('uploaded_file_base64');
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

                Storage::disk('public')->put('uploads/' . $imageName, $imageData);

                // Cập nhật chuỗi HTML để thay thế đường dẫn Base64 bằng đường dẫn đã lưu
                $content = str_replace($matches[0][$key], '<img src="' . asset('storage/uploads/' . $imageName) . '"', $content);
            }
        }
        // Lưu nội dung đã cập nhật vào cơ sở dữ liệu
        $blog->content = $content;
        $blog->author = $request->input('author');
        $blog->date = $request->input('date') ?? now();
        $blog->status = $request->input('status');


        if (session()->has('uploaded_file_base64')) {
            $base64Image = session('uploaded_file_base64');

            $blog->thumbnail = $base64Image;

            session()->forget('uploaded_file_base64');
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
