@extends('frontend.layout.master')

@section('content')

<main>

   <!-- breadcrumb area start -->
   <section class="breadcrumb__area include-bg pt-50 pb-50">
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="breadcrumb__content p-relative z-index-1">
                  <h3 class="breadcrumb__title">Shopping Cart</h3>
                  <div class="breadcrumb__list">
                     <span><a href="{{route('website')}}">Home</a></span>
                     <span>Shopping Cart</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- breadcrumb area end -->

   <!-- cart area start -->
   <section class="tp-cart-area pb-120">
      <div class="container">
         <div class="row">
            <div class="col-xl-9 col-lg-8">

               <div class="tp-cart-list mb-25 mr-30">
                  <table class="table">

                     <thead>
                        <tr>
                           <th colspan="2" class="tp-cart-header-product">Product</th>
                           <th class="tp-cart-header-price">Price</th>
                           <th class="tp-cart-header-quantity">Quantity</th>
                           <th>Action</th>
                        </tr>
                     </thead>

                     <tbody id="basket-items-box">

                        {{-- <tr>
                           <td class="tp-cart-img"><a href="product-details.html"> <img
                                    src="{{asset('frontend_assets/img/product/cart/product-cart-1.jpg')}}" alt=""></a>
                           </td>
                           <td class="tp-cart-title"><a href="product-details.html">Legendary Whitetails Wmen's.</a>
                           </td>
                           <td class="tp-cart-price"><span>$76.00</span></td>
                           <td class="tp-cart-quantity">
                              <div class="tp-product-quantity mt-10 mb-10">
                                 <span class="tp-cart-minus">
                                    <svg width="10" height="2" viewBox="0 0 10 2" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
                                       <path d="M1 1H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                    </svg>
                                 </span>
                                 <input class="tp-cart-input" type="text" value="1">
                                 <span class="tp-cart-plus">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
                                       <path d="M5 1V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                       <path d="M1 5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                    </svg>
                                 </span>
                              </div>
                           </td>
                           <td class="tp-cart-action">
                              <button class="tp-cart-action-btn">
                                 <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                       d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z"
                                       fill="currentColor" />
                                 </svg>
                                 <span>Remove</span>
                              </button>
                           </td>
                        </tr> --}}

                     </tbody>
                  </table>
               </div>

               <div class="tp-cart-bottom">
                  <div class="row align-items-end">

                     <div class="col-xl-6 col-md-8">
                        {{-- <div class="tp-cart-coupon">
                           <form action="#">
                              <div class="tp-cart-coupon-input-box">
                                 <label>Coupon Code:</label>
                                 <div class="tp-cart-coupon-input d-flex align-items-center">
                                    <input type="text" placeholder="Enter Coupon Code">
                                    <button type="submit">Apply</button>
                                 </div>
                              </div>
                           </form>
                        </div> --}}
                     </div>

                     <div class="col-xl-6 col-md-4">
                        <div class="tp-cart-update text-md-end">
                           <button type="button" class="tp-cart-update-btn mr-30" id="clear-basket-btn"
                              onclick="clearLocalStorageBasket()" style="display:none;">Clear Cart</button>
                        </div>
                     </div>

                  </div>
               </div>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
               <div class="total_calculate">

                  <div class="tp-cart-checkout-wrapper">
                     {{-- <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                        <span class="tp-cart-checkout-top-title">Subtotal</span>
                        <span class="tp-cart-checkout-top-price">$<span class="basket-subtotal-price"></span></span>
                     </div> --}}
                     {{-- <div class="tp-cart-checkout-shipping">
                        <h4 class="tp-cart-checkout-shipping-title">Shipping</h4>

                        <div class="tp-cart-checkout-shipping-option-wrapper">
                           <div class="tp-cart-checkout-shipping-option">
                              <input id="flat_rate" type="radio" name="shipping">
                              <label for="flat_rate">Flat rate: <span>$20.00</span></label>
                           </div>
                           <div class="tp-cart-checkout-shipping-option">
                              <input id="free_shipping" type="radio" name="shipping">
                              <label for="free_shipping">Free shipping</label>
                           </div>
                        </div>
                     </div> --}}
                     <div class="tp-cart-checkout-total d-flex align-items-center justify-content-between">
                        <span>Total Quantity</span>
                        <span><span class="basket-total-qty"></span></span>
                     </div>
                     <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                        <span>Total Price</span>
                        <span>$<span class="basket-total-price"></span></span>
                     </div>
                     <div class="tp-cart-checkout-proceed">
                        <button type="button" class="tp-cart-checkout-btn w-100" onclick="proceedCheckoutBtn()">Proceed to Checkout</button>
                        {{-- <a href="{{ route('basket.checkout') }}" class="tp-cart-checkout-btn w-100">Proceed to Checkout</a> --}}
                     </div>
                  </div>

               </div>

            </div>
         </div>
      </div>
   </section>
   <!-- cart area end -->

</main>

@endsection

@section('js_scripts')

<script type="text/javascript">

   
   const loadSingleProductData = (products) => {
      var load_products_string = '';

      products.forEach(product_element => {
         let product_element_product_route = "{{route('product.detail', '')}}" + "/" + product_element.product_slug;

         var product_element_product_price = parseFloat(product_element.product_qty) * parseFloat(product_element.product_price);

         load_products_string = load_products_string + `<tr>
            <td class="tp-cart-img"><a href="${product_element_product_route}"> 
               <img src="{{asset('upload/product/${product_element.product_thumbnail}')}}" alt="product-pic">
            </a></td>
            <td class="tp-cart-title">
               <p></p>
               <a href="${product_element_product_route}">${product_element.product_name}</a>
            </td>
            <td class="tp-cart-price"><span>$${parseFloat(product_element_product_price).toFixed(2)}</span></td>
            <td class="tp-cart-quantity">
               <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-outline-secondary basket-btn-qty-dec" onclick="decreaseProductQty(${product_element.product_slug})">
                     <svg width="10" height="2" viewBox="0 0 10 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </button>
                  <button type="button" class="btn btn-outline-secondary basket-btn-qty-val">${product_element.product_qty}</button>
                  <button type="button" class="btn btn-outline-secondary basket-btn-qty-inc" onclick="increaseProductQty(${product_element.product_slug})">
                     <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1 5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </button>
               </div>
            
            </td>
            <td class="tp-cart-action">
               <button class="tp-cart-action-btn text-danger" onclick="removeProductBasket(${product_element.product_slug})">
                  <svg class="" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor"/>
                  </svg>
                  <span>Remove</span>
               </button>
            </td>
         </tr>`;
      })

      return load_products_string;
   }


   const loadBasketProducts = () => {
      
      var localstorage_basket = localStorage.getItem('basket');

      // if basket is not empty //
      if (localstorage_basket) {
         var parse_products_array = JSON.parse(localstorage_basket);

         if (parse_products_array && parse_products_array.length > 0) {

            var load_products_list = loadSingleProductData(parse_products_array);
             // Basket Products
             $("#basket-items-box").html(load_products_list);
            // Calculation Product
            var basket_items = countBasketItemsAndPriceHelper();
            // Total Calculation
            $(".basket-total-qty").html(basket_items.total_items_qty);
            $(".basket-total-price").html(parseFloat(basket_items.total_items_price).toFixed(2));

            // Clear Basket Data
            $("#clear-basket-btn").show();

         } else {
            // Total Calculation
            $(".basket-total-qty").html('0');
            $(".basket-total-price").html('0');
            
            $("#basket-items-box").html('<tr><td colspan="5"><p class="text-center">Empty Cart</p></td></tr>');
            $("#clear-basket-btn").hide();
         }

      } else {

         // Total Calculation
         $(".basket-total-qty").html('0');
         $(".basket-total-price").html('0');
         
         $("#basket-items-box").html('<tr><td colspan="5"><p class="text-center">Empty Cart</p></td></tr>');
         $("#clear-basket-btn").hide();
      }

      countBasketItems();
   }
   loadBasketProducts();


   const proceedCheckoutBtn = () => {

      var basket_storage_status = checkLocalStorageBasketHelper();

      if (basket_storage_status == 'true') {
         window.location.href = basket_checkout_url;

      } else if (basket_storage_status == 'false') {
         swalMixinAlertHelper('warning', 'Please Add Product in Cart');
      }
   }
   // proceedCheckoutBtn();
   // window.history.back();

</script>

@endsection