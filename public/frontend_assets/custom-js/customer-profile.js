// Update Customer Password
$("#update_pass").click(function (e) {
    const token = $("meta[name='csrf-token']").attr("content");
    e.preventDefault();

   var  old_pass = $("#old_pass").val();
   var  new_pass = $("#new_pass").val();
   var  con_new_pass = $("#con_new_pass").val();


       $.ajax({
          url :  update_password_url,
          method : 'POST',
          dataType : 'json',
          data : {'old_pass' : old_pass, 'new_pass' : new_pass , 'con_new_pass' : con_new_pass, '_token' : token},
          success :function (response){

                if(response.statuscode == 400){
                    $('.error').text('');
                   $.each(response.error,function (key ,value) {
                      $("#"+ key + "_err").text(value);
                   })
                }else{
                      if(response.statuscode == 200){
                         setTimeout(swalMixinAlertHelper('success' , response.msg), 2000);
                         window.location.href = logout_url;
                      }
                }
          },
          error :function (err){
             console.log(err);
          },
       })
 })

    // Customer Cart View
    // $(document).on('click', '.customer_order_cartview', function() {

    //     $("#staticBackdrop").modal("show");
  
    //     var order_id = $(this).attr('value');
      
    //     const token = $("meta[name='csrf-token']").attr("content");
  
      
    //     $.ajax({
    //         //   url: customer_order_detail,
    //           method: 'POST',
    //           dataType: 'json',
    //           data: {
    //               'order_id': order_id,
    //               '_token': token
    //           },
    //           success: function(response) {
  
    //              console.log(response);
    //           },
    //           error: function(err) {
  
    //               console.log(err);
    //           }
    //     });
  
    //  });
  
    // Customer Order Details
    $(document).on('click', '#customer_order_view', function() {

      $("#staticBackdrop").modal("show");

      var order_id = $(this).attr('value');
    
      const token = $("meta[name='csrf-token']").attr("content");

    
      $.ajax({
            url: customer_order_detail,
            method: 'POST',
            dataType: 'json',
            data: {
                'order_id': order_id,
                '_token': token
            },
            success: function(response) {

                if (response.statuscode == 200) {
                    $('.order_reciept').html(response.data);
                    $('.order_details').html(response.order_addtional_details);
                    $('.order_calc').html(response.order_product_calc);
                } else {
                    console.log("server not  response", 500);
                }
            },
            error: function(err) {

                console.log(err);
            }
      });

   });



