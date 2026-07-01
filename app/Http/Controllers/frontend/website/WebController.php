<?php

namespace App\Http\Controllers\frontend\website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\FAQ;
use App\Models\Product;
use App\Models\Category;
use App\Models\GeneralSetting;

class WebController extends Controller
{

    // Display Shop view
    public function Website()
    {
        // $cache_value = caches_helper('projectname', 'Shop1', '86400');
        // $cache_value = caches_helper('projectname');
        // caches_flush_helper();

        $array_pass = header_helper('Home');
        // Frontend Changes form Admin side
       $cms_text  = EditContent();
       if(isset($cms_text) && count($cms_text) > 0){
        $array_pass['cms_texts'] = $cms_text;
       }
        // Latest New Arrivals Products 
        $arrival_products_rating = [];
        $latest_newarrival_product_array = [];

        $latest_newarrivals_products = DB::table('product_newarrivals')
        ->leftJoin('products', 'products.id', '=', 'product_newarrivals.product_id', )
        ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->select(
            'products.*',
            'categories.category_name',
            'product_newarrivals.id','categories.category_slug',
            'products.id as main_product_id',
            'product_newarrivals.product_id as latest_newarrival_product_id'
        )
        ->orderBy('products.id', 'DESC')->take(4)
        ->where('products.product_status' ,'A')
        ->get()->toArray();

           // Single product Rating 
           foreach($latest_newarrivals_products as $index => $product_rating) {
            $arrival_products_rating[] = SingleProductRating($product_rating->latest_newarrival_product_id,$product_rating->category_id);
                $new =   $arrival_products_rating[$index] ?? null;
                $latest_newarrival_product_array[] = (object) array_merge((array)$latest_newarrivals_products[$index], (array)$new);
            }

            if(isset($latest_newarrivals_products) && count($latest_newarrivals_products) > 0){

                $array_pass['latest_newarrivals_products'] = $latest_newarrival_product_array;
            }

             // Latest Featured Products 
             $feature_products_rating = [];
             $latest_features_product_array = [];

             $latest_features_products = DB::table('product_features')
             ->leftJoin('products', 'products.id', '=', 'product_features.product_id', )
             ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
             ->select(
                 'products.*',
                 'categories.category_name','categories.category_slug',
                 'product_features.id',
                 'products.id as main_product_id',
                 'product_features.product_id as feature_product_id'
             )
             ->orderBy('products.id', 'DESC')->take(4)
             ->where('products.product_status' ,'A')
             ->get()->toArray();

                // Single product Rating 
            foreach($latest_features_products as $index => $product_rating) {
                $feature_products_rating[] = SingleProductRating($product_rating->feature_product_id,$product_rating->category_id);
                $new =   $feature_products_rating[$index] ?? null;
                $latest_features_product_array[] = (object) array_merge((array)$latest_features_products[$index], (array)$new);
            }

            if(isset( $latest_features_products) && count( $latest_features_products) > 0){

                $array_pass['latest_features_products'] = $latest_features_product_array;
            }

            // latest top selling products
            $seller_products_rating = [];
            $latest_seller_product_array = [];

            $latest_topsellers_products = DB::table('product_topsellers')
            ->leftJoin('products', 'products.id', '=', 'product_topsellers.product_id', )
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select(
                'products.*',
                'category_name','category_slug',
                'product_topsellers.id',
                'products.id as main_product_id',
                'product_topsellers.product_id as topseller_product_id'
            )
            ->orderBy('products.id', 'DESC')->take(4)
            ->where('products.product_status' ,'A')
            ->get()->toArray();

            // Single product Rating 
            foreach($latest_topsellers_products as $index => $product_rating) {
                $seller_products_rating[] = SingleProductRating($product_rating->topseller_product_id,$product_rating->category_id);
                $new =    $seller_products_rating[$index] ?? null;
                $latest_seller_product_array [] = (object) array_merge((array)$latest_topsellers_products[$index], (array)$new);
            }

            if(isset(  $latest_topsellers_products) && count(  $latest_topsellers_products) > 0){

                $array_pass['latest_topsellers_products'] = $latest_seller_product_array;
            }

            // Gadgets Category and products
            $products_rating = [];
            $gadget_product_array = [];

            $Gadgets_category_products = DB::table('product_newarrivals')
            ->leftJoin('products', 'products.id', '=', 'product_newarrivals.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select(
                'products.*',
                'categories.category_name',
                'categories.category_slug',
                'product_newarrivals.id',
                'products.id as main_product_id',
                'product_newarrivals.product_id as latest_newarrival_product_id'
            )
            ->orderBy('products.id', 'DESC')->take(6)
            ->where('products.product_status', 'A')
            ->get()->toArray();

            // Single product Rating
            foreach ($Gadgets_category_products as $index => $product_rating) {
                $products_rating[] = SingleProductRating($product_rating->latest_newarrival_product_id, $product_rating->category_id);
                $new = $products_rating[$index] ?? null;
                $gadget_product_array[] = (object) array_merge((array) $Gadgets_category_products[$index], (array) $new);
            }

            $array_pass['Gadgets_category_products'] = $gadget_product_array;

            // Latest News Blog
            $latest_blog = Blog::latest()->take(3)->get();
            $array_pass['latest_blog'] = $latest_blog;

            return view('frontend.website.index', $array_pass);
    }

    // Search Product
    public function Search(Request $request)
    {
          
        $search_product_details  = Product::search($request->product_name)->get();
                        

                // if($search_product_details)
               
                if(count($search_product_details) > 0 ){

                    $search_output = '<ul class = "">';

                    foreach ($search_product_details as $key => $search_product_details_list) {

                        $search_output = $search_output .= '<a href="'.route('product.detail',$search_product_details_list->product_slug).'"><li class=" searching_value border li_item" style="list-style:none; padding:5px 10px;">'.$search_product_details_list->product_name.'</li></a>';
        
                    }
    
                    $search_output .= '</ul>';
    
                }else{
    
                    $search_output  = '<li class="list-group-item">Data not found</li>';
                }
            
            
          

                return response()->json($search_output);

        
    }

    // Privacy Policy //
    public function PrivacyPolicy()
    {
        $array_pass = header_helper('Privacy Policy');

        $privacy_policy = DB::table('store_texts')->where('item', 'PrivacyPolicy')->first();

        if ($privacy_policy && !empty($privacy_policy) && $privacy_policy != null) {
            $array_pass['privacy_policy'] = $privacy_policy->value;
        }

        return view('frontend.website.privacypolicy', $array_pass);
    }


    public function NewarrivalsProducts($products_count)
    {
        $products_rating = [];
        $new_arrival_product_array = [];
        if ($products_count == '0') {
            $newarrivals_products = DB::table('product_newarrivals')
                ->leftJoin('products', 'product_newarrivals.product_id' ,'=','products.id')
                ->leftJoin('categories', 'products.category_id' , '=' , 'categories.id')
                ->select(
                    'products.*',
                    'categories.category_name','categories.category_slug',
                    'product_newarrivals.id',
                    'products.id as main_product_id',
                    'product_newarrivals.product_id as newarrival_product_id'
                )
                ->orderBy('products.id', 'DESC')->take(10)
                ->where('products.product_status' ,'A')
                ->get();
        } else {
            $newarrivals_products = DB::table('product_newarrivals')
                ->leftjoin('products', 'products.id', '=', 'product_newarrivals.product_id', )
                ->leftjoin('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'products.*',
                    'categories.category_name','categories.category_slug',
                    'product_newarrivals.id',
                    'products.id as main_product_id',
                    'product_newarrivals.product_id as newarrival_product_id'
                )
                ->orderBy('products.id', 'DESC')->take($products_count)
                ->where('products.product_status' ,'A')
                ->get()->toArray();
        }
         // Single product Rating 
         foreach($newarrivals_products as $index => $product_rating) {
            $products_rating[] = SingleProductRating($product_rating->newarrival_product_id,$product_rating->category_id);
            $new =  $products_rating[$index] ?? null;
             $new_arrival_product_array[] = array_merge((array)$newarrivals_products[$index], (array)$new);

        }
        $response = array();
        if (!empty($newarrivals_products)) {
            $response['newarrivalsproducts'] = $new_arrival_product_array;
            // $response['all_product_rating'] = $products_rating;
            $response['statuscode'] = 200; 

        } else {
            $response['message'] = 'newarrivals products not found';
            $response['statuscode'] = 404;
        }
        return response()->json($response);
    }


    public function FeaturesProducts($products_count)
    {
        $products_rating = [];
        $new_featured_product_array = [];

        if ($products_count == '0') {
            $features_products = DB::table('product_features')
                ->leftJoin('products', 'products.id', '=', 'product_features.product_id', )
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'products.*',
                    'categories.category_name','categories.category_slug',
                    'product_features.id',
                    'products.id as main_product_id',
                    'product_features.product_id as feature_product_id'
                )
                ->orderBy('products.id', 'DESC')->take(10)
                ->where('products.product_status' ,'A')
                ->get();
        } else {
            $features_products = DB::table('product_features')
                ->leftJoin('products', 'products.id', '=', 'product_features.product_id', )
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'products.*',
                    'categories.category_name','categories.category_slug',
                    'product_features.id',
                    'products.id as main_product_id',
                    'product_features.product_id as feature_product_id'
                )
                ->orderBy('products.id', 'DESC')->take($products_count)
                ->where('products.product_status' ,'A')
                ->get()->toArray();
        }

            // Single product Rating 
         foreach($features_products as $index => $product_rating) {
            $products_rating[] = SingleProductRating($product_rating->feature_product_id,$product_rating->category_id);
            $new =  $products_rating[$index] ?? null;
            $new_featured_product_array[] = array_merge((array)$features_products[$index], (array)$new);
        }

        $response = array();
        if (!empty($features_products)) {
            $response['featuresproducts'] =  $new_featured_product_array;
            $response['statuscode'] = 200;

        } else {
            $response['message'] = 'features products not found';
            $response['statuscode'] = 404;
        }
        return response()->json($response);
    }


    public function TopsellersProducts($products_count)
    {
        $products_rating = [];
        $new_topseller_product_array = [];
        if ($products_count == '0') {
            $topsellers_products = DB::table('product_topsellers')
                ->leftJoin('products', 'products.id', '=', 'product_topsellers.product_id', )
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'products.*',
                    'categories.category_name','categories.category_slug',
                    'product_topsellers.id',
                    'products.id as main_product_id',
                    'product_topsellers.product_id as topseller_product_id'
                )
                ->orderBy('products.id', 'DESC')->take(10)
                ->where('products.product_status' ,'A')
                ->get();
        } else {
            $topsellers_products = DB::table('product_topsellers')
                ->leftJoin('products', 'products.id', '=', 'product_topsellers.product_id', )
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->select(
                    'products.*',
                    'categories.category_name','categories.category_slug',
                    'product_topsellers.id',
                    'products.id as main_product_id',
                    'product_topsellers.product_id as topseller_product_id'
                )
                ->orderBy('products.id', 'DESC')->take($products_count)
                ->where('products.product_status' ,'A')
                ->get();
        }

            // Single product Rating 
            foreach($topsellers_products as $index => $product_rating) {
                $products_rating[] = SingleProductRating($product_rating->topseller_product_id,$product_rating->category_id);
                $new =  $products_rating[$index] ?? null;
                $new_topseller_product_array[] = array_merge((array)$topsellers_products[$index], (array)$new);
            }
    

        $response = array();
        if (!empty($topsellers_products)) {
            $response['topsellersproducts'] = $new_topseller_product_array;
            $response['statuscode'] = 200;

        } else {
            $response['message'] = 'topsellers products not found';
            $response['statuscode'] = 404;
        }
        return response()->json($response);
    }


    // Show FAQ
    public function ShowFaq()
    {
        $array_pass = header_helper('FAQ');
        // Frontend Changes form Admin side
        $cms_text  =  EditContent();
        if(isset($cms_text) && count($cms_text) > 0){
            $array_pass['cms_texts'] = $cms_text;
        }

        $faq_details = FAQ::get();

        if (isset($faq_details) && count($faq_details) > 0) {

            $array_pass['faq_details'] = $faq_details;
            return view('frontend.faq.faqs', $array_pass);

        } else {
            return view('frontend.website.404');
        }
    }

    // Show About
    public function ShowAbout()
    {
        $array_pass = header_helper('About');
        // Frontend Changes form Admin side
            $cms_text  =  EditContent();
            if(isset($cms_text) && count($cms_text) > 0){
                $array_pass['cms_texts'] = $cms_text;
            }
        return view('frontend.about.about',$array_pass);
       
    }

    // Show Bog
    public function ShowBlog()
    {
        $array_pass = header_helper('Blog');
        $blog_details = Blog::get();
         $cms_text  =  EditContent();
            if(isset($cms_text) && count($cms_text) > 0){
                $array_pass['cms_texts'] = $cms_text;
            }
        if (isset($blog_details) && count($blog_details) > 0) {
            $array_pass['blog_details'] = $blog_details;
            return view('frontend.blog.blog', $array_pass);
        }else{
            return view('frontend.website.404');
        }
    }
}
