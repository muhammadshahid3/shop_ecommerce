<?php

namespace App\Http\Controllers\frontend\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Coupon as AppCoupon;
use DB;
use \Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Coupon;

class PaymentController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth:customers');
    }
    

     public function StripeCheckout($order_slug)
    {
        
        $receive_status = $this->CheckOrderData($order_slug);
        if($receive_status == true){
            $customer  = auth()->guard('customers')->user();
            $customer_email_detail = Customer::where('id',$customer->id)->first();
            $customer_order_detail = Order::where(['order_slug' => $order_slug , 'customer_id'=> $customer->id])->latest()->first();
            $cutomer_order =  json_decode($customer_order_detail->order_products);       
            Stripe::setApiKey(env('STRIPE_SECRET'));
            // Check Discount Value and Type
            $discount_amount = 0;
            $coupon_amount = 0;

            if((float)$customer_order_detail->discount_value > 0){
                $discount_text_value = $customer_order_detail->discount_value;
                $discount_amount = $customer_order_detail->discount_value*100;


                if($customer_order_detail->discount_type == 'V'){
                    $Discount_Text = 'Discount $';
                }else if($customer_order_detail->discount_type == 'P'){
                    $Discount_Text = 'Percentage %';
                }else{
                    $Discount_Text = '';
                }
            }

            // Check Coupon Amount
            
            if((float)$customer_order_detail->discount_value > 0 && $customer_order_detail->coupon_id != null){
                $coupon = AppCoupon::where('id',$customer_order_detail->coupon_id)->first();
                $coupon_text = ' + Coupon $';
                $coupon_text_amount = $coupon->coupon_amount;
                $coupon_amount = $coupon->coupon_amount*100;
            }else{
                $coupon_text = '';
                $coupon_text_amount = '';
            }

            $discount_text =  $Discount_Text .    $discount_text_value .' '. $coupon_text . $coupon_text_amount;


            $calculated_amount = (float)$discount_amount + (float) $coupon_amount;
          
            $coupon = Coupon::create([
                'name' => $discount_text,
                'amount_off' =>  $calculated_amount, // discount
                'currency' => 'pkr',
                'duration' => 'forever', // Applies the discount more time use
                
            ]);
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $redirect_url = route('stripe.checkout.success').'?session_id = {CHECKOUT_SESSION_ID}';

                    // Map the products to Stripe's line_items format
                    $lineItems = array_map(function ($product) {
                        return [
                            'price_data' => [
                                'currency' => 'pkr',
                                'product_data' => [
                                    'name' => $product->product_name,
                                ],
                            
                                'unit_amount' => $product->product_price* 100,
                            ],
                            'quantity' => $product->product_qty,
                        ];
                    },$cutomer_order);
 
                        $response = $stripe->checkout->sessions->create([
                            'customer_email' =>  $customer_email_detail->email,
                            'payment_method_types' => ['card'],
                            'success_url' => $redirect_url,
                            'line_items' => $lineItems,
                            
                            'discounts' => [[
                            'coupon' =>  $coupon->id, // Replace with your actual coupon ID
                            ]],
                        
                            'mode' => 'payment',
                            // 'allow_promotion_codes' => true, 
                            'cancel_url' => route('website'),
                        
                        ]);
                      
                            // dd($response['url']);
                           return redirect($response['url']);

        }else{
            return redirect()->route('website');
        }
        
   

    }
    public function StripeCheckoutSuccess(Request $request)
    {   
       
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id_');
        if(!$sessionId){
            return redirect()->route('website');
        }else{
            try{
                $customer  = auth()->guard('customers')->user();
               $order_detail = Order::where('customer_id',$customer->id)->latest()->first();
               if($order_detail){
                $order_detail->update(['order_status' => 'P']);
               }
                session()->flash('icon','success');
                session()->flash('msg','Payment is Successfully');
                session()->flash('payment_id',$sessionId);
                return redirect()->route('website');
                // return view('frontend.website.index',compact('sessionId'));
              
            }
            catch(Exception $e){
                return $e->getMessage();  
            }
        }

    }
    
    // CheckOrderData
    function CheckOrderData($order_slug)
    {
        $order_status = false;

       $customer  = auth()->guard('customers')->user();

        if($customer){
            $customer_id = $customer->id;
            $customer_detail =  Order::where([
                'customer_id'=> $customer_id , 'order_slug' => $order_slug ,
                'order_status' => 'U' , 'payment_method' => 'PBC' , 'order_cancel' => 'I',
            ])->latest()->first();
                
                if($customer_detail){

                 return $order_status = true;
                }else{
                   return   $order_status = false;
                }
        }

    }

   
  
      
}
