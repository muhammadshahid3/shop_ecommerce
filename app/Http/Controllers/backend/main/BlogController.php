<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::select('*');
            return datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function (Blog $data) {
                    $btn_eye = '<a href="' . route('admin.blog.view-blog', $data->id) . '"  class="edit mx-1"><i class="fa fa-eye"></i></a>';
                    $btn = '<a href="' . route('admin.blog.edit-blog', $data->id) . '"  class="edit mx-3"><i class="fa fa-pen"></i></a>';
                    $btn = $btn_eye . $btn . ' <a href="' . route('admin.blog.del-blog', $data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete category?'" . ')"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('thumbnail', function (Blog $data) {
                    if (file_exists(public_path('upload/blog/') . $data->thumbnail) && $data->thumbnail) {
                        $url = asset("upload/blog/" . $data->thumbnail);
                        return '<img src="' . $url . '" width="40" height="40" />';
                    } else {
                        $url = asset("upload/blog/dummy.png");
                        return '<img src="' . $url . '" width="40" height="40" />';
                    }
                })
                ->addColumn('description', function (Blog $data) {
                    $length = strlen($data->description);
                    if ($length >= 10) {
                        return substr($data->description, 0, 10) . '....';
                    } else {
                        return substr($data->description, 0, 15);

                    }
                })
                ->addColumn('blog_status', function (Blog $data) {

                    if ($data->blog_status == "A") {
                        return "Active";
                    } else {
                        return "InActive";
                    }
                })
                ->addColumn('created_at', function (Blog $data) {
                    $create = $data->created_at->format('m/d/y');
                    return $create;
                })
                ->rawColumns(['action', 'thumbnail', 'description', 'blog_status', 'created_at'])
                ->make(true);
        }
        return view('backend.blog.show_blog');
    }

    // Add Blog
    public function AddBlog()
    {
        return view('backend.blog.add_blog');
    }

    // Store Blog
    public function StoreBlog(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'mimes:jpeg,jpg,png,gif|max:1000|required',
            'description' => 'required'
        ]);

        // Blog Image Upload
        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $filename = GenerateSlug() . '.' . $file->getClientOriginalExtension();
            $file_path = public_path('\upload\Blog');
            $file->move($file_path, $filename);
        }

        // Create Blog
        $create_blog = Blog::create([
            'title' => $request->title,
            'thumbnail' => $filename,
            'description' => $request->description,
            'blog_status' => $request->blog_status
        ]);

        if ($create_blog) {
            session()->flash('msg', 'Add Blog Successfully');
            return redirect('admin/blog');
        }
    }

    // View Blog
    public function ViewBlog($id)
    {
        $blog_data = Blog::where('id', $id)->first();
        //Date Format 
        $date = $blog_data->updated_at->diffForHumans();
        $arr_pass['view_details'] = $blog_data;
        $arr_pass['date'] = $date;
        
        return view('backend.blog.view_blog', $arr_pass);
    }

    // Edit Blog
    public function EditBlog($id)
    {
        $arr_pass['blog_details'] = Blog::where('id', $id)->first();
        return view('backend.blog.edit_blog', $arr_pass);
    }

    // Update Blog
    public function UpdateBlog(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        // Previous Image
        $prev_image = Blog::where('id', $request->blog_id)->first();
        $thumbnail = $prev_image->thumbnail;

        // Upload Image
        if ($request->hasFile('thumbnail')) {

            // Check file system image
            if (file_exists(public_path('upload/blog/' . $thumbnail))) {
                unlink(public_path('upload/blog/' . $thumbnail));
            }
            //Upload Image
            $file = $request->thumbnail;
            $thumbnail = GenerateSlug() . '.' . $file->getClientOriginalExtension();
            $file_path = public_path('\upload\Blog');
            $file->move($file_path, $thumbnail);
        }

        $update_blog = Blog::where('id', $request->blog_id)->update([
            'title' => $request->title,
            'thumbnail' => $thumbnail,
            'description' => $request->description,
            'blog_status' => $request->blog_status
        ]);
        if ($update_blog) {

            session()->flash('msg', 'Update Blog Successfully');
            return redirect('admin/blog');
        }
    }

    // Delete Blog
    public function DelBlog($id)
    {
        $blog = Blog::where('id', $id)->first();

        if (file_exists(public_path('upload/blog/' . $blog->thumbnail))) {
            unlink(public_path('upload/blog/' . $blog->thumbnail));
        }

        $del_blog = Blog::where('id', $id)->delete();

        if ($del_blog) {
            session()->flash('msg', 'Delete Blog Successfully');
            return redirect('admin/blog');
        }
    }
}
