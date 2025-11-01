<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Storage;
use DB;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    // Show Banners
    public function ShowBanners(Request $request)
    {
        if ($request->ajax()) {
            $banners = Banner::where('banner_status', 'A')->get();
            return DataTables::of($banners)
                ->addIndexColumn()
                ->addColumn('banner_image', function (Banner $banners) {
                    if (file_exists(public_path('upload/banner/') . $banners->banner_image) && $banners->banner_image) {
                        $url = asset("upload/banner/" . $banners->banner_image);
                        return '<img src="' . $url . '" width="40" height="40" />';
                    } else {
                        $url = asset("upload/banner/dummy.png");
                        return '<img src="' . $url . '" width="40" height="40" />';
                    }
                })
                ->addColumn('banner_start_text', function (Banner $banners) {
                    return $banners->banner_start_text;
                })
                ->addColumn('banner_title', function (Banner $banners) {
                    return $banners->banner_title;
                })
                ->addColumn('banner_subtitle', function (Banner $banners) {
                    return $banners->banner_subtitle;
                })
                ->addColumn('banner_btnlink', function (Banner $banners) {
                    return $banners->banner_btnlink;
                })
                ->addColumn('banner_status', function (Banner $banners) {

                    if ($banners->banner_status == "A") {
                        return "Active";
                    } else {
                        return "InActive";
                    }
                })
                ->addColumn('created_at', function (Banner $banners) {
                    $create = $banners->created_at->format('m/d/y');
                    return $create;
                })
                ->addColumn('action', function (Banner $banners) {
                    $btn = '<a href="' . route('admin.banner.editbanner', $banners->id) . '"  class="edit mx-3"><i class="fa fa-pen-alt"></i></a>';
                    $btn = $btn . ' <a href="' . route('admin.banner.deletebanner', $banners->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete customer?'" . ')"><i class="fa fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['banner_image', 'banner_start_text', 'banner_title', 'banner_subtitle', 'banner_btnlink', 'banner_status', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.banner.show_banners');
    }

    // Add Banner
    public function AddBanner()
    {
        return view('backend.banner.add_banner');
    }

    //Store Banner
    public function StoreBanner(Request $request)
    {
        $request->validate([
            'banner_image' => 'required'
        ]);
        // Banner Image Upload
        if ($request->hasFile('banner_image')) {
            $file = $request->banner_image;
            $storage_path = "/banner";
            $file = Storage::disk('upload')->put($storage_path, $file);
            $filename = basename($file);
        }
        $create_banner = Banner::create([
            'banner_start_text' => $request->banner_text,
            'banner_title' => $request->banner_title,
            'banner_subtitle' => $request->banner_subtitle,
            'banner_btnlink' => $request->banner_btnlink,
            'banner_image' => $filename
        ]);
            if($create_banner){
                session()->flash('msg','Add Banner Successfully');
                return redirect();
            }
    }

    // Edit Banner
    public function EditBanner($id)
    {
        $arr_pass['single_edit_banner'] = Banner::where('id',$id)->first();

        return view('backend.banner.edit_banner',$arr_pass);
    }

    // Update Banner
    public function UpdateBanner(Request $request)
    {
       
        $request->validate(['banner_image' => 'mimes:jpeg,jpg,png|max:1000']);

           // Thumbnail 
           $prev_image = Banner::where('id', $request->banner_id)->first();
           $thumbnail = $prev_image->banner_image;
           if ($request->hasFile('banner_image')) {
               if (file_exists(public_path('upload/banner/') . $thumbnail)) {
                   unlink(public_path('upload/banner/') . $thumbnail);
                   // Image Upload
                   $file = $request->banner_image;
                   $thumbnail = GenerateSlug() . '.' . $file->getClientOriginalExtension();
                   $file_path = public_path('\upload\banner');
                   $file->move($file_path, $thumbnail);
               } else {
                   $thumbnail;
               }
           }

         $update_banner = Banner::where('id',$request->banner_id)->update([
                'banner_start_text' => $request->banner_text,
                'banner_title' => $request->banner_title,
                'banner_subtitle' => $request->banner_subtitle,
                'banner_btnlink' => $request->banner_btnlink,
                'banner_status' => $request->banner_status,
           ]);

           if($update_banner){
                session()->flash('msg','Update Banner Successfully');
                return redirect('admin/banner/showbanners');
           }
    }

    // Delete Banner
    public function DelBanner($id)
    {
      
       $banner_single_detials = Banner::where('id',$id)->first();

       if(!empty($banner_single_detials)){

            if (file_exists(public_path('upload/banner/'. $banner_single_detials->banner_image))) {
                unlink(public_path('upload/banner/'. $banner_single_detials->banner_image));
            }
        }

       $del_banner = Banner::where('id',$id)->delete();

        if($del_banner){

            session()->flash('msg','Delete Banner Successfully');
            return redirect('admin/banner/showbanners');
        }
         
             
    }
}
