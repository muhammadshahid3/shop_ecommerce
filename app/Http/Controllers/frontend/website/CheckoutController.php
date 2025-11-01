<?php

namespace App\Http\Controllers\frontend\website;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class CheckoutController extends Controller
{
    // Constructor Call automatic
    public function __construct()
    {
        $this->middleware('auth:customers');
    }

    // Basket Checkout //
    public function BasketCheckout()
    {
        try{
            $array_pass = header_helper('Checkout');
            // Frontend Changes form Admin side
            $cms_text  = EditContent();
            if(isset($cms_text) && count($cms_text) > 0){
            $array_pass['cms_texts'] = $cms_text;
            }
           $customer = auth()->guard('customers')->user();
           if(isset($customer)){
              $customer_id = $customer->id;
              $array_pass['customer_info'] = Customer::where('id',$customer_id)->first();
           }
          return view('frontend.basket.checkout', $array_pass);
        }catch(Exception $e){
            dd($e->getMessage());
        }
     
    }

    public function VerifyBasket(Request $request)
    {
           
        $validate_status = 'true';
        $unvalidate_item = '';

        if($request->basket) {
            $basket_data = json_decode($request->basket);

            foreach($basket_data as $basket_item) {
                
                $single_product_data = DB::table('products')->where('product_slug', $basket_item->product_slug)->first();
                $single_category_data = DB::table('categories')->where('id', $single_product_data->category_id)->first();
                
                // product slug verify //
                if ($single_product_data) {

                    // product slug verify //
                    if ((int)$single_product_data->product_slug !== (int)$basket_item->product_slug) {
                        $validate_status = 'false';
                        $unvalidate_item = $single_product_data->product_name . '-' . $single_product_data->product_slug;
                    }
                    
                    // product category slug verify //
                    if ((int)$single_category_data->category_slug !== (int)$basket_item->product_c_slug) {
                        $validate_status = 'false';
                        $unvalidate_item = $single_product_data->product_name . '-' . $basket_item->product_c_slug;
                    }

                    // product name verify //
                    if ($single_product_data->product_name !== $basket_item->product_name) {
                        $validate_status = 'false';
                        $unvalidate_item = $single_product_data->product_name;
                    }
    
                    // product price verify //
                    if ((float)$single_product_data->product_price !== (float)$basket_item->product_price) {
                        $validate_status = 'false';
                        $unvalidate_item = $single_product_data->product_name . '-' . $single_product_data->product_price;
                    }
                    
                    // product stock quantity verify //
                    if ((float)$single_product_data->stock_quantity !== (float)$basket_item->product_stock) {
                        $validate_status = 'false';
                        $unvalidate_item = $single_product_data->product_name . '-' . $single_product_data->stock_quantity;
                    }
                    
                    // product thumbnail verify //
                    if ($single_product_data->product_thumbnail !== $basket_item->product_thumbnail) {
                        $validate_status = 'false';
                        $unvalidate_item = $single_product_data->product_name . '-' . $single_product_data->product_thumbnail;
                    }

                    // product quantity verify //
                    if ((float)$basket_item->product_qty < 1 || (float)$basket_item->product_qty > (float)$single_product_data->stock_quantity) {

                        $calc_product_price = (float)$basket_item->product_qty * (float)$basket_item->product_price;
                        $validate_status = 'false';
                        $unvalidate_item = $single_product_data->product_name . '- Product Qty';
                    }
                } else {
                    $validate_status = 'false';
                }

            }

        }else{}
      
        $response = array();
        if ($validate_status == 'true') {
            $response['message'] = 'Data verified successfully';
            $response['statuscode'] = 200;
            
        } else {
            $response['defectitem'] = $unvalidate_item;
            $response['message'] = 'Data verification failed';
            $response['statuscode'] = 400;
        }
        return response()->json($response);
    }





}
