const checkBasketItems = () => {
    var basket_storage_status = checkLocalStorageBasketHelper();

    if (basket_storage_status == 'false') {

        document.getElementById('checkout-loader-box').style.display = 'none';
        window.location.href = website_url;

    } else if (basket_storage_status == 'true') {

        var _token = $("meta[name ='csrf-token']").attr('content');
        var localstorage_basket = localStorage.getItem('basket');
        // var localStorage_coupon = localStorage.getItem("coupon");

        $.ajax({
            url: verify_basket,
            method: "POST",
            datatype: 'json',
            data: {
                '_token': _token,
                'basket': localstorage_basket,
                // 'coupon' : localStorage_coupon
            },
            beforeSend: function() {
                // show loader //
            },
            success: function(response) {

                if (response.statuscode == 200) {
                    document.getElementById('checkout-loader-box').style.display = 'none';
                    document.getElementById('checkout-page').style.display = 'block';
                  
                } else if (response.statuscode == 400) {
                    // console.log(response.defectitem);
                    window.location.href = website_url;
                }

                console.log(response.message);
            },
            complete: function() {
                // hide loader //
            },
            error: function() {
                console.log('error in request checkBasketItems');
            }
        });
    }
}
checkBasketItems();


// Total Calculation in products
const getBasketTotalCalculations = (shipping_charges, discount_value, discount_type, get_collection_status, shipping_status) => {

    var basket_storage_status = checkLocalStorageBasketHelper();

    if (basket_storage_status == 'true') {

        var count_basket_items_price = countBasketItemsAndPriceHelper();

        var subtotal_price = count_basket_items_price.total_items_price;
        var net_total = 0;
        var discount_value_p_calc = 0;
        var net_discount_value = 0;
        var discount_status = discount_type;
        var total_after_shipping_charges = 0;

        if (discount_type == 'V' && parseFloat(discount_value) > 0) {

            // discount amount should be less than subtotal amount //
            if (parseFloat(discount_value) < parseFloat(subtotal_price)) {
                net_discount_value = parseFloat(subtotal_price) - parseFloat(discount_value);
                net_total = parseFloat(net_discount_value);
                console.log('net_total discount v', net_total);

            } else if (parseFloat(discount_value) >= parseFloat(subtotal_price)) {
                net_total = parseFloat(subtotal_price);
                discount_status = 'false';
                console.log('net_total sub_total discount v', net_total);
            }

        } else if (discount_type == 'P' && parseFloat(discount_value) > 0) {

            // discount amount should be less than 100% //
            if (parseFloat(discount_value) < 100) {
                discount_value_p_calc = parseFloat(discount_value * subtotal_price) / 100;
                net_discount_value = parseFloat(subtotal_price) - parseFloat(discount_value_p_calc);
                net_total = parseFloat(net_discount_value);
                console.log('net_total discount p', net_total);
                
            } else if (parseFloat(discount_value) >= 100) {
                net_total = parseFloat(subtotal_price);
                discount_status = 'false';
                console.log('net_total sub_total discount p', net_total);
            }

            
        } else if (discount_type == 'N' || discount_type == '') {
            net_total = parseFloat(subtotal_price);
            console.log('net_total discount n', net_total);
        }


        if (get_collection_status == 'C') {
            
            
        } else if (get_collection_status == 'D') {

            // Check flat charges status is active and inactive
            if (shipping_status == 'F' && parseFloat(shipping_charges) > 0) {
                total_after_shipping_charges = parseFloat(net_total) + parseFloat(shipping_charges);
                net_total = total_after_shipping_charges;
            }
        }


        // if Exits Coupoun Amount than add Coupon Amount

        let  get_coupon_localstorage = localStorage.getItem('coupon');
        let  parse_coupon_data =  JSON.parse(get_coupon_localstorage); 

        if(parse_coupon_data && parse_coupon_data[0].coupon_amount > 0 ){
            net_total =  parseFloat(net_total) - parseFloat(parse_coupon_data[0].coupon_amount); 
        }

        return {
            'subtotal': subtotal_price,
            'discount_type': discount_type,
            'discount_price': net_discount_value,
            'discount_value_p_calc': discount_value_p_calc,
            'discount_status': discount_status,
            'shipping_charges': shipping_charges,
            'net_total': net_total,
        }
    }


}


// Get Products in localStorage
const displayBasketProducts = () => {

    var basket_storage_status = checkLocalStorageBasketHelper();

    if (basket_storage_status == 'true') {

        let localStorage_get_item = localStorage.getItem('basket');
        let parse_products_items = JSON.parse(localStorage_get_item);
        var get_display_products_list = '';
        parse_products_items.forEach(product_list => {
            let single_product_total_price = parseFloat(product_list.product_price) * parseInt(product_list.product_qty);
            
            get_display_products_list = get_display_products_list + `<li class="tp-order-info-list-desc">
                <p>${product_list.product_name} x ${product_list.product_qty}</p>
                <span>$${parseFloat(single_product_total_price).toFixed(2)}</span>
            </li>`;
        });
        var shipping_charges = document.getElementById('shipping_charges').getAttribute('value');
        var discount_value = document.getElementById('discount_value').getAttribute('value');
        var discount_type = document.getElementById('discount_type').getAttribute('value');
        var get_collection_status = document.getElementById("select_collection").getAttribute('value');

        let total_calc = getBasketTotalCalculations(shipping_charges, discount_value, discount_type, get_collection_status);
     
        if (total_calc.discount_status == 'false') {
            $("#discount_box").text('');
        } else {
            $("#discount_price").text('$' + parseFloat(total_calc.discount_price).toFixed(2));
        }
        $('#product_render').html(get_display_products_list);
        $('#subtotal_product').text('$' + parseFloat(total_calc.subtotal).toFixed(2));
        $('#subtotal_product_price').html(`<span class="fw-bold total-price-color" id="total_calc">$${parseFloat(total_calc.net_total).toFixed(2)}</span>`);
    }
}
displayBasketProducts();


// Colllection Type Status Function
document.querySelector(".collection_status").style.display = "none";
document.querySelector(".collection_status").style.display = "none";
document.querySelector(".collection_type").classList.add("color_active");


const changeCollection = (collection) => {

    if (collection == 'D') {

        $(".err").text('');
        document.getElementById("select_collection").setAttribute('value', collection);
        var shipping_charges = $('#get_decimal_shipping_charges').val();
        var shipping_status = $('#shipping_status').val();
        if (shipping_status == 'F') {
            $(".flat_charges").html(`<li class="tp-order-info-list-shipping border-bottom">
                <span class="fw-bold">Shipping Charges</span>
                <div class="tp-order-info-list-shipping-item d-flex flex-column align-items-end">
                <label for="free_shipping" style="color:#010F1C;">$${shipping_charges}</label>
                </div>
                </li>
            `);
        }

        document.querySelector(".collection_type").classList.remove("color_active");
        document.querySelector(".delivery_type").classList.add("color_active");
        document.querySelector(".collection_status").style = "block";
        document.querySelector(".collection_status").style = "block";

    } else if (collection == 'C') {
        document.getElementById("select_collection").setAttribute('value', collection);
        document.querySelector(".delivery_type").classList.remove("color_active");
        document.querySelector(".collection_type").classList.add("color_active");
        document.querySelector(".collection_status").style.display = "none";

        $(".flat_charges").html('');
    }

    var shipping_charges = document.getElementById('shipping_charges').getAttribute('value');
    var discount_value = document.getElementById('discount_value').getAttribute('value');
    var discount_type = document.getElementById('discount_type').getAttribute('value');
    var shipping_status = document.getElementById('shipping_status').getAttribute('value');
    total_calc = getBasketTotalCalculations(shipping_charges, discount_value, discount_type, collection, shipping_status);
        
    $('.subtotal_product').text('$' + parseFloat(total_calc.subtotal).toFixed(2));
    $('#subtotal_product_price').html(`<p class="fw-bold total-price-color" id="total_calc">$${parseFloat(total_calc.net_total).toFixed(2)}</p>`);
}


// Billing Details Validation Check
const houseinfo = document.getElementById('houseinfo');
const address = document.getElementById('address');
const cityname = document.getElementById('city_name');
const citycode = document.getElementById('city_code');


// House No  or Name Validation Check //
houseinfo.addEventListener('keyup', function() {
    if (this.value == '') {
        document.getElementById('house_details_error').innerHTML = "";
    } else if (this.value.length < 1) {
        document.getElementById('house_details_error').innerHTML = "invalid filed *";
    } else {
        document.getElementById('house_details_error').innerHTML = "";
    }
});


// Street Address Validation Check //
address.addEventListener('keyup', function() {
    if (this.value == '') {
        document.getElementById('address_error').innerHTML = "";
    } else if (this.value.length < 1) {
        document.getElementById('address_error').innerHTML = "invalid field *";
    } else {
        document.getElementById('address_error').innerHTML = "";
    }
});


// City Name  Validation Check //
cityname.addEventListener('keyup', function() {
    if (this.value == '') {
        document.getElementById('cityname_error').innerHTML = "";
    } else if (this.value.length < 4) {
        document.getElementById('cityname_error').innerHTML = "invalid field";
    } else {
        document.getElementById('cityname_error').innerHTML = "";
    }
});


// PostCode Validation Check //
citycode.addEventListener('keyup', function() {
    const nonSpaceValue = this.value.replace(/\s/g, '');
    if (this.value == '') {
        document.getElementById('citycode_error').innerHTML = "";
    } else if (nonSpaceValue.length < 5) {
        document.getElementById('citycode_error').innerHTML = "invlid postcode";
    } else {
        document.getElementById('citycode_error').innerHTML = "";
    }
});


// Type Coupun 
const typeCoupon= ()=>{
    let  coupon_arr = [];
    var coupon_code = document.getElementById("get_coupon_code").value;
    if(coupon_code == ''){
        localStorage.removeItem('coupon');
    }else{
      
        let coupon_obj = {
            'coupon_code' : coupon_code,
            // 'coupon_amount' : coupon_amount
         };
    
         coupon_arr.push(coupon_obj);
         // store coupon data in local storage
        let parse_coupon_arr = JSON.stringify(coupon_arr);
         localStorage.setItem('coupon',parse_coupon_arr);
    }
  
   
}
// Coupon Code Function

const applyCoupon = async () => {
   
    var coupon_code = document.getElementById("get_coupon_code").value;
       
        await $.ajax({
            url : coupon_url,
            method : 'POST',
            datatype  :' json',
            data : {'coupon_code' : coupon_code , '_token' : _token},
            success : function (response){
                if(response.statuscode == 204){
                    localStorage.removeItem('coupon');                    
                    swalMixinAlertHelper('error',response.message);
                }else if(response.statuscode == 422){
                    swalMixinAlertHelper('error',response.message);
                }else{
                    if(response.statuscode == 200){
                        let retrive_data = setCouponLocalStorage(response.coupon_code,response.coupon_amount,response.message);
                        if(retrive_data.statuscode == 200){
                            getLocalStorageCoupon();
                            window.location.href = basket_checkout_url;
                        } 
                    }
                }
            },
            error : function (err){
                console.log(err);
            },
        })
}

// Set Coupon Code in local storage
const setCouponLocalStorage = (coupon_code,coupon_amount,message) =>{

    let  response = [];
 
   var get_coupon = localStorage.getItem('coupon');
    if(get_coupon){
        var parse_coupon = JSON.parse(get_coupon);
        // console.log(JSON.parse(get_coupon));
        if(parse_coupon[0].coupon_code == coupon_code){
            const updatedArray = parse_coupon .map(obj => {
                if (obj.coupon_code === coupon_code) {
                  // Merge new key-value pairs into the existing object
                  return { ...obj, "coupon_amount": coupon_amount };
                }
                return obj; // Return the object unchanged if it doesn't match
              });
                let new_coupon_arr =  JSON.stringify(updatedArray);
                localStorage.setItem('coupon',new_coupon_arr);
                response['statuscode'] = 200;
                swalMixinAlertHelper('success',message);
                return response;
        }else{
            response['statuscode'] = 204;
            return response;
        }
    }else{
        response['statuscode'] = 204;
    }

}

const getLocalStorageCoupon = () =>{

    let  get_coupon_localstorage = localStorage.getItem('coupon');
    let  parse_coupon_data =  JSON.parse(get_coupon_localstorage);
    if(parse_coupon_data && parse_coupon_data[0].coupon_amount > 0 ){
        document.getElementById("get_coupon_code").setAttribute('value',parse_coupon_data[0].coupon_code);
         // Add Coupon Discount show Front end
        $(".coupon_discount").html(`<li class="tp-order-info-list-shipping border-bottom">
        <span class="fw-bold">Coupon Discount</span>
        <div class="tp-order-info-list-shipping-item d-flex flex-column align-items-end">
        <label for="free_shipping" style="color:#010F1C;">$${parse_coupon_data[0].coupon_amount}</label>
        </div>
        </li>
        `);
    }else{
        document.getElementById("get_coupon_code").setAttribute('value','');
    }
   
    

}
getLocalStorageCoupon();


