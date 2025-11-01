<?php
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Order;


if (!function_exists('BasketTotalProductCalcPrice')) {

    // Basket Calc Place Order Product
    function BasketCalcToPlaceOrderHelper($basket_item , $coupon_data, $collection_status)
    {
        if ($basket_item) {

            $total_qty = 0;
            $subtotal_price = 0;
            $discount_val_price = 0;
            $coupon_code = null;
            $coupon_discount = null;
            $net_total = 0;

            foreach ($basket_item as $key => $basket_item_products) {
                $subtotal_price = (float)$subtotal_price + (float)$basket_item_products->product_price * (float)$basket_item_products->product_qty;
                $total_qty = (int)$total_qty + (int)$basket_item_products->product_qty;
            }

            $generalsetting = GeneralSetting::first();
            if ($generalsetting && $generalsetting != Null) {
            
                $shipping_charges = $generalsetting->shipping_charges;
                $shipping_status = $generalsetting->shipping_status;
                $discount_value = $generalsetting->discount_value;
                $discount_type = $generalsetting->discount_type;
                $collection_type = $generalsetting->order_collection_type;
                $delivery_type = $generalsetting->order_delivery_type;

                $discount_status = $discount_type;

                // $collection_status variable get two value return and check the value C & D //
                if ($discount_type == 'V' && $discount_value > 0) {

                    // discount amount should be less than subtotal amount //
                    if ((float)$discount_value < (float)$subtotal_price) {

                        $discount_val_price = (float)$discount_value;
                        $after_discount_price = (float)$subtotal_price - (float)$discount_val_price;
                        $net_total = (float)$after_discount_price;

                    } else if ((float)$discount_value >= (float)$subtotal_price) {
                        $net_total = (float)$subtotal_price;
                        $discount_status = 'false';
                    }

                } else if ($discount_type == 'P' && $discount_value > 0) {

                    // discount amount should be less than 100% //
                    if ((float)$discount_value < 100) {

                        $discount_val_price = ($discount_value * $subtotal_price) / 100;
                        $after_discount_price = (float)$subtotal_price - (float)$discount_val_price;
                        $net_total = (float)$after_discount_price;

                    } else if ((float)$discount_value >= 100) {
                        $net_total = (float)$subtotal_price;
                        $discount_status = 'false';
                    }

                } else if ($discount_type == 'N' || $discount_type == '') {
                    $net_total = (float)$subtotal_price;

                } else {
                    return ['statuscode' => 422];
                }

                // Collection Status include C & D Check //
                if ($collection_type == $collection_status) {
                    $shipping_charges = NULL;
                    $shipping_status = NULL;

                } else if ($delivery_type == $collection_status) {

                    if ($shipping_status == 'F' && $shipping_charges > 0) {
                        $flat_charges =  (float)$shipping_charges;
                        $net_total = (float)$net_total + (float)$shipping_charges;
                    }  
                
                } else {
                    return ['statuscode' => 422];
                }
             
                if($coupon_data && !empty($coupon_data)){
                    $coupon_code = $coupon_data[0]->coupon_code;
                    $coupon_discount = (float)$coupon_data[0]->coupon_amount;
                    $net_total = (float) $net_total - (float) $coupon_discount;
                }

                return [
                    'total_qty' => $total_qty,
                    'subtotal' => $subtotal_price,
                    'discount_price' => $discount_value,
                    'discount_type' => $discount_type,
                    'coupon_code' => $coupon_code,
                    'coupon_discount' => $coupon_discount,
                    'discount_status' => $discount_status,
                    'shipping_charges' => $shipping_charges,
                    'shipping_status' => $shipping_status,
                    'net_total' => $net_total,
                    'statuscode' => 200,
                ];
            }
        }
    }
}


// Single Order Product Record Calc
if(!function_exists('BasketCalcToShowOrderDetailHelper')){

    function BasketCalcToShowOrderDetailHelper($single_order_record)
    {
        if ($single_order_record) {

            $discount_val_price = 0;
            $flat_charges = 0;
            $net_total = 0;

            // get order single product value   
            $subtotal_price = $single_order_record->order_subtotal_price;
            $shipping_charges = $single_order_record->shipping_charges;
            $shipping_status = $single_order_record->shipping_status;
            $discount_value = $single_order_record->discount_value;
            $discount_type = $single_order_record->discount_type;
            $collection_type = $single_order_record->order_delivery_time;

            if ($discount_type == 'V' && $discount_value > 0) {

                $discount_val_price = (float)$discount_value;
                $after_discount_price = (float)$subtotal_price - (float)$discount_val_price;
                $net_total = (float)$after_discount_price;

            } else if ($discount_type == 'P' && $discount_value > 0) {

                $discount_val_price = ($subtotal_price * $discount_value)/100;
                $after_discount_price = (float)$subtotal_price - (float)$discount_val_price;
                $net_total = (float)$after_discount_price;

            } else if ($discount_type == 'N' || $discount_type == '') {

                $net_total = (float)$subtotal_price;
            }

            // $collection_status variable  get two value return and check the value C & D 
            if ($collection_type == 'C') {
                
                $shipping_status = Null;

            } elseif ($collection_type == 'D') {

                if ($shipping_status == 'F' && $shipping_charges > 0) {
                    $flat_charges = $shipping_charges;
                    $net_total = (float)$net_total + (float)$flat_charges;
                }

            } else {
                return ['statuscode' => 422];
            }

            return [
                'subtotal' => $subtotal_price,
                'discount_price' => $discount_val_price,
                'discount_type' => $discount_type,
                'shipping_charges' => $flat_charges,
                'shipping_status' => $shipping_status,
                'net_total' => $net_total,
                'statuscode' => 200,
            ];
        }
    }
}


// Single Order Product Print 
if(!function_exists('OrderProductRecieptHelper')){

    function OrderProductRecieptHelper($single_order_products_detail,$single_order_detail)
    {
        $order_product_reciept = '';
        $order_additional_detail = ''; 
        $order_product_calc = '';
        $thumbnail = '';

        // Check Collection Type
        if ($single_order_detail->order_delivery_time == 'C') {
            $collection_type = "Collection";

        } else {
            $collection_type = "Delivery";
        }

        // Check Order Status Type
        if ($single_order_detail->order_status == 'U') {
            $order_status = "Unpaid";

        } else {
            $order_status = "Paid";
        }

        // Order Highlight Status
          $order_highlight = $single_order_detail->order_highlight;
        // Get Order Slug
          $order_slug = $single_order_detail->order_slug;
        //  Product Total Qty
         $product_total_qty = $single_order_detail->order_total_qty;

        // Order Additional Details
        $order_additional_detail .= '<div class="col-3">
        <span><p style="border-bottom: 1px solid #eee;">Order No : ' .  $single_order_detail->order_number . '</p></span>
        <span><p style="border-bottom: 1px solid #eee;">Payment Status : ' . $order_status . '<span></span>
        <span><p style="border-bottom: 1px solid #eee;">Collection Type : ' . $collection_type . '<span></span>
        <span><p style="border-bottom: 1px solid #eee;"> Date: ' . $single_order_detail->order_date . ' </p></span>
        </div>';

        foreach ($single_order_products_detail as $single_order_products_detail_list) {

            // Check Product Thumbnail exist
            if (isset( $single_order_products_detail_list->product_thumbnail)) {
                if (file_exists(public_path('upload/product/' . $single_order_products_detail_list->product_thumbnail))) {
                    $thumbnail = asset('upload/product/' . $single_order_products_detail_list->product_thumbnail);
                }
            }
               
            // Fetch Category Name
            $category = Category::select('category_name')->where('category_slug', $single_order_products_detail_list->product_c_slug)->first();
            $order_product_reciept = $order_product_reciept . '<tr>
            <td>' . $single_order_products_detail_list->product_qty . '</td>
            <td> <img src= "' . $thumbnail . '" width="50px" heigth = "50px";></td>
            <td>' . $category->category_name . '</td>
            <td>' . $single_order_products_detail_list->product_name . '</td>
            <td>' . $single_order_products_detail_list->product_price . '</td>
            </tr>';
        }

        // Single product Calc
        $total_calculation  = BasketCalcToShowOrderDetailHelper($single_order_detail);

        if($total_calculation['statuscode'] == 422){
            $order_product_calc = '';

        }else{
            if ( $single_order_detail->order_delivery_time == 'C') {

                if ($total_calculation['discount_type'] == 'V') {
                    $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                    <p style="border-bottom: 1px solid #eee;">Order SubTotal : $' . GetTwodecimalHelper( $single_order_detail->order_subtotal_price) . '</p>
                    <p style="border-bottom: 1px solid #eee;">Discount (price ' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p>
                    <p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p>
                    </div></div>';
    
                } else if ($total_calculation['discount_type'] == 'P'){

                    $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                    <span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                    <span><p style="border-bottom: 1px solid #eee;">Discount (percentage ' . $total_calculation['discount_price'] . '%): ' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                    <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                    <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                    </div></div>';

                } else if ($total_calculation['discount_type'] == 'N' || $total_calculation['discount_type'] == '') {
                    $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                    <span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                    <span><p style="border-bottom: 1px solid #eee;">Discount (price  ' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                    <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                    <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                    </div></div>';

                } else {
                    $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                    <span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                    <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                    </div></div>';
                }

            } elseif ( $single_order_detail->order_delivery_time == 'D') {
    
                if ($total_calculation['shipping_status'] == 'F') {
    
                    if ($total_calculation['discount_type'] == 'V') {

                        $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                        <span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (price ' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                        </div></div>';

                    } else if ($total_calculation['discount_type'] == 'P') {

                        $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                        <span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (percentage ' . $total_calculation['discount_price'] . '%): ' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                        </div></div>';

                    } else if ($total_calculation['discount_type'] == 'N' || $total_calculation['discount_type'] == '') {
                        
                        $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                        <span><p style="border-bottom: 1px solid #eee;">SubTotal :$ ' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (price' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                        </div></div>';

                    } else {
                        $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                        <span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                        </div></div>';
                    }
    
                } else if ($total_calculation['shipping_status'] == 'N' ||  $single_order_detail->shipping_status == '') {
    
                    $order_product_calc .= '<div class="col-md-6 col-sm-6 col-lg-3 col-xl-5 col-xxl-4"><div class="text-end">
                    <span><p style="border-bottom: 1px solid #eee;">SubTotal :$' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                    <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>
                    </div></div>';

                } else {
                    $order_product_calc = '';
                }
    
            } else {
                $order_product_calc = '';
            }
        }

        $arr = array();
        $arr['statuscode'] = 200;
        $arr['message'] = 'view order data successfully';
        $arr['order_products'] =  $order_product_reciept;
        $arr['order_addtional_details'] =  $order_additional_detail;
        $arr['order_product_calc'] = $order_product_calc;
        $arr['order_highlight'] = $order_highlight;
        $arr['order_slug'] = $order_slug;
        $arr['product_total_qty'] = $product_total_qty;
        
     
        return response()->json($arr);
    }
}

//  Order Status Check Paid or Unpaid

if(!function_exists('OrderStatus')){
    function OrderStatus()
    {
        $customer  = auth()->guard('customers')->user();

        if(isset($customer)){
            $order_detail_status = Order::where('customer_id',$customer->id)->select('order_status','payment_method')->latest()->first();
            return $order_detail_status;
        }   
    }
}

