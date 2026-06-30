<?php

namespace App\Http\Controllers\frontend\website;

use App\Http\Controllers\Controller;
use App\Models\Product_images;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Validator;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\GeneralSetting;
use Exception;
use auth;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Collection;
// use Illuminate\Pagination\Paginator;
// use Illuminate\Pagination\LengthAwarePaginator;


class WebProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customers');
    }
    // 404 page not found //
    public function Page404()
    {
        
        // header data //
        $array_pass = header_helper('Page 404');
        return view('frontend.website.404', $array_pass);
    }

    // category products //
    public function CategoryProducts($category_slug )
    {
        
        // get single category //
        $category_single = DB::table('categories')->where('category_slug', $category_slug)->first();
        // get all categories
        $all_categories = Category::latest()->get();
        if ($category_single && !empty($category_single) && $category_single != null) {
                //  get category wise products
                $products = DB::table('products')
                ->join('categories','products.category_id' , '=', 'categories.id')
                ->select('categories.*','products.*')
                ->where('products.product_status', 'A')
                ->orderBy('products.category_id', 'Desc')
                ->get();

            // get products collection //
            $products_collection = DB::table('products')->where('category_id', $category_single->id)->get();

            if ($products_collection && !$products_collection->isEmpty() && $products_collection != null) {

                // header data //
                $array_pass = header_helper(ucwords($category_single->category_name));
                // Frontend Changes form Admin side
                $cms_text  =  EditContent();
                if(isset($cms_text) && count($cms_text) > 0){
                    $array_pass['cms_texts'] = $cms_text;
                }

                $array_pass['category_single'] = $category_single;
                $array_pass['products_collection'] = $products_collection;
                $array_pass['allcategories'] = $all_categories;
                $array_pass['category_products'] = $products;
        
                return view('frontend.product.products', $array_pass);
            } else {
                return $this->Page404();
            }
        } else {
            return $this->Page404();
        }
    }

    // product detail //
    public function ProductDetail(Request $request, $product_slug)
    {
        
        // header data 
        $product_single_item = DB::table('products')->where('product_slug', $product_slug)->first();
        // Single Product Rating Reviews
        // $product_single_reviews =  $this->SingleProductRating($product_single_item);
        $product_reviews = SingleProductRating($product_single_item->id,$product_single_item->category_id);
        // dd($product_reviews);
        $array_pass = header_helper(ucwords($product_single_item->product_name));

        $array_pass['related_products'] = DB::table('products')->where('category_id', $product_single_item->category_id)->orderBy('id', 'DESC')->limit(4)->get();
        // dd($array_pass);
        $product_list = Product::with('Categories')
            ->with('Product_Images')
            ->with('ProductAdditionalDetails')
            ->where('product_slug', $product_slug)
            ->get();

        if ($product_list && !empty($product_list) && $product_list != null) {
            $cms_text  = EditContent();
            if(isset($cms_text) && count($cms_text) > 0){
                $array_pass['cms_texts'] = $cms_text;
            }
            $array_pass['product_single'] = $product_list;
            $array_pass['single_product_review'] = $product_reviews['single_reviews_count'];
            $array_pass['fill_count_stars'] = $product_reviews['fill_count_stars'];
            $array_pass['unfill_count_stars'] = $product_reviews['unfill_count_stars'];

            return view('frontend.product.productdetail', $array_pass);
        } else {

            return $this->Page404();
        }
        
    }

    // Customer Ratng Product
    public function ProductRating(Request $request)
    {
        $response = [];
        $validaor = Validator::make($request->all(), [
            'stars' => 'required',
            'review_message' => 'required|string'
        ]);

        if ($validaor->fails()) {

            return response()->json(['error' => $validaor->errors()]);
        }

        try{
            $customer = auth()->guard('customers')->user();
            $product_detail =  Product::where(['id' => $request->product_id , 'category_id' => $request->category_id])->first();
            if(isset($product_detail) && !empty($product_detail) && $product_detail != null){
            $customer_review = ProductRating::where(['customer_id' => $customer->id , 'category_id' => $request->category_id , 'product_id' => $request->product_id])->get();
               if(count($customer_review) > 0 ){
                $response['statuscode'] = 204;
                $response['icon'] = "warning";
                $response['message'] = "Already Reviews Send";
                return response()->json($response);
               }else{
                ProductRating::create([
                'category_id' => $request->category_id,
                'product_id' => $request->product_id,
                'customer_id' => $customer->id,
                'stars' => $request->stars,
                'review_message' => $request->review_message,
                ]);

                $response['statuscode'] = 200;
                $response['icon'] = "success";
                $response['message'] = "Customer Send Reviews Successfully";
                return response()->json($response);
               }
    
            }else{
                $response['statuscode'] = 204;
                $response['icon'] = "warning";
                $response['message'] = "Reviews Not Send";
                return response()->json($response);
            }
        }catch(Exception $e){
            $message = $e->getMessage();
            var_dump("error", $message);
        }

    }

    // Avg Rating Products
    public function AvgRating(Request $request)
    {
        $response = [];
        $rating_star_one = 0;
        $rating_star_two = 0;
        $rating_star_three = 0;
        $rating_star_four = 0;
        $rating_star_five = 0;
        $totalReviews  = 0;
    
        // Latest Rating Reviews
        $latest_reviews  = DB::table('product_ratings')
        ->leftjoin('customers','product_ratings.customer_id', '=' , 'customers.id')
        ->latest('product_ratings.id')
        ->get();
        //  get all rating starts 
        $product_rating_star =  ProductRating::select('stars')->get();
        $product_rating = $product_rating_star->avg('stars');
        $product_reviews_count = $product_rating_star->count();
            foreach ($product_rating_star as $key => $star) {
                if((int)$star->stars == 1){
                    $rating_star_one = (int) $rating_star_one +  (int)$star->stars;
                }else if((int)$star->stars == 2){
                    $rating_star_two = (int)$rating_star_two + (int)$star->stars;

                }else if((int)$star->stars == 3){
                    $rating_star_three = (int)$rating_star_three + (int)$star->stars;

                }else if((int)$star->stars == 4){
                    $rating_star_four = (int)$rating_star_four + (int)$star->stars;

                }else if((int)$star->stars == 5){
                    $rating_star_five = (int)$rating_star_five + (int)$star->stars;
                }
            }

            // Total Rating Reviews
            $totalReviews  =  $totalReviews +  $rating_star_one + $rating_star_two +  $rating_star_three +  $rating_star_four + $rating_star_five;
            // i will get single signle rating star percentage
            if($totalReviews  > 0){
                // Calculate percentage for each star rating
                $percentOneStar = ($rating_star_one / $totalReviews) * 100;
                $percentTwoStar = ($rating_star_two / $totalReviews) * 100;
                $percentThreeStar = ($rating_star_three / $totalReviews) * 100;
                $percentFourStar = ($rating_star_four / $totalReviews) * 100;
                $percentFiveStar = ($rating_star_five / $totalReviews) * 100;
            }
            
                $response['statuscode'] = 200;
                $response['reviews_count']   =  $product_reviews_count;
                $response['latest_reviews'] =  $latest_reviews ;
                $response['avg_rating']      =  round($product_rating, 1);
                $response['rating_one_star'] =  round($percentOneStar,2);
                $response['rating_two_star'] =  round($percentTwoStar,2);
                $response['rating_three_star'] = round($percentThreeStar,2);
                $response['rating_four_star'] =  round($percentFourStar,2);
                $response['rating_five_star'] =  round($percentFiveStar ,2);
        
                return response()->json($response);
    }

    // All Product Ratings
    public function AllRating()
    {
        $array_pass = [];
        $fill_star = '';
        $unfill_star = '';
        try{
            $array_pass = header_helper('all ratings');
           $all_ratings = DB::table('product_ratings')
           ->leftjoin('customers','product_ratings.customer_id', '=' , 'customers.id')
           ->latest('product_ratings.id')
           ->get();
           $array_pass['allratings'] = $all_ratings;
            return view('frontend.product.productratings',$array_pass);

        }catch(Exception $e){
            $message = $e->getMessage();
            var_dump("Error" , $message);
        }
      
    }

    // Products
    public function Products()
    {
        $array_pass = [];
        // get all categories
        $all_categories = Category::latest()->get();
        $array_pass = header_helper(ucwords('products'));
        $products = DB::table('products')
        ->join('categories','products.category_id' , '=', 'categories.id')
        ->select('categories.*','products.*')
        ->where('products.product_status', 'A')
        ->orderBy('products.category_id', 'Desc')
        ->get();

        if(isset($all_categories) && $all_categories !=null && isset($products) && $products != null){
            // Frontend Changes form Admin side
            $cms_text  =  EditContent();
            if(isset($cms_text) && count($cms_text) > 0){
                $array_pass['cms_texts'] = $cms_text;
            }
            $array_pass['allcategories'] = $all_categories;
            $array_pass['category_products'] = $products;
            return view('frontend.product.shopproducts', $array_pass);
        }else{
            return $this->Page404();
        }

    }

    // Products Filter
    public function ProductFilter(Request $request)
    {
        $response = [];
        $product_list_arr = [];
        $products_rating = [];
        $new_product_array = [];
        $perPage = 9; // Items per page
        $page = $request->get('page', 1); // Current page, defaults to 1

        $offset = ($page - 1) * $perPage;
        // Get all categories
        $categories = Category::get();
        $products = Product::skip($offset)->take($perPage)->get();
        $total_product_count =  Product::count(); // Total records

        if(isset($products) && !empty($products) && $products != null && isset($categories) && $categories !=null){

            foreach ($categories as $key => $category_list) {
                $product_count = 0;
                foreach ($products  as $key => $product_list) {
                    if($product_count < $page){
                        if($category_list->id == $product_list->category_id){
                           
                            $product_count = $product_count + 1;
                            $product_list_arr[] = DB::table('products')
                            ->join('categories','products.category_id' , '=', 'categories.id')
                            ->inRandomOrder()
                            ->select('categories.*','products.*')
                            ->where('products.category_id',$category_list->id)
                            ->where('products.product_status', 'A')
                            ->orderBy('products.id','desc')
                            // ->take($counter_value)  
                            ->first();  
                        }      
                    }
                }
            }             
                // Sufflling the array 
                shuffle($product_list_arr);
            // Single product Rating 
            foreach($product_list_arr as $index => $product_rating) {
                $products_rating[] = SingleProductRating($product_rating->id,$product_rating->category_id);
                $new =  $products_rating[$index] ?? null;
                $new_product_array[] = array_merge((array)$product_list_arr[$index], (array)$new);
            } 

             
            $response['statuscode'] = 200;
            $response['products_filter'] =   $new_product_array;
            $response['pagination'] = ['current_page' =>  $page,  'total_product_count' =>   $total_product_count, 'per_page' => $perPage,  'last_page' => ceil(  $total_product_count / $perPage)];


        }else{
            $response['statuscode'] = 500;
        }

        return response()->json($response);

    }

    //  Filter Categories
    public function FilterCategory(Request $request)
    {   
       $response = [];
       $filter_products_rating = [];
       $new_filter_product_array = [];
       $category = DB::table('categories')->where('category_slug',$request->category_slug)->first();
       $get_category_name   = $this->AddClass($category);
    
       // Pagination   
        // Total Products Count
        $total_product_count = $this->ProductCount($request);
        if($total_product_count == null){
            $total_product_count =  DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->where('category_id',$category->id)
            ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
            ->count();
        }
       $perPage = 9; // Items per page
       $page = $request->get('page', 1); // Current page, defaults to 1
       $offset = ($page - 1) * $perPage;
       $product_category = DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->where('category_id',$category->id)
            ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
            ->orWhere(function ($query) use ($request){
                if($request->price_filter_status == 'true'){
                    $price_amount   =  explode("-",$request->price_amount);
                    $first_amount   =  json_decode($price_amount[0]);
                    $second_amount  = json_decode($price_amount[1]);
                    $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                        ->whereBetween('product_price',[$first_amount,$second_amount]);
                }
            })
            ->orWhere(function ($query) use ($request){
                if($request->stock_filter_status == 'true'){
                    if($request->in_stock == 'A'){
                        $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']]);
                    }else if($request->out_stock == 'I'){
                        $query->orwhere('stock_quantity','=' , 0)
                                ->orWhere('product_stock_status', '=' , 'I')
                                ->orWhere('product_status', '=' , 'I');
                    }elseif($request->in_stock == 'A' && $request->out_stock == 'I' ){
                                $query->orWhere('product_status', '=' , 'A')
                                    ->orWhere('product_status', '=' , 'I');
                    }else{}
                }

            })
            ->select('products.*','categories.category_name','categories.category_slug')
            ->skip($offset)
            ->take($perPage)
            ->get()->toArray();
             // Single product Rating 
            foreach( $product_category  as $index => $product_rating) {
                $filter_products_rating [] = SingleProductRating($product_rating->id,$category->id);
                $new =     $filter_products_rating [$index] ?? null;
                $new_filter_product_array [] = array_merge((array)$product_category[$index], (array)$new);
            }
          
       if(isset($product_category) && !empty($product_category) && $product_category != null){
          
        $response['statuscode'] = 200;
        $response['products_filter'] =  $new_filter_product_array;
        $response['category_name']    =  $get_category_name;
        $response['pagination'] = ['current_page' =>  $page,  ' total_product_count' =>   $total_product_count, 'per_page' => $perPage,  'last_page' => ceil(  $total_product_count / $perPage)];
       }else{
        $response['statuscode'] = 500;
       }
        return response()->json($response);
    }

     //  PriceFilter
     public function PriceFilter(Request $request)
     {
      
        $response = [];
        $price_products_rating = [];
        $new_price_product_array = [];
        $price_amount  =  explode("-",$request->price_amount);
        $first_amount  = json_decode($price_amount[0]);
        $second_amount  = json_decode($price_amount[1]);
         // Pagination   
        // Total Products Count
        $total_product_count = $this->ProductCount($request);
        if($total_product_count == null){
           $total_product_count = DB::table('products')
            ->join('categories','products.category_id' , '=', 'categories.id')
            ->select('categories.*','products.*')
            ->orderBy('products.category_id', 'Desc')
            ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
            ->whereBetween('product_price',[$first_amount,$second_amount])
            ->orWhere(function ($query) use ($request){
                $category_detail = Category::where('category_slug',$request->category_slug)->first();
                    if(isset($category_detail)){
                        $query ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                        ->where('products.category_id',$category_detail->id);
                    }
            })->count();
        }
       $perPage = 9; // Items per page
       $page = $request->get('page', 1); // Current page, defaults to 1
       $offset = ($page - 1) * $perPage;
        $products = DB::table('products')
        ->join('categories','products.category_id' , '=', 'categories.id')
        ->select('categories.*','products.*')
        ->orderBy('products.category_id', 'Desc')
        ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
        ->whereBetween('product_price',[$first_amount,$second_amount])
        ->orWhere(function ($query) use ($request){
            if($request->stock_filter_status == 'true'){
                if($request->in_stock == 'A'){
                    $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']]);
                }else if($request->out_stock == 'I'){
                    $query->orwhere('stock_quantity','=' , 0)
                            ->orWhere('product_stock_status', '=' , 'I')
                            ->orWhere('product_status', '=' , 'I');
                }elseif($request->in_stock == 'A' && $request->out_stock == 'I' ){
                            $query->orWhere('product_status', '=' , 'A')
                                ->orWhere('product_status', '=' , 'I');
                }else{}
            }
        })
        ->orWhere(function ($query) use ($request){
            $category_detail = Category::where('category_slug',$request->category_slug)->first();
                if(isset($category_detail)){
                    $query ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                    ->where('products.category_id',$category_detail->id);
                }
        })
          ->skip($offset)
          ->take($perPage)
          ->get()->toArray();
            // Single product Rating 
            foreach($products as $index => $product_rating) {
                $price_products_rating [] = SingleProductRating($product_rating->id,$product_rating->category_id);
                $new =     $price_products_rating [$index] ?? null;
                $new_price_product_array [] = array_merge((array)$products[$index], (array)$new);
            }
            // dd($new_price_product_array);
            if(count($products) > 0){
            $response['statuscode'] = 200;
            $response['filtering_data'] = $new_price_product_array;
            $response['pagination'] = ['current_page' =>  $page,  ' total_product_count' =>   $total_product_count, 'per_page' => $perPage,  'last_page' => ceil(  $total_product_count / $perPage)];

            }else{
                $response['statuscode'] = 500;
            }

            return response()->json($response);
     }

    //  Stock Filter
    public function StockFilter(Request $request)
    {

        $response = [];
        $stock_products_rating = [];
        $new_stock_product_array = [];

       if($request->in_stock == 'A'){
        // Total Products Count
        $total_product_count = $this->ProductCount($request);
         $perPage = 9; // Items per page
         $page = $request->get('page', 1); // Current page, defaults to 1
         $offset = ($page - 1) * $perPage;
       
            // dd($total_product_count);
        $product_stock  = $this->InStock($request,$offset,$perPage);
       // Single product Rating 
       foreach($product_stock  as $index => $product_rating) {
            $stock_products_rating[] = SingleProductRating($product_rating->id,$product_rating->category_id);
            $new =       $stock_products_rating[$index] ?? null;
            $new_stock_product_array[] = array_merge((array)$product_stock [$index], (array)$new);
        }   
        $response['statuscode'] = 200;
        $response['product_stock_data'] = $new_stock_product_array;
        $response['pagination'] = ['current_page' =>  $page,  ' total_product_count' =>  $total_product_count, 'per_page' => $perPage,  'last_page' => ceil( $total_product_count / $perPage)];
       
       }else if($request->out_stock == 'I'){
            // Total Products count
            $total_product_count = $this->ProductCount($request);
          // Pagination Code
          $perPage = 9; // Items per page
          $page = $request->get('page', 1); // Current page, defaults to 1
          $offset = ($page - 1) * $perPage;

        $product_stock = $this->OutStock($request,$offset,$perPage);
           // Single product Rating 
        foreach($product_stock  as $index => $product_rating) {
            $stock_products_rating[] = SingleProductRating($product_rating->id,$product_rating->category_id);
            $new =       $stock_products_rating[$index] ?? null;
            $new_stock_product_array[] = array_merge((array)$product_stock [$index], (array)$new);
        } 

        $response['statuscode'] = 200;
        $response['product_stock_data'] =  $new_stock_product_array;
        $response['pagination'] = ['current_page' =>  $page,  ' total_product_count' =>   $total_product_count, 'per_page' => $perPage,  'last_page' => ceil(  $total_product_count / $perPage)];
      

       }elseif($request->in_stock == 'A' &&  $request->out_stock == 'I'){
        // Total Products count
        $total_product_count = $this->ProductCount($request);
          // Pagination Code
        $perPage = 9; // Items per page
        $page = $request->get('page', 1); // Current page, defaults to 1
        $offset = ($page - 1) * $perPage;
        $product_stock = $this->InStock_OutStock($request);
        // Single product Rating 
        foreach($product_stock  as $index => $product_rating) {
            $stock_products_rating[] = SingleProductRating($product_rating->id,$product_rating->category_id);
            $new =       $stock_products_rating[$index] ?? null;
            $new_stock_product_array[] = array_merge((array)$product_stock [$index], (array)$new);
        } 
        $response['statuscode'] = 200;
        $response['product_stock_data'] = $new_stock_product_array;
        $response['pagination'] = ['current_page' =>  $page,  ' total_product_count' =>   $total_product_count, 'per_page' => $perPage,  'last_page' => ceil(  $total_product_count / $perPage)];


       }else{
        $response['statuscode'] = 400;
        $response['message'] = 'Invalid Filter';

       }
       return response()->json($response);
    }

    // InStock Function
    function InStock($request,$offset ,$perPage)
    {
    
         return DB::table('products')
        ->join('categories','products.category_id' , '=', 'categories.id')
        ->select('categories.*','products.*')
        ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
        ->orWhere(function ($query) use ($request){
            if($request->price_filter_status == 'true'){
                $price_amount   =  explode("-",$request->price_amount);
                $first_amount   =  json_decode($price_amount[0]);
                $second_amount  = json_decode($price_amount[1]);
                $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                ->whereBetween('product_price',[$first_amount,$second_amount]);
            }
        })
        ->orWhere(function ($query) use ($request){
            $category_detail = Category::where('category_slug',$request->category_slug)->first();
                if(isset($category_detail)){
                    $query ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                    ->where('products.category_id',$category_detail->id);
                }
           
        })
        ->orderBy('products.category_id', 'Desc')
        ->skip($offset)
        ->take($perPage)
        ->get()->toArray();
   
          
    }

     // Out of Stock Function
    function OutStock($request,$offset ,$perPage)
    {
        
      return   DB::table('products')
        ->join('categories','products.category_id' , '=', 'categories.id')
        ->select('categories.*','products.*')
        ->orwhere('stock_quantity','=' , 0)
        ->orWhere('product_stock_status', '=' , 'I')
        ->orWhere('product_status', '=' , 'I')
        ->orWhere(function ($query) use ($request){
            if($request->price_filter_status == 'true'){

                $price_amount   =  explode("-",$request->price_amount);
                $first_amount   =  json_decode($price_amount[0]);
                $second_amount  = json_decode($price_amount[1]);
                $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                ->whereBetween('product_price',[$first_amount,$second_amount]);
            }
        })
        ->orWhere(function ($query) use ($request){
         $category_detail = Category::where('category_slug',$request->category_slug)->first();
            if(isset($category_detail)){
                $query->where('products.category_id',$category_detail->id);
            }

        })
        // ->orderBy('products.category_id', 'Desc')
        ->skip($offset)
        ->take($perPage)
        ->get();
    }

    // Both InStock and Out Stock Function

    function InStock_OutStock($request){
    

        return  DB::table('products')
        ->join('categories','products.category_id' , '=', 'categories.id')
        ->select('categories.*','products.*')
        ->orderBy('products.category_id','products.product_price', 'Desc')
        ->get();
    }

    //Total  Count Products
    function ProductCount($request)
    {
        if($request->in_stock == 'A'){
        return DB::table('products')
                ->join('categories','products.category_id' , '=', 'categories.id')
                ->select('categories.*','products.*')
                ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                ->orWhere(function ($query) use ($request){
                    if($request->price_filter_status == 'true'){
                        $price_amount   =  explode("-",$request->price_amount);
                        $first_amount   =  json_decode($price_amount[0]);
                        $second_amount  = json_decode($price_amount[1]);
                        
                        $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                        ->whereBetween('product_price',[$first_amount,$second_amount]);
                    }
                })
                ->orWhere(function ($query) use ($request){
                    $category_detail = Category::where('category_slug',$request->slug)->first();
                        if(isset($category_detail)){
                            $query ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                            ->where('products.category_id',$category_detail->id);
                        }
                })
                ->orderBy('products.category_id', 'Desc')
                ->count();
        }else if($request->out_stock == 'I'){
            return   DB::table('products')
            ->join('categories','products.category_id' , '=', 'categories.id')
            ->select('categories.*','products.*')
            ->orwhere('stock_quantity','=' , 0)
            ->orWhere('product_stock_status', '=' , 'I')
            ->orWhere('product_status', '=' , 'I')
            ->orWhere(function ($query) use ($request){
                if($request->price_filter_status == 'true'){
                    $price_amount   =  explode("-",$request->price_amount);
                    $first_amount   =  json_decode($price_amount[0]);
                    $second_amount  = json_decode($price_amount[1]);
                    $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                    ->whereBetween('product_price',[$first_amount,$second_amount]);
                }
            })
            ->orWhere(function ($query) use ($request){
             $category_detail = Category::where('category_slug',$request->category_slug)->first();
                if(isset($category_detail)){
                    $query->where('products.category_id',$category_detail->id);
                }
    
            })->count();
            // ->orderBy('products.category_id', 'Desc')
           
        }else if($request->out_stock == 'A' && $request->out_stock == 'I' ){
            return  DB::table('products')
            ->join('categories','products.category_id' , '=', 'categories.id')
            ->select('categories.*','products.*')
            ->orderBy('products.category_id','products.product_price', 'Desc')
            ->orWhere(function ($query) use ($request){
                if($request->price_filter_status == 'true'){

                    $price_amount   =  explode("-",$request->price_amount);
                    $first_amount   =  json_decode($price_amount[0]);
                    $second_amount  = json_decode($price_amount[1]);
                    $query->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
                    ->whereBetween('product_price',[$first_amount,$second_amount]);
                }
            })
            ->orWhere(function ($query) use ($request){
            $category_detail = Category::where('category_slug',$request->category_slug)->first();
                if(isset($category_detail)){
                    $query->where('products.category_id',$category_detail->id);
                }
            })->count();

        }else if($request->price_filter_status == 'true'){
            $price_amount   =  explode("-",$request->price_amount);
            $first_amount   =  json_decode($price_amount[0]);
            $second_amount  = json_decode($price_amount[1]);
            
           return  DB::table('products')
            ->join('categories','products.category_id' , '=', 'categories.id')
            ->select('categories.*','products.*')
            ->where([['stock_quantity', '>', '0'],['product_stock_status', '=' , 'A'],['product_status','=','A']])
            ->whereBetween('product_price',[$first_amount,$second_amount])
            ->orWhere(function ($query) use ($request){
                $category_detail = Category::where('category_slug',$request->category_slug)->first();
                    if(isset($category_detail)){
                        $query->where('products.category_id',$category_detail->id);
                    }
            })->count(); 
            // ->orderBy('products.category_id', 'Desc')
        }
    }

    //  Add Class
    function AddClass($category)
    {
       $category  = DB::table('products')
       ->join('categories','products.category_id','=','categories.id')
       ->where('products.category_id',$category->id)
       ->select('categories.category_name')
       ->first();
       return $category->category_name;
    }
}
