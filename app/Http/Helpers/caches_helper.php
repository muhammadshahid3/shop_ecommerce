<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


// header & navbar data //
if (!function_exists('header_helper')) {
    function header_helper($page_title = NULL)
    {
        $array_pass = array();
        $array_pass['customer_info'] = auth()->guard('customers')->user();
        // $array_pass['categories'] = caches_categories_helper($reset_caches=FALSE);
        $array_pass['categories'] = DB::table('categories')->where('category_status','A')->get();

        $array_pass['product_list'] = DB::table('product_newarrivals')
        ->leftJoin('products', 'products.id', '=', 'product_newarrivals.product_id', )
        ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->select(
            'products.*',
            'category_name','category_slug',
            'product_newarrivals.id',
            'products.id as main_product_id',
            'product_newarrivals.product_id as latest_newarrival_product_id'
        )
        ->orderBy('products.id', 'DESC')
        ->where('products.product_status' ,'A')
        ->get();

        // $generalsetting = caches_general_settings_helper($reset_caches=FALSE);
        $generalsetting = DB::table('general_settings')->first();
        $array_pass['generalsetting'] = $generalsetting;
    
        if ($page_title && $page_title != NULL) {
            if (isset($generalsetting) && isset($generalsetting->shop_name)) {
                $array_pass['page_title'] = $generalsetting->shop_name.' | '.$page_title;
            } else {
                $array_pass['page_title'] = 'Store | '.$page_title;
            }
        } else {
            $array_pass['page_title'] = 'Store';
        }
        return $array_pass;
    }
}


// Caches DB general_settings
if (!function_exists('caches_general_settings_helper')) {
    function caches_general_settings_helper($reset_caches=FALSE)
    {
        if (Cache::has('caches_general_settings')) {
    
            if ($reset_caches == TRUE) {

                $generalsetting = DB::table('general_settings')->first();

                Cache::forget('caches_general_settings');
                Cache::put('caches_general_settings', $generalsetting, '86400');  // caches time 24hours
                return Cache::get('caches_general_settings');
                
            } elseif ($reset_caches == FALSE) {
                return Cache::get('caches_general_settings');
            }
    
        } else {

            $generalsetting = DB::table('general_settings')->first();
    
            Cache::put('caches_general_settings', $generalsetting, '86400');  // caches time 24hours
            return Cache::get('caches_general_settings');
        }
    }
}


// Caches DB categories
if (!function_exists('caches_categories_helper')) {
    function caches_categories_helper($reset_caches=FALSE)
    {
        if (Cache::has('caches_categories')) {
    
            if ($reset_caches == TRUE) {

                $categories = DB::table('categories')->where('category_status','A')->get();

                Cache::forget('caches_categories');
                Cache::put('caches_categories', $categories, '86400');  // caches time 24hours
                return Cache::get('caches_categories');
                
            } elseif ($reset_caches == FALSE) {
                return Cache::get('caches_categories');
            }
    
        } else {

            $categories = DB::table('categories')->where('category_status','A')->get();
    
            Cache::put('caches_categories', $categories, '86400');  // caches time 24hours
            return Cache::get('caches_categories');
        }
    }
}


// Caches Single Value
if (!function_exists('caches_helper')) {
    function caches_helper($key, $value=NULL, $seconds=NULL)
    {
        if (Cache::has($key)) {
    
            if ($value == NULL && $seconds == NULL) {
                return Cache::get($key);
    
            } else {
                Cache::forget($key);
                Cache::put($key, $value, $seconds);
                return Cache::get($key);
            }
    
        } else {
    
            if ($value == NULL && $seconds == NULL) {
                throw new Exception("Error Processing Cache Request", 1);
            } else {
                Cache::put($key, $value, $seconds);
                return Cache::get($key);
            }
        }
    }
}


// All Caches Delete
if (!function_exists('caches_flush_helper')) {
    function caches_flush_helper()
    {
        Cache::flush();
    }
}

