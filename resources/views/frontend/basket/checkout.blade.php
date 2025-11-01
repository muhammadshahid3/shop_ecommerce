@extends('frontend.layout.master')

@section('content')

{{-- page loader --}}
<div class="text-center" id="checkout-loader-box" style="margin-top:10%; margin-bottom:10%;">
   <div class="spinner-border" style="width: 6rem; height: 6rem;" role="status">
      <span class="visually-hidden">Loading...</span>
   </div>
</div>

<main id="checkout-page" style="display:none;">

   <!-- breadcrumb area start -->
   <section class="breadcrumb__area include-bg pt-50 pb-50" data-bg-color="#EFF1F5">
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="breadcrumb__content p-relative z-index-1">
                  <h3 class="breadcrumb__title">Checkout</h3>
                  <div class="breadcrumb__list">
                     <span><a href="{{route('website')}}">Home</a></span>
                     <span><a href="{{route('show.basket')}}">Shopping Cart</a></span>
                     <span>Checkout</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- breadcrumb area end -->

   <!-- checkout area start -->
   <section class="tp-checkout-area pb-120" data-bg-color="#EFF1F5">
      <form action="" id="form_value_get" class="reset_fields" method="post">
         @csrf
         <div class="container">
            <div class="row">

               <div class="col-lg-7">

                  <div class="row">
                     <div class="col-lg-12">

                        <div class="tp-checkout-bill-area">
                           <h3 class="tp-checkout-bill-title">Billing Details</h3>

                           <div class="tp-checkout-bill-form">
                              <div class="tp-checkout-bill-inner">

                                 {{-- customer detail --}}
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="tp-checkout-input">
                                          <label>Full Name <span>*</span></label>
                                          <input type="text" name="username" autocomplete="off" id="fullname"
                                             value="{{$customer_info->username}}" placeholder="your full name" disabled>
                                          <span class="text-danger" id="fullname_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="tp-checkout-input">
                                          <label>Phone <span>*</span></label>
                                          <input type="text" name="phone_number" autocomplete="off" id="phone_number"
                                             value="{{$customer_info->phone_number}}" class="phone"
                                             placeholder="03XX-XXXXXXX" disabled>
                                          <span class="text-danger" id="phone_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="tp-checkout-input">
                                          <label>Email Address <span>*</span></label>
                                          <input type="email" name="email" autocomplete="off" id="email"
                                             value="{{$customer_info->email}}" placeholder="your email" disabled>

                                          <input type="hidden" name="customer_id" id="customer_id"
                                             value="{{$customer_info->id}}">
                                          <span class="text-danger" id="email_error"></span>
                                       </div>
                                    </div>
                                 </div>

                              </div>
                           </div>

                        </div>

                     </div>

                     <div class="col-lg-12 pt-4 collection_status">

                        <div class="tp-checkout-bill-area">
                           <h3 class="tp-checkout-bill-title">Delivery Details</h3>

                           <div class="tp-checkout-bill-form">
                              <div class="tp-checkout-bill-inner">

                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="tp-checkout-input">
                                          <label>House Name|No <span>*</span></label>
                                          <input type="text" name="house_no" autocomplete="off" id="houseinfo"
                                             placeholder="start writing your address here">
                                          <span class="err text-danger house_info_error"
                                             id="house_details_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="tp-checkout-input">
                                          <label>Street <span>*</span></label>
                                          <input type="text" name="street" autocomplete="off" id="address"
                                             placeholder="street name">
                                          <span class="err text-danger address_error" id="address_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="tp-checkout-input">
                                          <label>Town / City <span>*</span></label>
                                          <input type="text" name="city" autocomplete="off" id="city_name"
                                             placeholder="city or town name">
                                          <span class="err text-danger city_error" id="cityname_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="tp-checkout-input">
                                          <label>Postcode ZIP <span>*</span></label>
                                          <input type="text" name="postcode" autocomplete="off" id="city_code"
                                             placeholder="postcode">
                                          <span class="err text-danger postcode_error" id="citycode_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="tp-checkout-input">
                                          <label>Order notes (optional)</label>
                                          <textarea name="message" id="order_msg" autocomplete="off"
                                             placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- tp-checkout-bill-area -->

                              </div>
                           </div>

                        </div>

                     </div>

                  </div>

               </div>

               <div class="col-lg-5">
                  <!-- checkout place order -->
                  <div class="tp-checkout-place white-bg">
                     {{--Collection Type--}}
                     <input type="hidden" name="" id="select_collection" value="C">
                     <div class="row bg-secondary rounded-pill p-1">
                        @if (isset($generalsetting) && $generalsetting->order_collection_type == 'C')

                        <div class="col-6 text-white rounded-pill p-2 collection_type">
                           <input type="radio" name="C" value="C" onchange="changeCollection('C')" id="collection-pill"
                              class="btn-check" checked>
                           <label for="collection-pill" class="custom-radio-btn-txt">Collection</label>
                        </div>

                        @endif

                        @if (isset($generalsetting) && $generalsetting->order_delivery_type == 'D')

                        <div class="col-6 p-2 text-white delivery_type collection_type">
                           <input type="radio" name="C" value="D" onchange="changeCollection('D')" id="delivery-pill"
                              class="btn-check">
                           <label for="delivery-pill" class="custom-radio-btn-txt">Delivery</label>
                        </div>

                        @endif
                     </div>
                     <span class="err text-danger collection_type_error"></span>

                     <h3 class="tp-checkout-place-title mt-3">Your Order</h3>

                     <div class="tp-order-info-list">
                        <ul>

                           <!-- header -->
                           <li class="tp-order-info-list-header border-bottom">
                              <h4 class="fw-bold">Products</h4>
                              <h4 class="fw-bold">Price</h4>
                           </li>

                           <!-- item list -->
                           <span id="product_render">
                              
                           </span>

                           {{-- subtotal --}}
                           <li class="tp-order-info-list-subtotal border-top border-bottom">
                              <span class="fw-bold">Subtotal</span>
                              <span class="fw-bold" id="subtotal_product"></span>
                           </li>

                           {{-- hidden fields --}}
                           <input type="hidden" id="shipping_charges" value="{{$generalsetting->shipping_charges}}">
                           <input type="hidden" id="shipping_status" value="{{$generalsetting->shipping_status}}">
                           <input type="hidden" id="discount_value" value="{{$generalsetting->discount_value}}">
                           <input type="hidden" id="discount_type" value="{{$generalsetting->discount_type}}">
                           <input type="hidden" id="get_decimal_shipping_charges"
                              value="{{GetTwodecimalHelper($generalsetting->shipping_charges)}}">
                           {{-- hidden fields --}}

                           {{-- discount --}}
                           <span id="discount_box">
                              @if ($generalsetting->discount_type == 'V')

                              <li class="tp-order-info-list-subtotal border-bottom">
                                 <span class="fw-bold">Discount</span>
                                 <span>${{$generalsetting->discount_value}}</span>
                              </li>

                              @elseif($generalsetting->discount_type == 'P')

                              <li class="tp-order-info-list-subtotal border-bottom">
                                 <span class="fw-bold">Discount (Percent:{{$generalsetting->discount_value}}%)</span>
                                 <span class="" id="discount_price"></span>
                              </li>

                              @endif
                           </span>
                           {{-- discount --}}

                           {{-- shipping charges --}}
                           <span class="flat_charges"></span>
                           {{-- shipping charges --}}

                            {{-- coupon discount --}}
                            <span class="coupon_discount"></span>
                            {{-- coupon discount --}}

                           <!-- total -->
                           <li class="tp-order-info-list-subtotal border-bottom">
                              <span class="fw-bold">Total</span>
                              <span id="subtotal_product_price"></span>
                           </li>
                        </ul>
                     </div>

                     <div class="tp-checkout-payment mt-3">
                        {{--Pay by cart--}}
                        @if ($generalsetting->pay_by_card == 'A')
                        <div class="tp-checkout-payment-item select_payment_box">
                           <input type="radio" id="back_transfer" class="pay_by_card" name="payment" value="PBC">
                           <label for="back_transfer">Pay by Card</label>
                           <span class="fa fa-circle-info ms-2" data-bs-toggle="popover" title="Information"
                              data-bs-content="Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account."></span>
                        </div>
                        @endif
                        {{--Pay by cart End--}}

                        {{--Cash on Delivery End--}}

                        @if ($generalsetting->pay_by_cash == 'A')
                        <div class="tp-checkout-payment-item select_payment_box">
                           <input type="radio" id="cheque_payment" class="cash_on_delivery" name="payment" value="COD">
                           <label for="cheque_payment">Cash on Delivery</label>
                           <span class="fa fa-circle-info ms-2" data-bs-toggle="popover" title="Information"
                              data-bs-content="Make your payment directly by using cash. Your order will not be handover to you until the funds have cleared to courior agent."></span>
                        </div>
                        @endif

                        <span class="err text-danger payment_method_error"></span>
                        {{--Cash on Delivery End--}}
                        {{-- Coupon Code --}}

                        <div class="row mb-5">
                           <div class="col-12">
                              <form action="" method="post">

                              <div class="input-group mb-3" >
                                 <input type="text" class="form-control" onkeyup="typeCoupon()"  placeholder="write coupon here" id="get_coupon_code" >
                                 <span class="input-group-text bg-primary text-white" id="coupun" style="cursor:pointer" onclick="applyCoupon()">Apply</span>
                               </div>

                              </form>
                           </div>
                          
                        </div>

                        {{-- Coupon Code End --}}

                        <div class="tp-checkout-btn-wrapper">
                           <button id="placeorder" class="tp-checkout-btn w-100">Place Order</button>
                        </div>
                     </div>

                  </div>

               </div>
            </div>
      </form>
   </section>
   <!-- checkout area end -->


</main>

@endsection

@section('js_scripts')

<script src="{{asset('frontend_assets/custom-js/checkout.js')}}"></script>

<script type="text/javascript">
   // validate phone number //
   document.getElementById('phone_number').addEventListener('input', function (e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,7})/);
      e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2];
   });


   // place order method //
   $(document).ready(function () {

      $("#placeorder").click( async function (e) {
         e.preventDefault();
         const token = $("meta[name='csrf-token']").attr('content');         
         var basket_items = localStorage.getItem('basket');
         var coupon_data = localStorage.getItem('coupon');
         const customer_id = $('#customer_id').val();
         const house_info = $('#houseinfo').val();
         const address = $('#address').val();
         const city_name = $('#city_name').val();
         const postcode = $('#city_code').val();
         const order_msg = $('#order_msg').val();
         const payment_method = $(".select_payment_box input[type='radio']:checked").val();
         const collection_type = $(".collection_type input[type='radio']:checked").val();
            
         await $.ajax({
            url: place_order_route,
            method: "POST",
            dataType: 'json',
            async: false,
            data: {
               'house_info': house_info, 
               'address': address, 
               'city': city_name,
               'postcode': postcode, 
               'order_msg': order_msg, 
               'basket_items': basket_items,
               'collection_type': collection_type, 
               'payment_method': payment_method, 
               'coupon_data' : coupon_data,
               '_token': token,
            },
            success: function (response) {

               $(".err").text('');
               if (response.error) {
                  // Validation error handle
                  $.each(response.error, function (key, value) {

                     $("." + key + "_error").text(value);

                  });

               } else {

                  if (response.statuscode == 400) {
                     swalMixinAlertHelper('error', response.message);
                     localStorage.removeItem('coupon');
                     window.location.href = website_route;
                     // console.log(response.message);

                  } else if(response.statuscode == 422){
                     swalMixinAlertHelper('error', response.message);
                     //  $("#placeorder").attr("disabled", true);


                  }else if(response.statuscode == 204){
                     swalMixinAlertHelper('error', response.message);

                  }else{
                     if(response.statuscode == 200){
                        // $("#placeorder").removeAttr("disabled");
                     $("#placeorder").attr("disabled", true);
                        $('.reset_fields').trigger("reset");
                        // console.log(response.order_id);
                        setTimeout(swalMixinAlertHelper('success','Order Place Successfully'), 5000);
                        if(response.payment_method == 'PBC'){
                           
                           window.location.href = "{{route('stripe.checkout.order','')}}" + "/" + response.order_id;                          
                        }else{
                           
                           localStorage.removeItem('basket');
                           localStorage.removeItem('coupon');
                           window.location.href=  website_url;  

                        }
                     }
                  
                  }
               }
            },
            error: function (error) {
               console.log(error);
            }
         });
      });
        
   });

</script>

@endsection