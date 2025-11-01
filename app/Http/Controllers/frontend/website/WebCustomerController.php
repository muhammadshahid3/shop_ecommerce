<?php

namespace App\Http\Controllers\frontend\website;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use DB;
use Validator;
use Hash;

use App\Models\Category;
use App\Models\GeneralSetting;

class WebCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customers');
    }

    //Customer Profile
    public function CustomerProfile()
    {
       

        // header data //
        $array_pass = header_helper('Customer Profile');
        $array_pass["customer_info"] = auth()->guard('customers')->user();

        $auth_customer_id = auth()->guard('customers')->user()->id;

        $customer_detail = DB::table('customer_details')->where('customer_id', $auth_customer_id)->orderBy('id', 'DESC')->first();
        if (isset($customer_detail)) {
            $array_pass["customer_detail"] = $customer_detail;
        } else {
            $array_pass["customer_detail"] = [];
        }

        $customer_orders = DB::table('orders')->where('customer_id', $auth_customer_id)->orderBy('id', 'DESC')->get();
        if (isset($customer_orders)) {
            $array_pass["customer_orders"] = $customer_orders;
        } else {
            $array_pass["customer_orders"] = [];
        }

          // Frontend Changes form Admin side
          $cms_text  =  EditContent();
          if(isset($cms_text) && count($cms_text) > 0){
              $array_pass['cms_texts'] = $cms_text;
          }

        return view('frontend.customer.profile', $array_pass);
    }

    // Update Customer Profile
    public function UpdateProfile(Request $request)
    {

        $request->validate([
            'username' => 'required|regex:/^[\pL\s\-]+$/u',
            // 'email' => 'required|unique:customers,email,' . $request->customer_id,
            'phone_number' => "required|numeric|min:11"
        ]);

        $update = Customer::where('id', $request->customer_id)->update([
            'username' => $request->username,
            // 'email' => $request->email,
            'phone_number' => $request->phone_number
        ]);

        if ($update) {
            $request->session()->flash('icon', 'success');
            session()->flash('msg', 'Update Profile Successfully');
            return redirect('customer/profile');
        }
    }

    // Update Customer Password
    public function UpdatePassword(Request $request)
    {

        // Check Validation 
        $validator = Validator::make(
            $request->all(),
            [
                'old_pass' => 'required|digits:6|regex:/^[a-zA-Z0-9 ]*$/',
                'new_pass' => 'required|digits:6|regex:/^[a-zA-Z0-9 ]*$/',
                'con_new_pass' => 'required|digits:6|regex:/^[a-zA-Z0-9 ]*$/',

            ],
            [
                'old_pass' => 'Invalid field*',
                'old_pass.digits' => 'Min 6 char allow',
                'new_pass' => "Invalid field*",
                'new_pass.digits' => 'Min 6 char allow',
                'con_new_pass' => 'Invalid field*',
                'con_new_pass.digits' => 'Min 6 char allow',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['statuscode' => 400, 'error' => $validator->errors()]);
        }

        // Customer get id
        $customer_id = auth()->guard('customers')->user()->id;
        // Check Password data
        if (isset($customer_id)) {
            $customer_detail = Customer::where('id', $customer_id)->first();
            $old_password = $request->old_pass;
            $new_password = $request->new_pass;
            $confirm_password = $request->con_new_pass;

            if (Hash::check($old_password, $customer_detail->password)) {

                if ($new_password == $confirm_password) {

                    $password = bcrypt($new_password);
                    Customer::where('id', $customer_id)->update(['password' => $password]);

                    return response()->json(['statuscode' => 200, 'msg' => 'Update Password Succesfully']);

                } else {

                    return response()->json(['statuscode' => 400, 'error' => ['con_new_pass' => 'The confirm password does not match']]);

                }

            } else {
                return response()->json(['statuscode' => 400, 'error' => ['old_pass' => 'The old password does not match']]);
            }


        } else {
        }

    }

    // Order Details
    public function OrderDetails(Request $request)
    {
        $reciept_product = '';
        $order_additional_details = '';
        $order_product_calc = '';
        $single_order_record = Order::where('id', $request->order_id)->first();

        $single_order = json_decode($single_order_record->order_products);

        // Check Collection Type
        if ($single_order_record->order_delivery_time == 'C') {

            $collection_type = "Collection";
        } else {

            $collection_type = "Deliivery";
        }

        // Check Order Status Type

        if ($single_order_record->order_status == 'U') {

            $order_status = "Unpaid";

        } else {

            $order_status = "Paid";
        }

        // Order Additional Details
        $order_additional_details .= '
      <span><p style="border-bottom: 1px solid #eee;">Order No : ' . $single_order_record->order_number . '</p></span>
      <span><p style="border-bottom: 1px solid #eee;">Payment Status : ' . $order_status . '<span></span>
      <span><p style="border-bottom: 1px solid #eee;">Collection Type : ' . $collection_type . '<span></span>
      <span><p style="border-bottom: 1px solid #eee;"> Date: ' . $single_order_record->order_date . ' </p></span>';

        foreach ($single_order as $single_order_products_list) {

            // Check Product Thumbnail exist
            if (isset($single_order_products_list->product_thumbnail)) {
                if (file_exists(public_path('upload/product/' . $single_order_products_list->product_thumbnail))) {
                    $thumbnail = asset('upload/product/' . $single_order_products_list->product_thumbnail);
                }
            }
            // Fetch Category Name
            $category = Category::select('category_name')->where('category_slug', $single_order_products_list->product_c_slug)->first();

            $reciept_product = $reciept_product . '<tr>
                                  <td>' . $single_order_products_list->product_qty . '</td>
                                  <td> <img src= "' . $thumbnail . '" width="50px" heigth = "50px";></td>
                                  <td>' . $category->category_name . '</td>
                                  <td>' . $single_order_products_list->product_name . '</td>
                                  <td>' . $single_order_products_list->product_price . '</td>
                                  </tr>';
        }

        $total_calculation = BasketCalcToShowOrderDetailHelper($single_order_record);

        if ($total_calculation['statuscode'] == 422) {
            $order_product_calc = '';
        } else {

            if ($single_order_record->order_delivery_time == 'C') {

                if ($total_calculation['discount_type'] == 'V') {
                    $order_product_calc .= '<p style="border-bottom: 1px solid #eee;">Order SubTotal : $' . GetTwodecimalHelper($single_order_record->order_subtotal_price) . '</p>
                        <p style="border-bottom: 1px solid #eee;">Discount (price ' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p>
                        <p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p>';

                } else if ($total_calculation['discount_type'] == 'P'){
                    $order_product_calc .=
                        '<span><p style="border-bottom: 1px solid #eee;">SubTotal : ' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (percentage ' . $total_calculation['discount_price'] . '%): ' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
                } else if ($total_calculation['discount_type'] == 'N' || $total_calculation['discount_type'] == '') {
                    $order_product_calc .=
                        '<span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (price  ' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
                } else {
                    $order_product_calc .=
                        '<span><p style="border-bottom: 1px solid #eee;">SubTotal : ' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
                }
            } elseif ($single_order_record->order_delivery_time == 'D') {

                if ($total_calculation['shipping_status'] == 'F') {

                    if ($total_calculation['discount_type'] == 'V') {
                        $order_product_calc .=
                            '<span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (price ' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
                    } else if ($total_calculation['discount_type'] == 'P') {
                        $order_product_calc .=
                            '<span><p style="border-bottom: 1px solid #eee;">SubTotal : ' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (percentage ' . $total_calculation['discount_price'] . '%): ' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
                    } else if ($total_calculation['discount_type'] == 'N' || $total_calculation['discount_type'] == '') {
                        $order_product_calc .=
                            '<span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Discount (price' . $total_calculation['discount_price'] . '): $' . GetTwodecimalHelper($total_calculation['discount_price']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">Shipping Charges : $' . GetTwodecimalHelper($total_calculation['shipping_charges']) . ' </p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
                    } else {
                        $order_product_calc .=
                            '<span><p style="border-bottom: 1px solid #eee;">SubTotal : $' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
                    }

                } else if ($total_calculation['shipping_status'] == 'N' || $single_order_record->shipping_status == '') {

                    $order_product_calc .=
                        '<span><p style="border-bottom: 1px solid #eee;">SubTotal :$' . GetTwodecimalHelper($total_calculation['subtotal']) . '</p></span>
                        <span><p style="border-bottom: 1px solid #eee;">NetTotal : $' . GetTwodecimalHelper($total_calculation['net_total']) . '</p></span>';
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
        $arr['data'] = $reciept_product;
        $arr['order_addtional_details'] = $order_additional_details;
        $arr['order_product_calc'] = $order_product_calc;
        // $arr['order_calc_price'] = $total_calculation;

        return response()->json($arr);
    }

    
    // Contactus Page
    public function ContactPage()
    {
        // header data //
        $array_pass = header_helper('Contact');
        // Frontend Changes form Admin side
        $cms_text  =  EditContent();
        if(isset($cms_text) && count($cms_text) > 0){
            $array_pass['cms_texts'] = $cms_text;
        }
        return view('frontend.contact.contactus', $array_pass);
    }

    public function SaveContact(Request $request)
    {

        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        $customer_id = auth()->guard('customers')->user()->id;
        if (isset($customer_id)) {
            $customer = $customer_id;
            $subject = $request->subject;
            $message = $request->message;
            $create_msg = Contact::create(['customer_id' => $customer, 'subject' => $subject, 'message' => $message]);
            if ($create_msg) {
                session()->flash('icon', 'success');
                session()->flash('msg', 'Message sent successfully');
                return redirect()->route('website');
            }
        }

    }
}
