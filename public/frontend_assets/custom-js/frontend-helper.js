
// trim string into given length //
const trimStringHelper = (pass_string, string_length) => {
  return pass_string.length > string_length ? pass_string.substring(0, string_length) + "..." : pass_string;
}


// sweet alert //
const swalMixinAlertHelper = (icon, msg) => {
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
    icon: icon,
    title: msg,
    showCloseButton: true
  });
}

// check localStorage basket exist //
const checkLocalStorageBasketHelper = () => {
  var localstorage_basket = localStorage.getItem('basket');
  if (localstorage_basket) {

    var parse_products_array = JSON.parse(localstorage_basket);
    if (parse_products_array && parse_products_array.length > 0) {
      return 'true';

    } else {
      return 'false';
    }
  } else {
    return 'false';
  }
}


// count quantity and price of basket items //
const countBasketItemsAndPriceHelper = () => {

  var total_items_qty = 0;
  var total_items_price = 0;
  var localstorage_basket = localStorage.getItem('basket');

  if (localstorage_basket) {
    var parse_products_array = JSON.parse(localstorage_basket);

    for (let index = 0; index < parse_products_array.length; index++) {

      if (parseInt(parse_products_array[index]['product_qty']) > 0) {

        total_items_qty = parseInt(total_items_qty) + parseInt(parse_products_array[index]['product_qty']);
        total_items_price = parseFloat(total_items_price) + (parseFloat(parse_products_array[index]['product_qty']) * parseFloat(parse_products_array[index]['product_price']));
      }
    }
  }

  return {'total_items_qty':total_items_qty, 'total_items_price':total_items_price};
}

