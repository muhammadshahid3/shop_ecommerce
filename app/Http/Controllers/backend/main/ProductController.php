<?php

namespace App\Http\Controllers\backend\main;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Additional_Details;
use App\Models\Product_images;
use App\Models\ProductRating;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;
use Exception;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
class ProductController extends Controller
{
    //Add Product
    public function AddProduct()
    {
        $category = Category::where('category_status', 'A')->get();
        $order = Product::where('product_status', 'A')->get();
        $summernote_editor = ['editor_css'];
        return view('backend.products.add_product', compact('category', 'order', 'summernote_editor'));
    }

    // Show Products
    public function AllProduct(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function (Product $data) {
                    $btn1 = '<div class="btn btn-group">';
                    $btn2 = '</div>';
                    $btn_eye = '<a href="' . route('admin.product.showproduct.singleproduct', $data->id) . '"  class="edit"><i class="fa fa-eye"></i></a>';
                    $btn = '<a href="' . route('admin.product.showproduct.editproduct', $data->id) . '"  class="edit mx-4"><i class="fa fa-pen"></i></a>';
                    $btn = $btn1 . $btn_eye . $btn . ' <a href="' . route('admin.product.showproduct.delproduct', $data->id) . '"  class="edit" onclick="return confirm(' . "'Are you sure want to delete product?'" . ')"><i class="fa fa-trash"></i></a>' . $btn2;
                    return $btn;
                })
                ->addColumn('thumbnail', function (Product $data) {
                    if (file_exists(public_path('upload/product/') . $data->product_thumbnail) && $data->product_thumbnail) {
                        $url = asset("upload/product/" . $data->product_thumbnail);
                        return '<img src="' . $url . '" width="40" height="40" />';
                    } else {
                        $url = asset("upload/product/dummy.png");
                        return '<img src="' . $url . '" width="40" height="40" />';
                    }
                })
                ->addColumn('category', function (Product $data) {
                    $category = Category::where('category_status', 'A')->get();
                    if (!empty($category)) {
                        if (count($category)) {
                            for ($i = 0; $i < count($category); $i++) {
                                if ($category[$i]->id == $data->category_id) {
                                    return $category[$i]->category_name;
                                }
                            }
                        }
                    }
                })

                ->addColumn('product_price' , function(Product $data){

                    return   '$' . GetTwodecimalHelper($data->product_price);
                })

                ->addColumn('product_stock_status', function (Product $data) {
                    if (!empty($data)) {
                        if ($data->product_stock_status == 'A') {
                            return "Available";
                        } else {
                            return "InAvailable";
                        }
                    }
                })
                ->addColumn('product_status', function (Product $data) {
                    if (!empty($data)) {
                        if ($data->product_status == 'A') {
                            return "Active";
                        } else {
                            return "InActive";
                        }
                    }
                })
                ->addColumn('create_at', function (Product $data) {
                    $create = $data->created_at->format('m/d/y');
                    return $create;
                })
                ->rawColumns(['action', 'thumbnail', 'create_at', 'category','product_price', 'product_stock_status', 'product_status'])
                ->make(true);
        }
        return view('backend.products.show_product');
    }

    // Store Product
    public function StoreProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|numeric',
            'product_name' => 'required|string',
            'product_old_price' => 'required|numeric',
            'product_price' => 'required|numeric',
            'product_thumbnail' => 'mimes:jpeg,jpg,png|max:1000|required',
            'product_status' => 'required',
            'product_description' => 'required',
            'product_manufacturer' => 'required',
            'product_supplier' => 'required',
            'product_weight' => 'required|string',
            'product_order' => 'required|numeric',
            'stock_quantity' => 'required|numeric',
            'product_stock_status' => 'required',
        ]);

        // Generate Slug
        $slug = GenerateSlug();
        // Product First Three letter generate
        $leters = substr($request->product_name, 0, 3);
        // Category id
        $category_id = $request->category_id;
        // Product Order
        $order = $request->product_order;
        //Product old price
        $old_price =  GetTwodecimalHelper($request->product_old_price);
        // Product price
        $price =  GetTwodecimalHelper($request->product_price);
        //Generate Product Code
        $product_code = $leters . $category_id . $order . $price;
        //Barcode Generate
        ProductBarcodeCode($product_code);
        // Thumbnail Generate
        if ($request->hasFile('product_thumbnail')) {
            $file = $request->product_thumbnail;
            $filename = GenerateSlug() . '.' . $file->getClientOriginalExtension();
            $file_path = public_path('\upload\product');
            $file->move($file_path, $filename);
        } else {
            $filename = null;
        }
        $create_product = Product::create([
            'product_slug' => $slug,
            'product_code' => $product_code,
            'product_barcode' => $product_code . '.png',
            'category_id' => $category_id,
            'product_name' => $request->product_name,
            'product_old_price' => $old_price,
            'product_price' => $price,
            'product_thumbnail' => $filename,
            'product_description' => $request->product_description,
            'product_manufacturer' => $request->product_manufacturer,
            'product_supplier' => $request->product_supplier,
            'product_weight' => $request->product_weight,
            'product_order' => $request->product_order,
            'stock_quantity' => $request->stock_quantity,
            'product_stock_status' => $request->product_stock_status,
            'product_status' => $request->product_status,
        ]);
        if ($create_product->id) {
            // Multi Images Upload
            if ($request->hasFile('product_imgs')) {
                if (count($request->product_imgs) > 0) {
                    for ($i = 0; $i < count($request->product_imgs); $i++) {
                        $file = $request->product_imgs[$i];
                        $filename = GenerateSlug() . '.' . $file->getClientOriginalExtension();
                        $file_path = public_path('\upload\product\gallery_imgs');
                        $file->move($file_path, $filename);
                        Product_images::create(['product_id' => $create_product->id, 'product_images' => $filename]);
                    }
                }
            }
            // Featured Products
            if ($request->featured == "1") {

                DB::table('product_features')->insert([
                    'product_id' => $create_product->id,
                    'category_id' => $create_product->category_id,
                    'created_at' => Carbon::now()->timezone('Asia/Karachi'),
                    'updated_at' => Carbon::now()->timezone('Asia/Karachi')

                ]);

            }
            // Trending Products
            if ($request->trending == 1) {

                DB::table('product_newarrivals')->insert([
                    'product_id' => $create_product->id,
                    'category_id' => $create_product->category_id,
                    'created_at' => Carbon::now()->timezone('Asia/Karachi'),
                    'updated_at' => Carbon::now()->timezone('Asia/Karachi')
                ]);

            }
            // Top Sellers Products
            if ($request->topsellers == 1) {

                DB::table('product_topsellers')->insert([
                    'product_id' => $create_product->id,
                    'category_id' => $create_product->category_id,
                    'created_at' => Carbon::now()->timezone('Asia/Karachi'),
                    'updated_at' => Carbon::now()->timezone('Asia/Karachi')
                ]);
            }
            // Additional Details Add
            if (isset($request->attribute[0]) != null) {
                if (count($request->attribute) > 0) {
                    for ($i = 0; $i < count($request->attribute); $i++) {

                        Product_Additional_Details::create([
                            'product_id' => $create_product->id,
                            'category_id' => $create_product->category_id,
                            'attribute' => $request->attribute[$i],
                            'detail' => $request->detail[$i]
                        ]);
                    }
                }
            }

            // Create Stock Transaction 
            StockTransaction::create([
                'product_id' => $create_product->id,
                'prev_qnty' => 0,
                'new_qnty' => $request->stock_quantity,
                'transaction_type' => 'purchase'
            ]);

            session()->flash('msg', 'Add Product Successfully');
            return redirect('admin/product/showproduct');
        }
    }


    // Edit Product
    public function EditProduct($product_id)
    {
        $array_pass = array();
        $editproduct_record = Product::where('id', $product_id)->first();
        $category_id = $editproduct_record->category_id;
        $trending_products = ProductFeatured($category_id, $product_id);
        $category = Category::all();
        $array_pass['additional_details'] = Product_Additional_Details::where('product_id', $product_id)->get();
        $array_pass['editproduct_record'] = $editproduct_record;
        $array_pass['category'] = $category;
        $array_pass['trending_products'] = $trending_products;

        return view('backend.products.edit_product', $array_pass);
    }

    //Update Product
    public function UpdateProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|numeric',
            'product_name' => 'required|string',
            'product_old_price' => 'required|numeric',
            'product_price' => 'required|numeric',
            'product_stock_status' => 'required',
            'product_description' => 'required',
            'product_manufacturer' => 'required',
            'product_supplier' => 'required',
            'product_weight' => 'required|string',
            'product_order' => 'required|numeric| min: ' . $request->old_product_order . '|max:' . $request->old_product_order . '',
            'product_status' => 'required',
        ], ['product_order.min' => 'No change the order feild', 'product_order.max' => 'No change the order feild']);

        $id = $request->product_id;

        // Thumbnail 
        $prev_image = Product::where('id', $request->product_id)->first();
        $thumbnail = $prev_image->product_thumbnail;
        if ($request->hasFile('product_thumbnail')) {
            if (file_exists(public_path('upload/product/') . $thumbnail)) {
                unlink(public_path('upload/product/') . $thumbnail);
                // Image Upload
                $file = $request->product_thumbnail;
                $thumbnail = GenerateSlug() . '.' . $file->getClientOriginalExtension();
                $file_path = public_path('\upload\product');
                $file->move($file_path, $thumbnail);
            } else {
                $thumbnail;
            }
        }
        // Generate Slug
        $slug = $request->slug;
        // Product First Three letter generate
        $leters = substr($request->product_name, 0, 3);
        // Category id
        $category_id = $request->category_id;
        // Product Order
        $order = $request->product_order;
        //Product old price
        $old_price = GetTwodecimalHelper($request->product_old_price);
        // Product price
        $price =  GetTwodecimalHelper($request->product_price);
        //Generate Product Code
        $product_code = $leters . $category_id . $order . $price;
        // Delete  product barcode img
        if (file_exists(public_path('upload/product_barcode/' . $request->old_product_barcode))) {
            unlink(public_path('upload/product_barcode/' . $request->old_product_barcode));
        }
        // Generate Barcode
        ProductBarcodeCode($product_code);

        $update = Product::where('id', $request->product_id)->update([
            'product_slug' => $slug,
            'product_code' => $product_code,
            'product_barcode' => $product_code . '.png',
            'category_id' => $category_id,
            'product_name' => $request->product_name,
            'product_old_price' => $old_price,
            'product_price' => $price,
            'product_thumbnail' => $thumbnail,
            'product_description' => $request->product_description,
            'product_manufacturer' => $request->product_manufacturer,
            'product_supplier' => $request->product_supplier,
            'product_weight' => $request->product_weight,
            'product_order' => $request->product_order,
            'product_stock_status' => $request->product_stock_status,
            'product_status' => $request->product_status,
        ]);

        if ($update) {
            // Featured Products
            if ($request->featured) {
                // Delete ProductFeatured
                DB::table('product_features')->where('product_id', $id)
                    ->delete();

                // Create ProductFeatured
                DB::table('product_features')->where('product_id', $id)
                    ->insert([
                        'product_id' => $id,
                        'category_id' => $request->category_id,
                        'created_at' => Carbon::now()->timezone('Asia/Karachi'),
                        'updated_at' => Carbon::now()->timezone('Asia/Karachi')
                    ]);
            } else {
                DB::table('product_features')->where('product_id', $id)
                    ->delete();
            }

            // New Arrivals Products
            if ($request->newarrivals) {
                // Delete Product_New arrivals
                DB::table('product_newarrivals')->where('product_id', $id)
                    ->delete();

                // Create Product_New arrivals
                DB::table('product_newarrivals')->where('product_id', $id)
                    ->insert([
                        'product_id' => $id,
                        'category_id' => $request->category_id,
                        'created_at' => Carbon::now()->timezone('Asia/Karachi'),
                        'updated_at' => Carbon::now()->timezone('Asia/Karachi')
                    ]);
            } else {
                DB::table('product_newarrivals')->where('product_id', $id)
                    ->delete();
            }

            // Top sellers Products
            if ($request->topsellers) {
                // Delete Top sellers Products
                DB::table('product_topsellers')->where('product_id', $id)
                    ->delete();

                // Create Top sellers Products
                DB::table('product_topsellers')->where('product_id', $id)
                    ->insert([
                        'product_id' => $id,
                        'category_id' => $request->category_id,
                        'created_at' => Carbon::now()->timezone('Asia/Karachi'),
                        'updated_at' => Carbon::now()->timezone('Asia/Karachi')
                    ]);
            } else {
                DB::table('product_topsellers')->where('product_id', $id)
                    ->delete();
            }

            // Product images
            if ($request->hasFile('product_images')) {

                $prev_pro_image = Product_images::where('product_id', $id)->get();
                Product_images::where('product_id', $id)->delete();
                if (count($prev_pro_image)) {
                    // Delete image in file system
                    for ($i = 0; $i < count($prev_pro_image); $i++) {
                        if (file_exists(public_path('upload/product/gallery_imgs/' . $prev_pro_image[$i]->product_images))) {
                            unlink(public_path('upload/product/gallery_imgs/' . $prev_pro_image[$i]->product_images));
                        }
                    }
                }
                // Create Images
                if (count($request->product_images) > 0) {

                    for ($i = 0; $i < count($request->product_images); $i++) {

                        $file = $request->product_images[$i];
                        $image_name[] = GenerateSlug() . '.' . $file->getClientOriginalExtension();
                        $file_path = public_path('\upload\product\gallery_imgs');
                        $file->move($file_path , $image_name[$i]);

                        Product_images::create([
                            'product_id' => $id,
                            'product_images' => $image_name[$i]
                        ]);
                    }
                }
            }


            // Additional Details Add
            if ($request->attribute != null) {
                if (count($request->attribute) > 0) {
                    // Delete Product Additional Details
                    Product_Additional_Details::where('product_id', $id)->delete();

                    // Create Product Additional Details
                    for ($i = 0; $i < count($request->attribute); $i++) {

                        Product_Additional_Details::create(['product_id' => $id, 'category_id' => $request->category_id, 'attribute' => $request->attribute[$i], 'detail' => $request->detail[$i]]);
                    }
                }
            } else {
                Product_Additional_Details::where('product_id', $id)->delete();
            }

            session()->flash('msg', 'Update Product Successfully');
            return redirect('admin/product/showproduct');
        }
    }


    // Single Product
    public function SingleProduct($id)
    {
        $single_product = Product::where('id', $id)->first();
        return view('backend.products.single_product', compact('single_product'));
    }

    // Product Featured
    public function ProductFeatured()
    {
        $featured = Featured();
        return view('backend.products.show_featured', compact('featured'));
    }

    // Delete Product Featured
    public function DelFeatured(Request $request)
    {
        DB::table('product_features')->where('id', $request->old_featured_id)->delete();
        session()->flash('msg', 'Delete Product Featured Succesfully');
        return redirect('admin/product/featured');
    }

    // Product Arrivals
    public function ProductArrivals()
    {
        $arrivals = Arrivals();
        return view('backend.products.show_arrivals', compact('arrivals'));

    }

    // Delete Product Arrivals
    public function Delarrival(Request $request)
    {
        DB::table('product_newarrivals')->where('id', $request->old_arrivals_id)->delete();
        session()->flash('msg', 'Delete Product Arrival Succesfully');
        return redirect('admin/product/new-arrivals');

    }

    // Product Top Sellers
    public function ProductTopSellers()
    {
        $topsellers = TopSellers();
        return view('backend.products.show_topsellers', compact('topsellers'));
    }

    // Delete Product Top Sellers
    public function DelTopSeller(Request $request)
    {
        DB::table('product_topsellers')->where('id', $request->old_topsellers_id)->delete();
        session()->flash('msg', 'Delete Product Top Seller Succesfully');
        return redirect('admin/product/new-arrivals');
    }
    // Delete Product
    public function DelProduct($id)
    {

        // Gallery Imgs Delete
        $product_imgs = Product_images::where('product_id', $id)->get();
        if (count($product_imgs)) {
            for ($i = 0; $i < count($product_imgs); $i++) {
                if (file_exists(public_path('upload/product/gallery_imgs/' . $product_imgs[$i]->product_images))) {
                    unlink(public_path('upload/product/gallery_imgs/' . $product_imgs[$i]->product_images));
                }
            }
        }

        Product_images::where('product_id', $id)->delete();

        // Product Img Delete
        $product_img = Product::where('id', $id)->first();
        if (!empty($product_img)) {
            if (file_exists(public_path('upload/product/' . $product_img->product_thumbnail))) {
                unlink(public_path('upload/product/' . $product_img->product_thumbnail));
            }
            // Barcode image delete in file
            if (file_exists(public_path('upload/product_barcode/' . $product_img->product_barcode))) {
                unlink(public_path('upload/product_barcode/' . $product_img->product_barcode));
            }
        }

        // Delete Product Featured
        DB::table('product_features')->where('product_id', $id)->delete();

        // Delete Product New Arrivals
        DB::table('product_newarrivals')->where('product_id', $id)->delete();

        // Delete Product Top Sellers
        DB::table('product_topsellers')->where('product_id', $id)->delete();

        // Delete Product Additional Details
        Product_Additional_Details::where('product_id', $id)->delete();

        // Product Rating
        ProductRating::where('product_id', $id)->delete();

        // Delete Product Record
        $del_product = Product::where('id', $id)->delete();
        if ($del_product) {
            session()->flash('msg', 'Delete Product Successfully');
            return redirect('admin/product/showproduct');
        }
    }

    // Show Product Stock
    public function index()
    {
        $arr_pass = array();

        $arr_pass['categories'] = Category::get();

        return view('backend.product_stock.show_stock', $arr_pass);
    }

    // Stock Qnty handle
    public function StockQnty(Request $request)
    {
        $html_content = '';
        $html_content = $html_content . '<input type=number class="form-control" id="new_Stock_qnty" min= "0" name="" value="' . $request->stock_value . '">';

        if ($html_content) {
            $stock_qnty['status'] = 200;
            $stock_qnty['product_stock_qnty'] = $html_content;
        } else {
            $stock_qnty['status'] = 404;
        }

        return response()->json($stock_qnty);

    }

    // Save Product qnty
    public function SaveStock(Request $request)
    {
        $product_details = Product::where('id', $request->product_id)->first();

        if ($request->new_stock_qnty == $product_details->stock_quantity ) {

            $arr_pass['message'] = 'Stock Quantity Not Update';
            $arr_pass['status'] = 204;

        } else {
            if ($request->new_stock_qnty > $product_details->stock_quantity) {

                $prev_stock_qnty = $request->old_stock_qnty;
                $update_stock_qnty = $request->new_stock_qnty;
                $transacion_type = 'purchase';

            } else {

                $prev_stock_qnty = $request->old_stock_qnty;
                $update_stock_qnty = $request->new_stock_qnty;
                $transacion_type = 'remove';
            }

            Product::where('id', $request->product_id)->update(['stock_quantity' => $request->new_stock_qnty]);

            StockTransaction::create([
                'product_id' => $request->product_id,
                'prev_qnty' => $prev_stock_qnty,
                'new_qnty' => $update_stock_qnty,
                'transaction_type' => $transacion_type
            ]);

            $arr_pass['message'] = 'Update Stock Quantity Successfully';
            $arr_pass['status'] = 200;

        }
        return response()->json($arr_pass);
    }

    // Check and Set Stock
    public function CategoryFetch($category_id)
    {
        $category = '<option value="" selected>choose this one</option>';
        $category_details = Product::where('category_id', $category_id)->get();

        foreach ($category_details as $category_details_data) {

            $category = $category .
                '<option value="' . $category_details_data->id . '">' . $category_details_data->product_name . '
             </option>';
        }

        if ($category) {
            $category_data['response'] = 200;
            $category_data['categories'] = $category;
        } else {
            $category_data['status'] = 404;
        }

        return response()->json($category_data);

    }

    // Check Product Stock
    public function ProductFetch($product_id)
    {
        $product = '';
        $checkbox = '';
        $product_details_item = Product::where('id', $product_id)->first();

        // foreach ($product_details as $product_details_item) {
            if ($product_details_item->product_code && $product_details_item->product_name) {
                if($product_details_item->product_stock_status == 'A'){
                    $product = $product . '
                    <tr>
                       <input type="hidden" id="product_stock_id" value="' . $product_details_item->id .'">
                       <td><input type="checkbox" name="" id="check_allow_stock" value="check_allow_stock"></td>
                       <td>' . $product_details_item->product_code . '</td>
                       <td>' . $product_details_item->product_name . '</td>
                       <td><input type="number" id="stocsk_value" disabled value = "' . $product_details_item->stock_quantity .'" style="width:60px;"/></td>
                   </tr>';
                }else if($product_details_item->product_stock_status == 'I'){
                    $product = $product . '
                    <tr>
                       <input type="hidden" id="product_stock_id"  value="' . $product_details_item->id .'">
                       <td><input type="checkbox" name="" id="check_allow_stock" checked value="' . $product_details_item->id .'"></td>
                       <td>' . $product_details_item->product_code . '</td>
                       <td>' . $product_details_item->product_name . '</td>
                       <td><input type="number" id="stock_value" disabled value = "' . $product_details_item->stock_quantity .'" style="width:60px;"/></td>
                   </tr>';
                }else{
                    $product = $product . '
                    <tr>
                       <input type="hidden" id="product_stock_id" value="' . $product_details_item->id .'">
                       <td><input type="checkbox" name="" id="check_allow_stock" checked value="' . $product_details_item->id .'"></td>
                       <td>' . $product_details_item->product_code . '</td>
                       <td>' . $product_details_item->product_name . '</td>
                       <td><input type="number" id="stock_value" disabled value = "' . $product_details_item->stock_quantity .'" style="width:60px;"/></td>
                   </tr>';
                }
            }
        // }

        if ($product) {
            $product_data['response'] = 200;
            $product_data['products'] = $product;
        } else {
            $product = '<p">Data Not Found</p>';
            $product_data['response'] = $product;
            $product_data['status'] = 404;
        }

        return response()->json($product_data);

    }

    // Stock Mangement Handle Function

    public function ProductStockManage(Request $request)
    {
        $response = [];
        try{
            if($request->checkbox_value == 'check_allow_stock' && $request->checkbox_value != null && $request->stock_value == 0 ){
                Product::where('id', $request->product_stock_id)->update(['product_stock_status' => 'I']);
                $response['statuscode'] = 200;
                $response['icon'] = 'success';
                $response['success'] = 'Stock Apply Successfully';
            }else if( $request->checkbox_value == '' &&  $request->stock_value == 0){
                Product::where('id', $request->product_stock_id)->update(['product_stock_status' =>'A']);
                $response['statuscode'] =200;
                $response['icon'] = 'success';
                $response['success'] = 'Stock Apply Successfully';
            }else{
                $response['statuscode'] = 400;
                $response['icon'] = 'warning';
                $response['success'] = 'Stock Not Apply';
            }
       
            return response()->json($response);

        }catch(Exception $e){
            $message = $e->getMessage();
            var_dump("Error", $message);
        }
      
    }

}
