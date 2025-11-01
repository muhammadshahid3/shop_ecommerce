
 //Product Rating Function

  function ProductRating(){
    
    const Toast = Swal.mixin({
       toast: true,
       position: "top-end",
       showConfirmButton: false,
       timer: 2000,
       timerProgressBar: true,
       didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
       }
    });
    Toast.fire({
       icon: "warning",
       title: "please login to send reviews",
       showCloseButton: true
    });
}

// Review Form Submit
$(document).ready(function() {
 $('#review_submit').submit(function (event) {
    event.preventDefault();
    var product_review_data = $("#review_submit").serialize();
    $.ajax({
        url: product_submit_rating_route,
        method: 'post',
       data: product_review_data,
       success: function(response){
          if(response.error){
             $(".error").text('');
            //Show Errors 
             $.each(response.error,function (key,value) {
                   $('.' + key + '_err').text(value);
             })
    
          }else{
            if(response.statuscode == 204){
              $(".error").text('');
              $('#review_submit').trigger("reset");
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.onmouseenter = Swal.stopTimer;
                  toast.onmouseleave = Swal.resumeTimer;
                }
              });
                Toast.fire({
                  icon: response.icon,
                  title: response.message, 
                  showCloseButton: true
                });
            }else if(response.statuscode == 200){
              $(".error").text('');
              $('#review_submit').trigger("reset");
              avgRatingProduct();
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.onmouseenter = Swal.stopTimer;
                  toast.onmouseleave = Swal.resumeTimer;
                }
              });
                Toast.fire({
                  icon: response.icon,
                  title: response.message, 
                  showCloseButton: true
                });
            }else{
               console.log("Server Error" ,500);
            }

            

          }
       },
       error: function(err){
          console.log(err);
       }
     });
  });

});

const avg_RatingStarCount =( avg_rating) => {
  let fill_count_stars = '';
  var unfill_count_stars = '';
    for (let index = 0; index < avg_rating; index++) {
      fill_count_stars = fill_count_stars + `<span><i class="fa-solid fa-star"></i></span>`;
    }
    if(parseInt(avg_rating) === 1){
      unfill_count_stars = unfill_count_stars +`<span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>`;
    }else if(parseInt(avg_rating) === 2){
      unfill_count_stars = unfill_count_stars +`<span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>`;
    }else if(parseInt(avg_rating) === 3 ){
      unfill_count_stars = unfill_count_stars +`<span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>`;
    }else if(parseInt(avg_rating) === 4 ){
      unfill_count_stars = unfill_count_stars +`<span><i class="fa-light fa-star"></i></span>`;
    }else if(parseInt(avg_rating) === 5){
      unfill_count_stars = unfill_count_stars +``;
    }else{
      unfill_count_stars = unfill_count_stars +`<span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>
      <span><i class="fa-light fa-star"></i></span>`;
    }
    return fill_count_stars + unfill_count_stars;
}

// Avg Rating Product function
const avgRatingProduct = () => {
  var latest_rating = '';
  var token = $("meta[name = 'csrf-token']").attr('content');
  $.ajax({
    url: product_avg_rating,
    method: 'POST',
    data: {'_token' : token},
    success : function (response){

      if(response.statuscode == 200){
        // console.log(response);
      let  avg_rating = Math.round(response.avg_rating);
        $("#product_avg_rating").text( avg_rating +'/'+'5.0');
        // Avg Rating Star Count Function 
         count_rating_stars = avg_RatingStarCount(avg_rating);
         $("#stars_count").html(count_rating_stars);
        $("#rating-reviews").text('(' + response.reviews_count + ' ' + 'Reviews' + ')');
        $(".total_review_count").text('Reviews (' +  response.reviews_count + ')' );
        // $("#product_detail_rating_reviews").text('(' + response.reviews_count + ' ' + 'Reviews' + ')');
        $("#one_star_rating").css({'width' : parseFloat(response.rating_one_star) +   "%" , 'background' : '#ffc107'});
        $("#two_star_rating").css({'width' : parseFloat(response.rating_two_star) +   "%" , 'background' : '#ffc107'});
        $("#three_star_rating").css({'width' : parseFloat(response.rating_three_star)+"%" , 'background' : '#ffc107'});
        $("#four_star_rating").css({'width' : parseFloat(response.rating_four_star) + "%" , 'background' : '#ffc107'});
        $("#five_star_rating").css({'width' : parseFloat(response.rating_five_star) + "%" , 'background' : '#ffc107'});
        // Every Star Percentage show
        $("#star1_percentage").text(parseFloat(Math.round(response.rating_one_star)) +"%");
        $("#star2_percentage").text(parseFloat(Math.round(response.rating_two_star)) +"%");
        $("#star3_percentage").text(parseFloat(Math.round(response.rating_three_star)) +"%");
        $("#star4_percentage").text(parseFloat(Math.round(response.rating_four_star)) +"%");
        $("#star5_percentage").text(parseFloat(Math.round(response.rating_five_star)) +"%");
        // Latest Review Show
        response.latest_reviews.forEach(reviews => {
          let customer_star_count = '';
          let unfill_customer_star_count = '';
          // Count Customer Stars
            if(reviews.stars == 1){
              customer_star_count =  customer_star_count + `<span><i class="fa-solid fa-star"></i></span>`;
              unfill_customer_star_count = unfill_customer_star_count +` <span><i class="fa-light fa-star"></i></span>
            <span><i class="fa-light fa-star"></i></span>
            <span><i class="fa-light fa-star"></i></span>
            <span><i class="fa-light fa-star"></i></span>`;
            }else if(reviews.stars == 2){
              customer_star_count =  customer_star_count + `<span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>`;
              unfill_customer_star_count = unfill_customer_star_count +` <span><i class="fa-light fa-star"></i></span>
              <span><i class="fa-light fa-star"></i></span>
              <span><i class="fa-light fa-star"></i></span>`;
            }else if(reviews.stars == 3){
              customer_star_count =  customer_star_count + `<span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>`;
              unfill_customer_star_count = unfill_customer_star_count +` <span><i class="fa-light fa-star"></i></span>
              <span><i class="fa-light fa-star"></i></span>`;
            }else if(reviews.stars == 4){
              customer_star_count =  customer_star_count + `<span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>`;
              unfill_customer_star_count = unfill_customer_star_count +` <span><i class="fa-light fa-star"></i></span>`;
            }else if(reviews.stars == 5){
              customer_star_count =  customer_star_count + `<span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>
              <span><i class="fa-solid fa-star"></i></span>`;
              unfill_customer_star_count = unfill_customer_star_count +``;
            }else{
              unfill_customer_star_count = unfill_customer_star_count + ` <span><i class="fa-light fa-star"></i></span>
            <span><i class="fa-light fa-star"></i></span>
            <span><i class="fa-light fa-star"></i></span>
            <span><i class="fa-light fa-star"></i></span>
            <span><i class="fa-light fa-star"></i></span>`;
            }

          let first_rating_letter = reviews.username.slice(0,1);
          let upper_case_letter  = first_rating_letter.toUpperCase();
          latest_rating = latest_rating + `<div class="tp-product-details-review-avater d-flex align-items-start">
            <div class="tp-product-details-review-avater-thumb">
                <span class="bg-primary me-3 text-white" style="width: 30px; height:30px; border-radius:50px; text-align: center;display: inline-block;">${upper_case_letter}</span>
            </div>
            <div class="tp-product-details-review-avater-content">
                <div class="tp-product-details-review-avater-rating d-flex align-items-center">
                    ${customer_star_count + unfill_customer_star_count}
                </div>
                <h3 class="tp-product-details-review-avater-title">${reviews.username}</h3>
                <div class="tp-product-details-review-avater-comment">
                  <p>${reviews.review_message}</p>
                </div>
                </div>
            </div>`;
        });
        // Check Conditon data exits or not
        if(latest_rating == null && latest_rating == ''){
          $("#latest_rating").html('');
        }else{
          $("#latest_rating").html(latest_rating);

        }
      }
    },
    error : function(err){
      console.log(err);
    }
  });
}
avgRatingProduct();


// Set Product Qty Function
  const setProductQty = () => {

   let get_product_qty = 1;
      // Input box qty
      document.getElementById("input_qty").setAttribute('value',parseInt(get_product_qty));
      // hidden field input qty 
      document.getElementById('old_product_qty').setAttribute('value', parseInt(get_product_qty)); 

  }

// Set Product Qty Function Call
  setProductQty();




//  Product Increase Qty Function 
const increaseQty = () => {

 let product_qty = 1;

 let  product_qty_value =  document.getElementById("input_qty").value;
 

 // console.log(product_qty_value);
 
 product_stock_value  = $('#product_stock_value').val();

   if( parseInt( product_qty_value) <  parseInt(product_stock_value)){
      
      let product_increase_qty =  parseInt(product_qty) + parseInt(product_qty_value);
      // console.log(product_increase_qty);
      //Increase qty
      document.getElementById("input_qty").setAttribute('value',parseInt(product_increase_qty)); 
      //Increase hidden field qty
      document.getElementById('old_product_qty').setAttribute('value', parseInt(product_increase_qty));

   }else{

    swalMixinAlertHelper('error', 'Out of Stock');

   }
}

// Product Decrease Qty
const decreaseQty = () => {

 var  product_qty_value =  document.getElementById("input_qty").value;

 // console.log(product_qty_value);

   product_stock_value  = $('#product_stock_value').val();

   if( parseInt(product_qty_value) <= 1 ){
    
    swalMixinAlertHelper('error', 'Min one required');

   }else{
                
    //Decrease hidden field qty
      document.getElementById("input_qty").setAttribute('value', parseInt( product_qty_value) - 1); 
    //Decrease hidden field qty
     document.getElementById('old_product_qty').setAttribute('value', parseInt(product_qty_value) - 1);

   }
}

// Add to Cart function


const addProductBasketUz = (product_slug) => {

   var product_object = getProductDetailUz(product_slug);
      // console.log(product_object);
   var localstorage_basket = localStorage.getItem('basket');
   
   // if item stock is 0 //
   if (product_object.product_stock != null &&  parseInt(product_object.product_stock) == 0) {
    swalMixinAlertHelper('error', 'Out of Stock Product');
   
     // item stock is greater than 0 //
   } else {
   
     // if basket is not empty //
     if (localstorage_basket) {
   
       var parse_products_array = JSON.parse(localstorage_basket);
       var compare_product_status = false;
       var compare_product_stock_alert = false;
   
       // if product pre-exists in basket //
       for (let index = 0; index < parse_products_array.length; index++) {
         
         if (parse_products_array[index]['product_slug'] == product_slug) {

            // Calculate Product Qty
            var calculate_qty = parseInt(parse_products_array[index]['product_qty']) + parseInt(product_object.product_qty);

           // product stock not exists //
           if (parse_products_array[index]['product_stock'] == null) {

             compare_product_status = true;

             parse_products_array[index]['product_qty'] = parseInt(parse_products_array[index]['product_qty']) + 1;
   
             // product stock exists //
           } else if (parse_products_array[index]['product_stock'] != null) {
   
             // to increase product quantity, quantity should be less than product stock //
             if (parseInt(parse_products_array[index]['product_qty']) < parseInt(parse_products_array[index]['product_stock']) &&  parseInt( calculate_qty) <= parseInt(parse_products_array[index]['product_stock'])  ) {

               compare_product_status = true;

               parse_products_array[index]['product_qty'] = parseInt(parse_products_array[index]['product_qty']) + parseInt(product_object.product_qty);
   
               // product quantity is less than or equal to product stock //
             } else {
               compare_product_stock_alert = true;
             }
           }
         }
       }
   
       if (compare_product_stock_alert == true) {
         
        swalMixinAlertHelper('error', 'Out of Stock Product');
   
       } else {
         // if product not pre-exists in basket //
         if (compare_product_status == false) {

           parse_products_array.push(product_object);

         }
     
         let parse_products_array_string = JSON.stringify(parse_products_array);

         localStorage.setItem('basket', parse_products_array_string);
   
         swalMixinAlertHelper('success', 'Product Added in Basket');

               // Input box qty
         document.getElementById("input_qty").setAttribute('value',1);

       }
   
   
       // if basket if empty //
     } else {
       
       let new_products_array = [];
       new_products_array.push(product_object);
   
       let new_products_array_string = JSON.stringify(new_products_array);
       localStorage.setItem('basket', new_products_array_string);
   
       swalMixinAlertHelper('success', 'Product Added in Basket');
     }
   
     countBasketItems();
   }
   }




// Get product details function
const getProductDetailUz = (slug) => {

   let product_c_slug = document.querySelector('input[name="'+slug+'_c_slug"]').value;
   let product_name = document.querySelector('input[name="'+slug+'_name"]').value;
   let product_price = document.querySelector('input[name="'+slug+'_price"]').value;
   let product_stock = document.querySelector('input[name="'+slug+'_s_qty"]').value;
   let product_qty = document.querySelector('input[name="'+slug+'_pro_qty"]').value;
   let product_thumbnail = document.querySelector('input[name="'+slug+'_thumbnail"]').value;
   let qty  = 1;
       console.log(product_qty);
   product_stock = product_stock ? product_stock : null;

   product_qty = product_qty ? product_qty : qty;

 
   return {

     'product_c_slug':product_c_slug,
     'product_slug':slug,
     'product_name':product_name,
     'product_price':product_price,
     'product_qty': product_qty,
     'product_stock':product_stock,
     'product_thumbnail':product_thumbnail,

   };

 }