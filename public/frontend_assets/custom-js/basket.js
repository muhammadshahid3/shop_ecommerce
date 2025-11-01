

const addProductBasket = (product_slug) => {

  var return_status = '';
  var product_object = getProductDetail(product_slug);
  var localstorage_basket = localStorage.getItem('basket');
  // console.log(product_object);
  // if item stock is 0 //
  if (product_object.product_stock != null && product_object.product_stock_status === 'I' && parseInt(product_object.product_stock) == 0) {
    swalMixinAlertHelper('error', 'Out of Stock Product');

    return_status = 'false';

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
  
          // product stock not exists //
          if (parse_products_array[index]['product_stock'] == null) {
            compare_product_status = true;
            parse_products_array[index]['product_qty'] = parseInt(parse_products_array[index]['product_qty']) + 1;
  
            // product stock exists //
          } else if (parse_products_array[index]['product_stock'] != null) {
  
            // to increase product quantity, quantity should be less than product stock //
            if (parseInt(parse_products_array[index]['product_qty']) < parseInt(parse_products_array[index]['product_stock'])) {
              compare_product_status = true;
              parse_products_array[index]['product_qty'] = parseInt(parse_products_array[index]['product_qty']) + 1;
  
              // product quantity is less than or equal to product stock //
            } else {
              compare_product_stock_alert = true;
            }
          }
        }
      }
  
      if (compare_product_stock_alert == true) {
        
        swalMixinAlertHelper('error', 'Out of Stock Product');
        return_status = 'false';
  
      } else {
        // if product not pre-exists in basket //
        if (compare_product_status == false) {
          parse_products_array.push(product_object);
        }
    
        let parse_products_array_string = JSON.stringify(parse_products_array);
        localStorage.setItem('basket', parse_products_array_string);
  
        swalMixinAlertHelper('success', 'Product Added in Basket');
        return_status = 'true';
      }
  
  
      // if basket if empty //
    } else {
      
      let new_products_array = [];
      new_products_array.push(product_object);
  
      let new_products_array_string = JSON.stringify(new_products_array);
      localStorage.setItem('basket', new_products_array_string);

      swalMixinAlertHelper('success', 'Product Added in Basket');
      return_status = 'true';
    }
  
    countBasketItems();
  }

  return return_status;
}


const removeProductBasket = (product_slug) => {
  var localstorage_basket = localStorage.getItem('basket');
  var parse_products_array = JSON.parse(localstorage_basket);
  
  var updated_products_array = [];

  for (let index = 0; index < parse_products_array.length; index++) {
    if (parse_products_array[index]['product_slug'] != product_slug) {
      updated_products_array.push(parse_products_array[index]);
    }
  }

  if (updated_products_array && updated_products_array.length > 0) {
    let updated_products_array_string = JSON.stringify(updated_products_array);
    localStorage.setItem('basket', updated_products_array_string);

  } else {
    localStorage.removeItem('basket');
  }
  
  // reload basket //
  loadBasketProducts();
  // count basket items //
  // countBasketItems();

  swalMixinAlertHelper('success', 'Product has Removed');
}


const increaseProductQty = (product_slug) => {
  var localstorage_basket = localStorage.getItem('basket');
  var parse_products_array = JSON.parse(localstorage_basket);

  var compare_product_stock_alert = false;

  for (let index = 0; index < parse_products_array.length; index++) {
    if (parse_products_array[index]['product_slug'] == product_slug) {

      // product stock not exists //
      if (parse_products_array[index]['product_stock'] == null) {
        parse_products_array[index]['product_qty'] = parseInt(parse_products_array[index]['product_qty']) + 1;

        // product stock exists //
      } else if (parse_products_array[index]['product_stock'] != null) {

        // to increase product quantity, quantity should be less than product stock //
        if (parseInt(parse_products_array[index]['product_qty']) < parseInt(parse_products_array[index]['product_stock'])) {
          parse_products_array[index]['product_qty'] = parseInt(parse_products_array[index]['product_qty']) + 1;

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
    let parse_products_array_string = JSON.stringify(parse_products_array);
    localStorage.setItem('basket', parse_products_array_string);

    swalMixinAlertHelper('success', 'Product Quantity Increased');
    loadBasketProducts();
    // countBasketItems();
  }
}


const decreaseProductQty = (product_slug) => {
  var localstorage_basket = localStorage.getItem('basket');
  var parse_products_array = JSON.parse(localstorage_basket);

  var remove_product_qty_1 = false;

  for (let index = 0; index < parse_products_array.length; index++) {
    if (parse_products_array[index]['product_slug'] == product_slug) {

      // if product quantity is 1 //
      if (parseInt(parse_products_array[index]['product_qty']) <= 1) {
        remove_product_qty_1 = true;

        // product quantity is greater than 1 //
      } else {
        parse_products_array[index]['product_qty'] = parseInt(parse_products_array[index]['product_qty']) - 1;
      }
    }
  }

  if (remove_product_qty_1 == true) {
    removeProductBasket(product_slug);

  } else {
    let parse_products_array_string = JSON.stringify(parse_products_array);
    localStorage.setItem('basket', parse_products_array_string);

    swalMixinAlertHelper('success', 'Product Quantity Decreased');
    loadBasketProducts();
    // countBasketItems();
  }
}


// get selected product detail //
const getProductDetail = (slug) => {

  // let _id = new Date().getTime();
  let product_c_slug = document.querySelector('input[name="'+slug+'_c_slug"]').value;
  let product_name = document.querySelector('input[name="'+slug+'_name"]').value;
  let product_price = document.querySelector('input[name="'+slug+'_price"]').value;
  let product_stock = document.querySelector('input[name="'+slug+'_s_qty"]').value;
  let product_stock_status = document.querySelector('input[name="'+slug+'_pro_stock_status"]').value;
  let product_thumbnail = document.querySelector('input[name="'+slug+'_thumbnail"]').value;
  product_stock = product_stock ? product_stock : null;
  stock_status  = product_stock_status  ? product_stock_status  : 'I';

  return {
    // 'id':_id,
    'product_c_slug':product_c_slug,
    'product_slug':slug,
    'product_name':product_name,
    'product_price':product_price,
    'product_qty':1,
    'product_stock':product_stock,
    'product_stock_status' : stock_status,
    'product_thumbnail':product_thumbnail,
  };
}


// count quantity of basket items //
const countBasketItems = () => {
  var basket_items = countBasketItemsAndPriceHelper();
  $('.basket-items-counter').text(basket_items.total_items_qty);
}
countBasketItems();


const clearLocalStorageBasket = () => {
  let localstorage_basket = localStorage.getItem('basket');

  if (localstorage_basket) {
    localStorage.removeItem('basket');

    swalMixinAlertHelper('success', 'Basket has Cleard');
    // reload basket //
    loadBasketProducts();
    // count basket items //
    // countBasketItems();
  }
}


