<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;
use Str;

class CategoryController extends Controller
{
    //Add Category
    public function AddCategory()
    {
        $category = Category::where('category_status', 'A')->get();
        return view('backend.categories.add_category', compact('category'));
    }

    // All Categories
    public function AllCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function (Category $data) {
                    $btn_eye = '<a href="' . route('admin.category.view-category', $data->id) . '"  class="edit mx-1"><i class="fa fa-eye"></i></a>';
                    $btn = '<a href="' . route('admin.category.showcategory.edit', $data->id) . '"  class="edit mx-3"><i class="fa fa-pen"></i></a>';
                    $btn = $btn_eye . $btn . ' <a href="' . route('admin.category.showcategory.delcategory', $data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete category?'" . ')"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('image', function (Category $data) {
                    if (file_exists(public_path('upload/category/') . $data->category_image) && $data->category_image) {
                        $url = asset("upload/category/" . $data->category_image);
                        return '<img src="' . $url . '" width="40" height="40" />';
                    } else {
                        $url = asset("upload/category/dummy.png");
                        return '<img src="' . $url . '" width="40" height="40" />';
                    }
                })
                ->addColumn('category_icon', function (Category $data) {
                    return '<i class ="' . $data->category_icon . '"></i>';
                })
                ->addColumn('category_status', function (Category $data) {

                    if ($data->category_status == "A") {
                        return "Active";
                    } else {
                        return "InActive";
                    }
                })
                ->addColumn('created_at', function (Category $data) {
                    $create = $data->created_at->format('m/d/y');
                    return $create;
                })
                ->rawColumns(['action', 'image', 'category_icon', 'category_status', 'created_at'])
                ->make(true);
        }
        return view('backend.categories.show_category');
    }

    // View Category
    public function ViewCategory($id)
    {
        $category = Category::where('id', $id)->get();
        return view('backend.categories.view_category', compact('category'));
    }

    // Store Category
    public function StoreCategory(Request $request)
    {

        $request->validate([
            'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'category_image' => 'mimes:jpeg,jpg,png,gif|max:1000|required',
            'category_icon' => 'required|string',
            'category_order' => 'required|string',
            'category_status' => 'required'
        ]);
        // Category Image Upload
        if ($request->hasFile('category_image')) {
            $file = $request->category_image;
            $filename = GenerateSlug() . '.' . $file->getClientOriginalExtension();
            $file_path = public_path('\upload\category');
            $file->move($file_path, $filename);
        }
        // Generate Slug
          $category_slug = GenerateSlug();
        // Category Create
        $create_category = Category::create([
            'category_slug' => $category_slug,
            'category_name' => $request->category_name,
            'category_image' => $filename,
            'category_icon' => $request->category_icon,
            'category_order' => $request->category_order,
            'category_status' => $request->category_status
        ]);

        if ($create_category) {

            // delete old cache of categories and add new cache //
            caches_categories_helper($reset_caches = TRUE);

            session()->flash('msg', 'Add Category Successfully');
            return redirect('admin/category/showcategory');
        }
    }

    // Edit Category
    public function EditCategory($id)
    {
        $cate = Category::where('id', $id)->get();
        return view('backend.categories.edit_category', compact('cate'));
    }

    // Update Category 
    public function UpdateCategory(Request $request, $id)
    {

        $request->validate([
            'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'category_icon' => 'required|string',
            'category_order' => 'required|numeric| min: ' . $request->old_category_order . '|max:' . $request->old_category_order . '',
            'category_status' => 'required'
        ], ['category_order.min' => 'No change the order feild', 'category_order.max' => 'No change the order feild']);


        $prev_image = Category::where('id', $id)->first();
        $image_name = $prev_image->category_image;

        if ($request->category_image == null) {
            $filename = $image_name;
        } else {
            if (file_exists(public_path('upload/category/') . $image_name)) {
                unlink(public_path('upload/category/') . $image_name);
                // Image Upload
                $file = $request->category_image;
                $filename = GenerateSlug() . '.' . $file->getClientOriginalExtension();
                $file_path = public_path('\upload\category');
                $file->move($file_path, $filename);
            }
        }
        $update = Category::where('id', $id)->update([
            'category_name' => $request->category_name,
            'category_image' => $filename,
            'category_icon' => $request->category_icon,
            'category_order' => $request->category_order,
            'category_status' => $request->category_status
        ]);

        if ($update) {

            // delete old cache of categories and add new cache //
            caches_categories_helper($reset_caches = TRUE);

            session()->flash('msg', 'Update Category Successfully');
            return redirect('admin/category/showcategory');
        }
    }

    // Delete Category
    public function DelCategory($id)
    {
        $prev_image = Category::where('id', $id)->first();
        $image_name = $prev_image->category_image;

        if (file_exists(public_path('upload/category/') . $image_name)) {
            unlink(public_path('upload/category/') . $image_name);
        }

        $del = Category::where('id', $id)->delete();

        if ($del) {

            // delete old cache of categories and add new cache //
            caches_categories_helper($reset_caches = TRUE);

            session()->flash('msg', ' Delete Category Successfully');
            return redirect('admin/category/showcategory');
        }
    }
}
