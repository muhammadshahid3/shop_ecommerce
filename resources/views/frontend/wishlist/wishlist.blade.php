@extends('frontend.layout.master')

@section('content')

<main>

   <!-- breadcrumb area start -->
   <section class="breadcrumb__area include-bg pt-50 pb-50">
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="breadcrumb__content p-relative z-index-1">
                  <h3 class="breadcrumb__title">Wishlist Cart</h3>
                  <div class="breadcrumb__list">
                     <span><a href="{{route('website')}}">Home</a></span>
                     <span>Wishlist Cart</span>
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
            <div class="col-xl-12 col-lg-12">

               <div class="tp-cart-list mb-25 mr-30">
                  <table class="table">

                     <thead>
                        <tr>
                           <th colspan="2" class="tp-cart-header-product">Product</th>
                           <th class="tp-cart-header-price">Price</th>
                           <th>Add to Cart</th>
                           <th>Action</th>
                        </tr>
                     </thead>

                     <tbody id="basket-items-box">

                     

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
                              onclick="clearLocalStorageWishlist()" style="display:none;">Clear Wishlist</button>
                        </div>
                     </div>

                  </div>
               </div>

            </div>

            <!-- <div class="col-xl-3 col-lg-4 col-md-6">
               <div class="total_calculate">

               </div>   

            </div> -->
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
         let product_element_product_route = "{{route('product.detail', parameters: '')}}" + "/" + product_element.product_slug;

         var product_element_product_price = parseFloat(product_element.product_qty) * parseFloat(product_element.product_price);

         load_products_string = load_products_string + `<tr>
            <td class="tp-cart-img"><a href="${product_element_product_route}"> 
               <img src="{{asset(path: 'upload/product/${product_element.product_thumbnail}')}}" alt="product-pic">
            </a></td>
            <td class="tp-cart-title">
               <a href="${product_element_product_route}">${product_element.product_name}</a>
            </td>
            <td><span>$${parseFloat(product_element_product_price).toFixed(2)}</span></td>
            <td>
               <span onclick="addProductBasketRemoveWishlist(${product_element.product_slug})" class="wishlist-basket-icon-color" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Favourite Items">
                  <svg width="26" height="28" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M3.34706 4.53799L3.85961 10.6239C3.89701 11.0923 4.28036 11.4436 4.74871 11.4436H4.75212H14.0265H14.0282C14.4711 11.4436 14.8493 11.1144 14.9122 10.6774L15.7197 5.11162C15.7384 4.97924 15.7053 4.84687 15.6245 4.73995C15.5446 4.63218 15.4273 4.5626 15.2947 4.54393C15.1171 4.55072 7.74498 4.54054 3.34706 4.53799ZM4.74722 12.7162C3.62777 12.7162 2.68001 11.8438 2.58906 10.728L1.81046 1.4837L0.529505 1.26308C0.181854 1.20198 -0.0501969 0.873587 0.00930333 0.526523C0.0705036 0.17946 0.406255 -0.0462578 0.746256 0.00805037L2.51426 0.313534C2.79901 0.363599 3.01576 0.5995 3.04042 0.888012L3.24017 3.26484C15.3748 3.26993 15.4139 3.27587 15.4726 3.28266C15.946 3.3514 16.3625 3.59833 16.6464 3.97849C16.9303 4.35779 17.0493 4.82535 16.9813 5.29376L16.1747 10.8586C16.0225 11.9177 15.1011 12.7162 14.0301 12.7162H14.0259H4.75402H4.74722Z" fill="currentColor"></path>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6629 7.67446H10.3067C9.95394 7.67446 9.66919 7.38934 9.66919 7.03804C9.66919 6.68673 9.95394 6.40161 10.3067 6.40161H12.6629C13.0148 6.40161 13.3004 6.68673 13.3004 7.03804C13.3004 7.38934 13.0148 7.67446 12.6629 7.67446Z" fill="currentColor"></path>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38171 15.0212C4.63756 15.0212 4.84411 15.2278 4.84411 15.4836C4.84411 15.7395 4.63756 15.9469 4.38171 15.9469C4.12501 15.9469 3.91846 15.7395 3.91846 15.4836C3.91846 15.2278 4.12501 15.0212 4.38171 15.0212Z" fill="currentColor"></path>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38082 15.3091C4.28477 15.3091 4.20657 15.3873 4.20657 15.4833C4.20657 15.6763 4.55592 15.6763 4.55592 15.4833C4.55592 15.3873 4.47687 15.3091 4.38082 15.3091ZM4.38067 16.5815C3.77376 16.5815 3.28076 16.0884 3.28076 15.4826C3.28076 14.8767 3.77376 14.3845 4.38067 14.3845C4.98757 14.3845 5.48142 14.8767 5.48142 15.4826C5.48142 16.0884 4.98757 16.5815 4.38067 16.5815Z" fill="currentColor"></path>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9701 15.0212C14.2259 15.0212 14.4333 15.2278 14.4333 15.4836C14.4333 15.7395 14.2259 15.9469 13.9701 15.9469C13.7134 15.9469 13.5068 15.7395 13.5068 15.4836C13.5068 15.2278 13.7134 15.0212 13.9701 15.0212Z" fill="currentColor"></path>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9692 15.3092C13.874 15.3092 13.7958 15.3874 13.7958 15.4835C13.7966 15.6781 14.1451 15.6764 14.1443 15.4835C14.1443 15.3874 14.0652 15.3092 13.9692 15.3092ZM13.969 16.5815C13.3621 16.5815 12.8691 16.0884 12.8691 15.4826C12.8691 14.8767 13.3621 14.3845 13.969 14.3845C14.5768 14.3845 15.0706 14.8767 15.0706 15.4826C15.0706 16.0884 14.5768 16.5815 13.969 16.5815Z" fill="currentColor"></path>
                  </svg>
               </span>
               <!-- Product_hidden fields -->
               <span><span><span>
                  <input type="hidden" name="${product_element.product_slug}_c_slug" value="${product_element.category_slug}">
                  <input type="hidden" name="${product_element.product_slug}_name" value="${product_element.product_name}">
                  <input type="hidden" name="${product_element.product_slug}_price" value="${parseFloat(product_element.product_price).toFixed(2)}">
                  <input type="hidden" name="${product_element.product_slug}_s_qty" value="${product_element.stock_quantity}">
                  <input type="hidden" name="${product_element.product_slug}_pro_qty" value="">
                  <input type="hidden" name="${product_element.product_slug}_thumbnail" value="${product_element.product_thumbnail}">
               </span></span></span> 
               <!-- Product_hidden fields End -->
            </td>
         
            <td class="tp-cart-action">
               <button class="tp-cart-action-btn text-danger" onclick="removeProductWishlist(${product_element.product_slug})">
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

  

   const loadWishlistProducts = () => {
      var localstorage_basket = localStorage.getItem('wishlist');

      // if basket is not empty //
      if (localstorage_basket) {
         var parse_products_array = JSON.parse(localstorage_basket);

         if (parse_products_array && parse_products_array.length > 0) {

            var load_products_list = loadSingleProductData(parse_products_array);
             // Basket Products
             $("#basket-items-box").html(load_products_list);

            // Clear Basket Data
            $("#clear-basket-btn").show();
         }

      } else {

         
         $("#basket-items-box").html('<tr><td colspan="5"><p class="text-center">Empty Wishlist</p></td></tr>');
         $("#clear-basket-btn").hide();
      }


   }

   loadWishlistProducts();

   // Clear Basket Items
   const clearLocalStorageWishlist = () => {

      localStorage.removeItem('wishlist');

      loadWishlistProducts();
      wishlistCounterItems();
   }


   const addProductBasketRemoveWishlist = (product_slug) => {
      if (product_slug) {
         var return_status = addProductBasket(product_slug);

         if(return_status == 'true') {
            removeProductWishlist(product_slug);
         }
      }
   }

</script>

@endsection