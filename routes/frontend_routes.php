<?php


use App\Http\Controllers\frontend\auth\CustomerLoginController;
use App\Http\Controllers\frontend\website\CheckoutController;
use App\Http\Controllers\frontend\website\WebController;
use App\Http\Controllers\frontend\website\WebCustomerController;
use App\Http\Controllers\frontend\website\WebProductController;
use App\Http\Controllers\frontend\website\WebBasketController;
use App\Http\Controllers\frontend\website\WebWishlistController;
use App\Http\Controllers\frontend\website\PaymentController;
use App\Http\Controllers\backend\main\CouponController;

// Start Frontend Controllers//

/*preventbackhistory middleware*/
Route::group(['middleware' => 'customer_prevent_history'], function () {


  Route::controller(WebController::class)->group(function () {

    Route::get('/', 'Website')->name('website');
    Route::get('newarrivalsproducts/{item}', 'NewarrivalsProducts')->name('newarrivals.products');
    Route::get('featuresproducts/{item}', 'FeaturesProducts')->name('features.products');
    Route::get('topsellersproducts/{item}', 'TopsellersProducts')->name('topsellers.products');
    Route::get('privacypolicy', 'PrivacyPolicy')->name('privacypolicy');
    // Search Product
    Route::post('search', 'Search')->name('search')->middleware('throttle: 60,1');
    // About Controller
    Route::get('about', 'ShowAbout')->name('about');
    // FAQ Controller
    Route::get('faq', 'ShowFaq')->name('faq');
    // Blog Controller
    Route::get('show-blog', 'ShowBlog')->name('show-blog');

  });

    // Customer  Auth Routes
  Route::controller(CustomerLoginController::class)->group(function () {

    Route::get('customer/login', 'Login')->name('customer.login')->middleware('customerlogin');
    Route::post('customer/login', 'CheckLogin')->name('customer.checklogin');
    Route::get('customer/register', 'Register')->name('customer.register');
    Route::post('customer/register/store', 'RegisterStore')->name('customer.register.store');
    Route::get('customer/logout', 'Logout')->name('customer.logout');

  });


    // Customer Routes
  Route::controller(WebCustomerController::class)->group(function () {

      Route::get('customer/profile', 'CustomerProfile')->name('customer.profile');
      Route::post('customer/updateprofile', 'UpdateProfile')->name('customer.updateprofile');
      Route::post('customer/updatepassword', 'UpdatePassword')->name('customer.updatepassword');
      Route::post('customer/orderdetail', 'OrderDetails')->name('customer.order.detail');
      Route::get('customer/contact', 'ContactPage')->name('customer.contact');
      Route::post('customer/contact/save', 'SaveContact')->name('customer.contact.save');
      
  });  


  // Web Product Routes
  Route::controller(WebProductController::class)->group(function () {

      Route::get('products/{slug}', 'CategoryProducts')->name('category.products');
      Route::get('product/{slug}/{item?}', 'ProductDetail')->name('product.detail');
      Route::post('product/submit-rating', 'ProductRating')->name('product.submit-rating');
      Route::post('product/avg-rating', 'AvgRating')->name('product.avg-rating');
      // Route::get('all-ratings', 'AllRating')->name('product.all-rating');
      Route::get('products', 'Products')->name('products');
      Route::get('productfilter', 'ProductFilter')->name('productfilter');
      Route::post('categoryfilter', 'FilterCategory')->name('categoryfilter');
      Route::post('pricefilter', 'PriceFilter')->name('pricefilter');
      Route::post('stockfilter', 'StockFilter')->name('stockfilter');

  });
  

  Route::get('basket', [WebBasketController::class, 'ShowBasket'])->name('show.basket');
  Route::post('verify-basket', [CheckoutController::class, 'VerifyBasket'])->name('verify.basket');
  Route::get('wishlist', [WebWishlistController::class, 'ShowWishlist'])->name('show.wishlist');

  // Checkout Controller
  Route::get('checkout', [CheckoutController::class, 'BasketCheckout'])->name('basket.checkout');
  // Order Controller
  

    Route::get('stripe/checkout/order/{order_slug}',[PaymentController::class,'StripeCheckout'])->name('stripe.checkout.order');
    Route::get('stripe/checkout/success',[PaymentController::class,'StripeCheckoutSuccess'])->name('stripe.checkout.success');
    //coupon Code
    Route::post('couponcode',[CouponController::class,'CouponCode'])->name('couponcode');
    
    // End Frontend Controllers//

});


