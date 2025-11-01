<?php
use Illuminate\Support\Facades\DB;
use App\Models\ProductRating;
// Generate Barcode //
if (!function_exists('barcode_code')) {
    function ProductBarcodeCode($product_code)
    {
        $code = str($product_code);
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        // $product_barcode_image = $generator->getBarcode($code, $generator::TYPE_CODE_128);
        $path = public_path('/upload/product_barcode/');
        $product_barcode_image = file_put_contents($path . $code . '.png', $generator->getBarcode($code, $generator::TYPE_CODE_128));
        // Storage::put('barcode/'.GenerateSlug() .'.png', $product_barcode_image);

        return response($product_barcode_image)->header('Content-Type', 'image/png');
    }
}

// Generate Slug //
if (!function_exists('GenerateSlug')) {
    function GenerateSlug()
    {
        // $random = substr(str_shuffle(MD5(microtime())), 0, 12);
        $microtime = str_replace('.', '', microtime());
        $arr = explode(' ', $microtime);
        $random = $arr[1] . $arr[0];
        $random = substr($random, 1, 16);
        return $random;
    }
}

// Get Two Decimal 
if(!function_exists('Twodecimal')){

    function GetTwodecimalHelper($value)
    {
        $digit = (float)$value*1000;
        $digit_arr = explode('.',$digit);
        $digit = $digit_arr[0];
        $digit = substr((string)$digit, -1, 1);
        $value = number_format((float)$value, 2, '.', '');
        if ((int)$digit === 5) {
            $value = (float)$value - 0.01;
        }
        return $value;
    }

}

// Frontend Edit Content display
if(!function_exists('EditContent')){
    function EditContent(){
      $editdata  =  DB::table('cms_texts')->get();
      if(count($editdata) > 0){
        return $editdata;
      }
    }
}


// All Featured Product on Website //
if (!function_exists('ProductFeatured')) {
    function ProductFeatured($category_id, $product_id)
    {
        return DB::table('products')
            ->leftJoin('product_features', 'product_features.product_id', '=', 'products.id')
            ->leftJoin('product_newarrivals', 'product_newarrivals.product_id', '=', 'products.id')
            ->leftJoin('product_topsellers', 'product_topsellers.product_id', '=', 'products.id')
            ->select(
                'products.*',
                'product_features.product_id as feature_product_id',
                'product_newarrivals.product_id as newarrival_product_id',
                'product_topsellers.product_id as topseller_product_id'
            )
            ->where('products.category_id', $category_id)
            ->where('products.id', $product_id)
            ->first();
    }
}

// Product Featured //
if (!function_exists('Featured')) {
    function Featured()
    {
        return DB::table('products')
            ->join('product_features', 'product_features.product_id', '=', 'products.id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.*', 'category_name','product_features.id','product_features.product_id as featured_product_id')
            ->get();
    }
}

// Product Featured //
if (!function_exists('Arrivals')) {
    function Arrivals()
    {
        return DB::table('products')
            ->join('product_newarrivals', 'product_newarrivals.product_id', '=', 'products.id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.*', 'category_name','product_newarrivals.id','product_newarrivals.product_id as newarrival_product_id')
            ->get();
    }
}

// Product Featured //
if (!function_exists('TopSellers')) {
    function TopSellers()
    {
        return DB::table('products')
            ->join('product_topsellers', 'product_topsellers.product_id', '=', 'products.id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.*', 'category_name','product_topsellers.id','product_topsellers.product_id as topseller_product_id')
            ->get();
    }
}

if (!function_exists('FilterStringHelper')) {
    function FilterStringHelper($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }
}
// Single Product reviews and stars count

if (!function_exists('SingleProductRating')) {
    function SingleProductRating($product_id,$category_id){
        $response = [];
        // Single product stars var
        $total_stars  = 0;
        $unfill_count_stars = '';
        $fill_count_stars = '';
        // Single Product Rating Reviews
           $single_reviews = ProductRating::where(['category_id' => $category_id, 'product_id' => $product_id ])->get();
            if(count($single_reviews) > 0  && $single_reviews != null){
                //   Single product Reviews Count
                $reviews_count =  count($single_reviews);
                //  foreach loop and get the single product avg rating
                foreach ( $single_reviews  as $key =>  $rating) {
                    $total_stars = $total_stars + $rating->stars;
                }
                // Avg Rating stars
                $avg_rating = round($total_stars/$reviews_count);
                // Fill Star count
                // $product_reviews_count = $single_reviews['single_reviews_count'];
                for($index = 0; $index < $avg_rating; $index++ ) {
                    $fill_count_stars .='<span><i class="fa-solid fa-star"></i></span>';
                }
                // Unfill Stars 
                    if($avg_rating== 1){
                        $unfill_count_stars .='<span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>';
                    }else if( $avg_rating == 2){
                        $unfill_count_stars .='<span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>';
                    }elseif($avg_rating == 3){
                        $unfill_count_stars .='<span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>';
                    }else if( $avg_rating == 4){
                        $unfill_count_stars .='<span><i class="fa-light fa-star"></i></span>';
                    }else if( $avg_rating == 5){
                        $unfill_count_stars = $unfill_count_stars .``;
                    }else{
                        $unfill_count_stars .='<span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>
                        <span><i class="fa-light fa-star"></i></span>';
                    }

                    $response['single_reviews_count'] = $reviews_count;
                    $response['single_reviews_avg'] =   $avg_rating;
                    $response['fill_count_stars'] = $fill_count_stars;
                    $response['unfill_count_stars'] = $unfill_count_stars;
  
            }else{
                $response['single_reviews_count'] = 0;
                $response['single_reviews_avg'] =   0;
                $response['fill_count_stars'] = 0;
                $response['unfill_count_stars'] = 0;

            }
       
           
            return $response;

    }
}



// include caches helper //
include('caches_helper.php');


// include basket helper //
include('basket_helper.php');