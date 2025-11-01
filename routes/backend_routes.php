<?php

use App\Http\Controllers\backend\main\AdminDashboardController;
use App\Http\Controllers\backend\auth\loginController;
use App\Http\Controllers\backend\main\BannerController;
use App\Http\Controllers\backend\main\BlogController;
use App\Http\Controllers\backend\main\CustomerController;
use App\Http\Controllers\backend\main\FAQController;
use App\Http\Controllers\backend\main\ProfileController;
use App\Http\Controllers\backend\main\GeneralSettingController;
use App\Http\Controllers\backend\main\CategoryController;
use App\Http\Controllers\backend\main\ProductController;
use App\Http\Controllers\backend\main\ContactController;
use App\Http\Controllers\backend\main\TermCondition;
use App\Http\Controllers\backend\main\OrderController;
use App\Http\Controllers\backend\main\CouponController;
use App\Http\Controllers\backend\main\CmsTextController;




// =============================Start Backend Routes==============================//

// Admin Login Controller
Route::get('admin/login', [loginController::class, 'login'])->name('admin.login')->middleware('adminlogin');
Route::post('admin/login', [loginController::class, 'checklogin'])->name('admin.checklogin');
Route::get('admin/logout', [loginController::class, 'logout'])->name('admin.logout');

// admindashboard middleware is for guard authentication //
Route::middleware(['admindashboard', 'admin_prevent_history'])->group(function () {
   // Edit Content As a Frontend 
   Route::controller(CmsTextController::class)->group(function () {
      Route::post('admin/edit-content', 'EditContent')->name('admin.edit-content');
      Route::post('admin/summernote-upload-image', 'SummernoteUploadImage')->name('admin.summernote-upload-image');

   });
   // Admin customer Controller
   Route::controller(CustomerController::class)->group(function () {
      Route::get('admin/customer/show', 'AllCustomers')->name('admin.customer.show');
      Route::get('admin/customer/add', 'AddCustomer')->name('admin.customer.add');
      Route::post('admin/customer/store', 'StoreCustomer')->name('admin.customer.store');
      Route::get('admin/customer/show/editcustomer/{id}', 'EditCustomer')->name('admin.customer.show.editcustomer');
      Route::post('admin/customer/show/updatecustomer/{id}', 'UpdateCustomer')->name('admin.customer.show.updatecustomer');
      Route::get('admin/customer/show/delcustomer/{id}', 'DelCustomer')->name('admin.customer.show.delcustomer');
      // Customer Rating Controller
      Route::get('admin/customer/rating', 'AllRating')->name('admin.customer.rating');
      Route::post('admin/customer/rating/review-msg', 'ReviewMessage')->name('admin.customer.rating.review-msg');
      Route::get('admin/customer/rating/edit/{id}', 'EditRating')->name('admin.customer.rating.edit');
      Route::post('admin/customer/rating/update', 'UpdateRating')->name('admin.customer.rating.update');
      Route::get('admin/customer/rating/del/{id}', 'DelRating')->name('admin.customer.rating.del');
   });


   // Admin Dashboard Controllers
   Route::get('admin/dashboard', [AdminDashboardController::class, 'Dashboard'])->name('admin.dashboard');
   // Admin Category Controller
   Route::controller(CategoryController::class)->group(function () {
      Route::get('admin/category/addcategory' , 'AddCategory')->name('admin.category.add');
      Route::post('admin/category/addcategory' , 'StoreCategory')->name('admin.category.store');
      Route::get('admin/category/showcategory' , 'AllCategory')->name('admin.category.showcategory');
      Route::get('admin/category/view-category/{id}' , 'ViewCategory')->name('admin.category.view-category');
      Route::get('admin/category/showcategory/edit/{id}' , 'EditCategory')->name('admin.category.showcategory.edit');
      Route::post('admin/category/showcategory/updatecategory/{id}' , 'UpdateCategory')->name('admin.category.showcategory.update');
      Route::get('admin/category/showcategory/delcategory/{id}' , 'DelCategory')->name('admin.category.showcategory.delcategory');
   });
   
   // Admin Product Controller
   Route::controller(ProductController::class)->group(function () {
      Route::get('admin/product/addproduct' ,  'AddProduct')->name('admin.product.add');
      Route::post('admin/product/storeproduct' ,  'StoreProduct')->name('admin.product.storeproduct');
      Route::get('admin/product/showproduct' ,  'AllProduct')->name('admin.product.showproduct');
      Route::get('admin/product/showproduct/singleproduct/{id}' ,  'SingleProduct')->name('admin.product.showproduct.singleproduct');
      Route::get('admin/product/showproduct/editproduct/{id}' ,  'EditProduct')->name('admin.product.showproduct.editproduct');
      Route::post('admin/product/showproduct/updateproduct' ,  'UpdateProduct')->name('admin.product.showproduct.updateproduct');
      Route::get('admin/product/showproduct/delproduct/{id}' ,  'DelProduct')->name('admin.product.showproduct.delproduct');
      Route::get('admin/product/featured', 'ProductFeatured')->name('admin.product.featured');
      Route::get('admin/product/new-arrivals', 'ProductArrivals')->name('admin.product.new-arrivals');
      Route::get('admin/product/top-sellers', 'ProductTopSellers')->name('admin.product.top-sellers');
      Route::delete('admin/product/featured/del/{id}', 'DelFeatured')->name('admin.product.featured.del');
      Route::delete('admin/product/new-arrival/del/{id}', 'Delarrival')->name('admin.product.new-arrival.del');
      Route::delete('admin/product/top-seller/del/{id}', 'DelTopSeller')->name('admin.product.top-seller.del');
      // Stock Management Product Controller
      Route::get('admin/product-stock', 'index')->name('admin.product-stock');
      Route::get('admin/category-fetch/{id}', 'CategoryFetch')->name('admin.category-fetch');
      Route::get('admin/product-fetch/{id}', 'ProductFetch')->name('admin.product-fetch');
      Route::post('admin/product-qnty', 'StockQnty')->name('admin.product-qnty');
      Route::post('admin/save-qnty', 'SaveStock')->name('admin.save-qnty');
      Route::post('admin/product/stock-manage', 'ProductStockManage')->name('admin.product.stock-manage');
   });
  

   // Admin Banner Controller
   Route::controller(BannerController::class)->group(function () {
      Route::get('admin/banner/showbanners' , 'ShowBanners')->name('admin.banner.showbanners');
      Route::get('admin/banner/addbanner' , 'AddBanner')->name('admin.banner.addbanner');
      Route::post('admin/banner/storebanner' , 'StoreBanner')->name('admin.banner.storebanner');
      Route::get('admin/banner/editbanner/{id}' , 'EditBanner')->name('admin.banner.editbanner');
      Route::post('admin/banner/updatebanner' , 'UpdateBanner')->name('admin.banner.updatebanner');
      Route::get('admin/banner/deletebanner/{id}' , 'DelBanner')->name('admin.banner.deletebanner');
   });


   // FAQS Controller
   Route::controller(FAQController::class)->group(function () {
      Route::get('admin/faqs/add-faq', 'AddFaq')->name('admin.faqs.add-faq');
      Route::get('admin/faqs', 'AllFaq')->name('admin.faqs');
      Route::post('admin/faqs/view-message', 'ViewFAQ')->name('admin.faqs.view-message');
      Route::post('admin/faqs/storefaq', 'StoreFaq')->name('admin.faqs.storefaq');
      Route::get('admin/faqs/edit/{id}', 'EditFaq')->name('admin.faqs.edit');
      Route::post('admin/faqs/update', 'UpdateFaq')->name('admin.faqs.update');
      Route::get('admin/faqs/del/{id}', 'DelFaq')->name('admin.faqs.del');
   });


   // Blog Controller
   Route::controller(BlogController::class)->group(function () {
      Route::get('admin/blog', 'index')->name('admin.blog');
      Route::get('admin/blog/add-blog', 'AddBlog')->name('admin.blog.add-blog');
      Route::post('admin/blog/storeblog', 'StoreBlog')->name('admin.blog.storeblog');
      Route::get('admin/blog/view-blog/{id}', 'ViewBlog')->name('admin.blog.view-blog');
      Route::get('admin/blog/edit-blog/{id}', 'EditBlog')->name('admin.blog.edit-blog');
      Route::post('admin/blog/update-blog', 'UpdateBlog')->name('admin.blog.update-blog');
      Route::get('admin/blog/del-blog/{id}', 'DelBlog')->name('admin.blog.del-blog');
   });


   // Contact Us Controller
   Route::controller(ContactController::class)->group(function () {
      Route::get('admin/contact/showcontact', 'AllContact')->name('admin.contact.showcontact');
      Route::get('admin/contact/showcontact/editcontact/{id}', 'EditContact')->name('admin.contact.showcontact.editcontact');
      Route::post('admin/contact/showcontact/updatecontact/{id}', 'UpdateContact')->name('admin.contact.showcontact.updatecontact');
      Route::post('admin/contact/showcontact/updatecontact/{id}', 'UpdateContact')->name('admin.contact.showcontact.updatecontact');
      Route::get('admin/contact/showcontact/delcontact/{id}', 'DelContact')->name('admin.contact.showcontact.delcontact');
      Route::post('admin/contact/msgdata', 'MsgData')->name('admin.contact.msgdata');
   });

   
   // Admin Profile Controllers
   Route::controller(ProfileController::class)->group(function () {
      Route::get('admin/profile' , 'Profile')->name('admin.profile');
      Route::post('admin/update-profile' , 'UpdateProfile')->name('admin.update-profile');
   });

   // Admin Settings Controller
   Route::controller(GeneralSettingController::class)->group(function () {
      Route::get('admin/setting','index')->name('admin.setting');
      Route::post('admin/setting/save','Store')->name('admin.setting.save');
   });

   // Term Condition Controller
   Route::controller(TermCondition::class)->group(function () {
      Route::get('admin/privacy-policy', 'PrivacyPolicy')->name('admin.privacy-policy');
      Route::post('admin/privacy-policy/update-privacy-policy/{id}', 'UpdatePrivacyPolicy')->name('admin.privacy-policy.update-privacy-policy');
   });

   // Order Controller
   Route::controller(OrderController::class)->group(function () {
      Route::get('admin/order', 'AllOrders')->name('admin.order');
      Route::post('admin.vieworder','OrderDetail')->name('admin.vieworder');
      Route::post('admin/order/cancelorder','CancelOrder')->name('admin.order.cancelorder');
      Route::post('admin/order/remove-order-highlight','RemoveOrderHighlight')->name('admin.order.remove-order-highlight');
      Route::post('admin/order/paidorder','OrderPaid')->name('admin.order.paidorder');
      // Checkboxes ajax route
      Route::post('multicheckbox','DelMultiCheckbox')->name('multicheckbox');
      // Order Details
      Route::post('orderprint','OrderPrint')->name('orderprint');
      Route::post('ordersoundbeep','OrderSoundBeep')->name('ordersoundbeep');
      Route::post('ordersoundbeepoff','OrderSoundBeepOff')->name('ordersoundbeepoff');

   });


   // Coupon Controller
   Route::controller(CouponController::class)->group(function () {
      Route::get('admin/coupon/allcoupons', 'AllCoupons')->name('admin.coupon.allcoupons');
      Route::get('admin/coupon/addcoupon', 'AddCoupon')->name('admin.coupon.addcoupon');
      Route::post('admin/coupon/storecoupon', 'StoreCoupon')->name('admin.coupon.storecoupon');
      Route::get('admin/coupon/editcoupon/{id}', 'EditCoupon')->name('admin.coupon.editcoupon');
      Route::post('admin/coupon/updatecoupon', 'UpdateCoupon')->name('admin.coupon.updatecoupon');
      Route::get('admin/coupon/deletecoupon/{id}', 'DelCoupon')->name('admin.coupon.deletecoupon'); 
   });
});

Route::post('orderplace',[OrderController::class, 'index'])->name('orderplace');

// ============================End Backend Routes============================== //
