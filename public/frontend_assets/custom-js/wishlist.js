// Add to Wishlist Function

const addProductWishlist = (product_slug) => {
    
    //  return the wishlist product
    let  wishlist_product = getWishlistData(product_slug);
    // Get wishlist data in localstorage
    let localstorage_wishlist = localStorage.getItem('wishlist');

    // Stock Empty
        if(wishlist_product.product_stock != null && parseInt(wishlist_product.product_stock) == 0){

            swalMixinAlertHelper('error','Out of Stock');

        }else{

            if(localstorage_wishlist){

                // Wishlist Product Status
                var wishlist_status = false;
                var wishlist_add_status = false;
            
                    // Convert Array of object data
                     let parse_wishlist_product = JSON.parse(localstorage_wishlist);
                     // New Wishlist array
                     let  new_wishlist_arr = [];
            
                     for (let index = 0; index < parse_wishlist_product.length; index++) {
                        
                            if(parse_wishlist_product[index]['product_slug'] != product_slug){
                                // Push the new array product
                                new_wishlist_arr.push(parse_wishlist_product[index]);
            
                                 wishlist_add_status = true;
                                 
                            }else{
            
                                wishlist_status = true;
                            }
                        
                    }
            
                     if(wishlist_status == true){
            
                        swalMixinAlertHelper('error','Product Already in Wishlist');
                    }else{
                        
                        if(wishlist_add_status == true){
            
                            new_wishlist_arr.push(wishlist_product);
                            swalMixinAlertHelper('success', 'Product Added in Wishlist');
                            
                        }
            
                        let wishlist_product_array = JSON.stringify(new_wishlist_arr);
                
                        // Set wishlist product in localstorage
                            localStorage.setItem('wishlist' , wishlist_product_array); 
                
                            wishlistCounterItems();
                    }
            
                }else{
            
                    let  new_wishlist_array = [];
                
                    new_wishlist_array.push(wishlist_product);
                
                    let wishlist_product_array = JSON.stringify(new_wishlist_array);
                
                    // Set wishlist product in localstorage
                     localStorage.setItem('wishlist' , wishlist_product_array); 
                     swalMixinAlertHelper('success', 'Product Added in Wishlist');
                }
               
                // WishlistCounterItems Call Function
                wishlistCounterItems();
        }
   
}

 
// Get Wishlist Products Function

const getWishlistData = (slug) => {

    let product_c_slug = document.querySelector('input[name="'+slug+'_c_slug"]').value;
    let product_name = document.querySelector('input[name="'+slug+'_name"]').value;
    let product_price = document.querySelector('input[name="'+slug+'_price"]').value;
    let product_stock = document.querySelector('input[name="'+slug+'_s_qty"]').value;
    let product_thumbnail = document.querySelector('input[name="'+slug+'_thumbnail"]').value;
  
    product_stock = product_stock ? product_stock : null;
  
    return {

      'product_c_slug':product_c_slug,
      'product_slug':slug,
      'product_name':product_name,
      'product_price':product_price,
      'product_qty':1,
      'product_stock':product_stock,
      'product_thumbnail':product_thumbnail,

    };
}

// Remove Wishlist Product
const removeProductWishlist = (product_slug) => {

        let parse_wishlist_items = localStorage.getItem('wishlist');

        if(parse_wishlist_items){

            let new_wihslist_arr = [];

            let parse_product_arr  = JSON.parse(parse_wishlist_items);

            for (let index = 0; index < parse_product_arr.length; index++) {
                
                if(parse_product_arr[index]['product_slug'] != product_slug){

                     new_wihslist_arr.push(parse_product_arr[index]);
                     
                }
                
            }

            if(new_wihslist_arr && new_wihslist_arr.length > 0){

                let new_arr_product = JSON.stringify(new_wihslist_arr);

                localStorage.setItem('wishlist' , new_arr_product);

                loadWishlistProducts();
                wishlistCounterItems();

            }else{

                localStorage.removeItem('wishlist');
                loadWishlistProducts();
                wishlistCounterItems();
            }
  
        }
}

  // Define Function WishlistCounterItems 
  const wishlistCounterItems = () => {

    let wishlist_count_items = 0;

    let get_wishlist_product = localStorage.getItem('wishlist');

        if(get_wishlist_product){

            let parse_wishlist_product = JSON.parse(get_wishlist_product);

            for (let index = 0; index < parse_wishlist_product.length; index++) {
                
                if(parseInt(parse_wishlist_product[index]['product_qty']) > 0){

                    wishlist_count_items = parseInt(wishlist_count_items) + parseInt(parse_wishlist_product[index]['product_qty']);
                }
                
            }

            $('.wishlist_items-counter').text( wishlist_count_items);

        }else{
            $('.wishlist_items-counter').text( wishlist_count_items);

        }

  }

  // reload Call  wishlistCounterItems Function
  wishlistCounterItems();
