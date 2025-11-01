<?php

namespace App\Http\Controllers\backend\main;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\GeneralSetting;
use Yajra\DataTables\DataTables;
class OrderController extends Controller
{
    // Order Place Fuunction
    public function index(Request $request)
    {
       
        if ($request->collection_type == 'D') {

            $validator = Validator::make($request->all(), [
                'house_info' => 'required|regex:/^[a-zA-Z0-9-\s]*$/',
                'address' => 'required|regex:/^[a-zA-Z0-9-\s]*$/',
                'city' => 'required|regex:/^[a-zA-Z0-9-\s]*$/',
                'postcode' => 'required|numeric|digits:5',
                'order_msg' => 'regex:/^[a-zA-Z0-9-\s]*$/',
                'collection_type' => 'required',
                'payment_method' => 'required',
            ]);

            // Check Validation Errors
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

        } else if ($request->collection_type == 'C') {

            $validator = Validator::make($request->all(), [
                'collection_type' => 'required',
                'payment_method' => 'required',
            ]);

            // Check Validation Errors
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

        } else {
            $response = array();
            $response['message'] = 'Invalid Data Order Type';
            $response['statuscode'] = 422;
            return response()->json($response);
            exit;
        }

        if ($request->payment_method == 'PBC') {

        } else if ($request->payment_method == 'COD') {

        } else {
            $response = array();
            $response['message'] = 'Invalid Data Payment Method';
            $response['statuscode'] = 422;
            return response()->json($response);
            exit;
        }
        // $get_coupon= null;
        $basket_item = json_decode($request->basket_items);
        $coupon_data = json_decode($request->coupon_data);
        
        if(isset($coupon_data[0]->coupon_amount)){
            if($coupon_data[0]->coupon_amount > 0){
                $get_coupon = Coupon::where('coupon_code',$coupon_data[0]->coupon_code)->first();
            }
        }

        $collection_status = $request->collection_type;
        $basket_items_status = true;
        $invalid_data = '';

        if ($request->basket_items && !empty($request->basket_items) && $request->basket_items != null) {

            foreach ($basket_item as $key => $basket_item_list) {

                $single_product = DB::table('products')->where('product_slug', $basket_item_list->product_slug)->first();
                $single_product_category_slug = DB::table('categories')->where('id', $single_product->category_id)->first();

                // verify product slug
                if ($single_product) {

                    if ($single_product->product_slug != $basket_item_list->product_slug) {
                        $basket_items_status = false;
                        $invalid_data = $single_product->product_name . '-' . $single_product->product_slug;
                    }

                    // verify product category slug
                    if ($single_product_category_slug->category_slug != $basket_item_list->product_c_slug) {
                        $basket_items_status = false;
                        $invalid_data = $single_product_category_slug->category_name . '-' . $single_product_category_slug->category_slug;
                    }

                    // verify product name
                    if ($single_product->product_name != $basket_item_list->product_name) {
                        $basket_items_status = false;
                        $invalid_data = $single_product->product_name . '-' . $single_product->product_name;
                    }

                    // verify product price
                    if ((float)$single_product->product_price != (float)$basket_item_list->product_price) {
                        $basket_items_status = false;
                        $invalid_data = $single_product->product_name . '-' . $single_product->product_price;
                    }

                    // verify product stock Qty
                    if ((int)$single_product->stock_quantity > (int)$basket_item_list->product_stock) {
                        $basket_items_status = false;
                        $invalid_data = $single_product->product_name . '-' . $single_product->stock_quantity;
                    }

                    // verify product qty
                    if ((int)$basket_item_list->product_qty < 1 || (int)$basket_item_list->product_stock > (int)$single_product->stock_quantity) {
                        $basket_items_status = false;
                        $invalid_data = $single_product->product_name . '-' . $single_product->stock_quantity;
                    }

                    // verify product thumbnail
                    if ($single_product->product_thumbnail != $basket_item_list->product_thumbnail) {
                        $basket_items_status = false;
                        $invalid_data = $single_product->product_name . '-' . $single_product->product_thumbnail;
                    }

                } else {
                    $basket_items_status = false;
                }
            }

        } else {
            $basket_items_status = false;
        }
        // Check Coupon data
        
        if($request->coupon_data && !empty($request->coupon_data) && $request->coupon_data !=null ){
            foreach ($coupon_data as $key => $coupon) {
                if(isset($coupon->coupon_amount)){
                    if($coupon->coupon_amount > 0){
                        $coupon_list = Coupon::where('coupon_code',$coupon->coupon_code)->first();
                        if($coupon_list->coupon_code != $coupon->coupon_code){
                        $invalid_data  = $coupon_list->coupon_code; 
                        $basket_items_status = false;
                        }elseif((float)$coupon_list->coupon_amount != (float)$coupon->coupon_amount){
                            $invalid_data  = $coupon_list->coupon_amount; 
                            $basket_items_status = false;
                        }else{
                            $basket_items_status = true;
                        }
                    }else{
                        $basket_items_status = false;
                    }
                
                }else{
                    $basket_items_status = false;
                }                 

            }
        }else{
            $get_coupon = null;
        }
        $response = array();
        
        if ($basket_items_status == true) {

            $total_calc_obj = BasketCalcToPlaceOrderHelper($basket_item, $coupon_data, $collection_status);
            // Check Calculation Data
            if ($total_calc_obj['statuscode'] == 422) {
                $response['message'] = 'Invalid Data';
                $response['statuscode'] = 422;

            } else if ($total_calc_obj['statuscode'] == 204) {
                $response['message'] = 'Data Verification Failed';
                $response['statuscode'] = 204;

            } else {

                $customer_id = auth()->guard('customers')->user()->id;

                if ($customer_id && $customer_id != null) {
                    $customer = Customer::where('id', $customer_id)->first();
                    if ($collection_status == 'D') {

                        // Customer Details Store
                        $customer_details_id = DB::table('customer_details')->insertGetId([
                            'customer_id' => $customer_id,
                            'username' => $customer->username,
                            'email' => $customer->email,
                            'phone_number' => $customer->phone_number,
                            'house_no' => $request->house_info,
                            'street' => $request->address,
                            'city' => $request->city,
                            'postcode' => $request->postcode,
                            'message' => $request->order_msg,
                            'created_at' => Carbon::now()->timezone('Asia/Karachi'),
                            'updated_at' => Carbon::now()->timezone('Asia/Karachi'),
                        ]);
                    }

                    // Store Product name on order products
                    $total_qty = $total_calc_obj['total_qty'];
                    $subtotal = $total_calc_obj['subtotal'];
                    $discount_value = $total_calc_obj['discount_price'];
                    $discount_type = $total_calc_obj['discount_type'];
                    $shipping_charges = $total_calc_obj['shipping_charges'];
                    $shipping_status = $total_calc_obj['shipping_status'];
                    $payment_method = $request->payment_method;
                    $net_total = $total_calc_obj['net_total'];

                    $order = new Order;
                    $order->customer_id = $customer_id;
                    $order->order_slug = GenerateSlug();
                    $order->order_products = $request->basket_items;
                    $order->order_total_qty = $total_qty;
                    $order->order_subtotal_price = $subtotal;
                    $order->coupon_id =  ($get_coupon) ? $get_coupon->id : null;
                    $order->discount_value = $discount_value;
                    $order->discount_type = $discount_type;
                    $order->shipping_charges = $shipping_charges;
                    $order->shipping_status = $shipping_status;
                    $order->order_net_total = $net_total;
                    $order->order_highlight = 'A';
                    $order->order_beep_status = 'A';
                    $order->order_alert = 'A';
                    $order->payment_method = $payment_method;
                    $order->order_delivery_time = $request->collection_type;
                    $order->order_date = Carbon::now('Asia/Karachi')->format('Y-m-d h-i-s');
                    $order->created_at = Carbon::now()->timezone('Asia/Karachi');
                    $order->updated_at = Carbon::now()->timezone('Asia/Karachi');

                    if ($order) {

                        $generalsetting = GeneralSetting::first();
                        $customer_details = Customer::where('id', $customer_id)->latest()->first()->toArray();

                        if ($generalsetting->test_number == $customer_details['phone_number']) {

                            $order_number = "test_" . random_int(1000000000, time());
                            Order::where('customer_id', $customer_id)
                                ->orderBy('customer_id', 'desc')->latest()
                                ->update(['order_number' => $order_number]);

                        } else {
                            // $order = Order::where('id', $order->id)->first();
                            sleep(1);

                            DB::transaction(function () use ($order) {
                                DB::table('order_numbers')->lockForUpdate()->latest()->first();

                                $orderNumberTable = DB::table('order_numbers')->first();
                                $order->order_number = $orderNumberTable->order_number;

                                DB::table('order_numbers')->increment('order_number');
                                return $order->save();
                            });
                        } 

                        // update value after submission
                            if($get_coupon){

                                Coupon::where('id',$get_coupon->id)->update(['coupon_stock' => $get_coupon->coupon_stock -1]);
                            }
                        
                        if ($collection_status == 'D') {
                            DB::table('customer_details') ->where('id', $customer_details_id)->update(['order_id' => $order->id]);
                        }

                        $response['message'] = 'Order Place Successfully';
                        $response['order_id'] = $order->order_slug;
                        $response['payment_method'] = $payment_method;
                        $response['total_product_amount'] = $net_total;
                        $response['statuscode'] = 200;
                    }

                } else {
                    $response['message'] = 'Data verification failed';
                    $response['statuscode'] = 400;
                }
            }

        } else {
            $response['invalid data'] = $invalid_data;
            $response['message'] = 'Data verification failed';
            $response['statuscode'] = 400;
        }

        return response()->json($response);
    }


    // All Orders
    public function AllOrders(Request $request)
    {
        $generalsetting = GeneralSetting::first();
        $order_beep_status = Order::select("order_beep_status")->where('order_beep_status','A')->latest()->count();
        if ($request->ajax()) {
            $data = Order::select('*')->latest();
            return DataTables::of($data)

                ->setRowClass(function ($data) {
                    // strikeout_cancel_highlight

                    $active_class = '';

                    if($data->order_highlight == 'A'){

                        $active_class = 'tr_highlight';
                    }

                    if($data->order_cancel == 'A'){

                        $active_class = $active_class . ' ' .'strikeout';
                    }

                    return $active_class;
                })

                ->addIndexColumn()

                ->addColumn('checkbox', function (Order $data) {

                    $checkbox = '<div class="checkall"><input name="addons[]" class="ckboxes"  value="' . $data->id . '" type="checkbox"></div>';
                    return $checkbox;
                })

                ->addColumn('customer_name', function (Order $data) {

                    $customer_name = DB::table('customers')
                        ->where(['id' => $data->customer_id])
                        ->first();

                    return $customer_name->username;

                })

                ->addColumn('customer_address', function (Order $data) {

                    $customer_list = '';

                    $customer_details = DB::table('customer_details')
                        ->where(['customer_id' => $data->customer_id, 'order_id' => $data->id])
                        ->first();

                    if ($customer_details) {

                        $customer_list .= $customer_details->house_no;
                    } else {
                        $customer_list .= 'N/A';
                    }

                    return $customer_list;
                })

                ->addColumn('order_number', function (Order $order){

                    $order_number =  Order::where('id',$order->id)->first();
                    if(preg_match("/^[0-9]$/",$order_number->order_number)){
                            return $order_number->order_number;
                    }else{
                        return "test order";
                    }

                })

                ->addColumn('order_delivery_time', function (Order $order) {

                    if ($order->order_delivery_time == 'C') {

                        return "Collection";
                    } else {
                        return "Delivery";
                    }
                })

                ->addColumn('order_status', function (Order $order) {

                    if ($order->order_status == 'P') {

                        return "Paid";
                    } else {
                        return "Unpaid";
                    }
                })

                ->addColumn('order_cancel', function (Order $order) {

                    if ($order->order_cancel == 'A') {

                        return "Active";
                    } else {
                        return "Inactive";
                    }
                })


                ->addColumn('action', function (Order $data) {
                    
                    if($data->order_cancel == 'A'){
                        $btn_cross  = '<a class=" mx-1 order_cancel_msg" title="cancel order" data-bs-toggle="modal" data-bs-target="#exampleModal" value="' . $data->id . '" style="pointer-events: none;"><button class="btn btn-danger btn-sm"><i class="fa fa-close"></i></button></a>';
                    }else{

                        $btn_cross  = '<a class=" mx-1 order_cancel" title="cancel order"  value="' . $data->id . '" style="cursor:pointer;"><button class="btn btn-danger btn-sm"><i class="fa fa-close"></i></button></a>';
                    }

                    if($data->order_status == 'U'){
                     $btn_dollar = '<a class="mx-1 order_paid" value="' . $data->id . '" title="order paid"><button class="btn btn-success btn-sm my-1" style="cursor:pointer;" data-bs-toggle="tooltip" data-placement="top" title="Order Paid"><i class="fa fa-dollar-sign"></i></button></a>';
                    }else{
                     $btn_dollar = '';  
                    }
                        
                        $btn_print = '<a class="mx-1 print_order" value="' . $data->id . '"  style="cursor:pointer;"><button class="btn btn-primary btn-sm my-1"  data-bs-toggle="tooltip" data-placement="top" title="Order Print"><i class="fa fa-print"></i></button></a>';
                        $btn_eye = '<a class="mx-1 viewdata" value="' . $data->id . '" title="view order" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><button class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-placement="top" title="View Order"><i class="fa fa-eye"></i></button></a>';
            
                        $btn = $btn_print . $btn_eye . $btn_dollar . $btn_cross;
                        return $btn;
                })

                ->rawColumns(['checkbox', 'order_delivery_time', 'action', 'customer_name','order_number', 'customer_address', 'order_status', 'order_cancel'])
                ->make(true);
        }
            return view('backend.orders.order', compact('generalsetting','order_beep_status'));
    }


    // View Order Detial 
    public function OrderDetail(Request $request)
    {
        $single_order_detail = Order::where('id',$request->order_id)->first();        
        $single_order_products_detail =  json_decode(  $single_order_detail->order_products);

      return   OrderProductRecieptHelper( $single_order_products_detail,$single_order_detail);
    }


    // Order Print
    public function OrderPrint(Request $request)
    {

        $single_order_detail = Order::where('id',$request->order_id)->first();        
        $single_order_products_detail =  json_decode(  $single_order_detail->order_products);

      return   OrderProductRecieptHelper( $single_order_products_detail,$single_order_detail);

    }

    // Order Paid
    public function OrderPaid(Request $request)
    {
        $response = [];
      $order_paid  =  Order::where('id',$request->order_paid_id)->update(['order_status'=> 'P']);
      if($order_paid){
        $response['statuscode'] = 200;
        $response['message'] = 'Order Paid Successfully';
      }

      return response()->json($response);
    }

    // Remove Order Highlight
    public function RemoveOrderHighlight(Request $request)
    {
        $response = [];

        Order::where('order_slug',$request->order_slug)->update(['order_highlight' => 'I','order_beep_status' => 'I', 'order_alert' => 'I']);

        $response['statuscode'] = 200;

        return response()->json($response);
    }
    //  Order Sound Beep 
    public function OrderSoundBeep()
    {
        $beep_status = false;
        $response = [];
        $order_beep_data = Order::where(['order_highlight' => 'A' ,'order_beep_status' => 'A','order_alert' => 'A'])->get();
        if(count($order_beep_data) > 0  && !empty($order_beep_data) && $order_beep_data != null ){
            $beep_status = true;
        }else{
            
            $beep_status = false;
        }

        if($beep_status == true){
        $order_sound_status_count  = $this->OrderSoundStatusCount();
            $response['order_sound_status_count'] =  $order_sound_status_count; 
            $response['statuscode'] = 200;
        }else{
            if($beep_status == false){
             $order_sound_status_count  = $this->OrderSoundStatusCount();
             $response['order_sound_status_count'] =  $order_sound_status_count; 
            }
        }

        return response()->json($response);
    }

    // Offf Sound Beep 
    public function OrderSoundBeepOff(Request $request)
    {
        $response = [];
        Order::where('order_beep_status' , 'A')->update(['order_beep_status' => 'I']);
        $order_sound_status_count  = $this->OrderSoundStatusCount();
        $response['statuscode']  = 200; 
        $response['order_sound_status_count'] = $order_sound_status_count;
        return response()->json($response);
    }

    // Order Sound Status Count
        function OrderSoundStatusCount()
        {
          return   Order::where('order_beep_status','A')->count();
        }

    // Multi Checkbox data delete
    public function DelMultiCheckbox(Request $request)
    {
        $order_checkboxes_id = $request->multi_checkbox_data;
        $response = array();
        if (isset($order_checkboxes_id)) {
            foreach ($order_checkboxes_id as $key => $order_checkboxes_id_list) {

                $delete_order_list = Order::where('id', $order_checkboxes_id_list)->delete();
            }

            if ($delete_order_list) {
                $response['statuscode'] = 200;
                $response['message'] = "select checkboxes delete data";
                return response()->json($response);
            }
        } else {
            $response['statuscode'] = 204;
            $response['message'] = "unable data";
            return response()->json($response);
        }
    }


    // Delete Order
    public function CancelOrder(Request $request)
    {
        $del_order = Order::where('id', $request->cancel_order_id)->update(['order_cancel' => 'A','order_beep_status'=> 'I']);
        if ($del_order) {
            $arr['statuscode'] = 200;
            $arr['message'] = 'Cancel Order Successfully';
            return response()->json($arr);
        }

    }
}
