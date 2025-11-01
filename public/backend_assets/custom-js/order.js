var intervalId = false;


var table = $('.data-table').DataTable({

    responsive: true,
    serverSide: true,
    processing: false,
    "pageLength": 2,
    lengthMenu: [2, 10, 50, 100, 500],
    ajax: route,

    columns: [{
            data: 'checkbox',
            name: 'checkbox',
            orderable: false,
            searchable: false
        },
        // { data: 'checkbox',         name: 'checkbox' },
        {
            data: 'order_number',
            name: 'order_number'
        },
        {
            data: 'customer_name',
            name: 'customer_name'
        },
        {
            data: 'customer_address',
            name: 'customer_address'
        },
        {
            data: 'order_delivery_time',
            name: 'order_delivery_time'
        },
        {
            data: 'payment_method',
            name: 'payment_method'
        },
        {
            data: 'order_net_total',
            name: 'order_net_total'
        },
        {
            data: 'order_status',
            name: 'order_status'
        },
        {
            data: 'order_cancel',
            name: 'order_cancel'
        },
        {
            data: 'order_date',
            name: 'order_date'
        },
        {
            data: 'action',
            name: 'action'
        },
    ],

    // Initialize tooltips on draw
    drawCallback: function() {
        // Enable tooltips after table has rendered
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

    }

});

function refreshDataTableJS() {
   
    $('.data-table').DataTable().ajax.reload(null, false);
    beepSound(); // Beep Sound Function
   var order_sound_status  =  document.getElementById('beep_status_count').value;
    if(order_sound_status == 0){
        document.getElementById('volume-mute').className = "fa fa-volume-mute btn btn-primary p-2";
        document.getElementById('volume-mute').removeAttribute("onclick");

    }else{
        document.getElementById('volume-mute').className = "fa fa-volume-up btn btn-primary p-2";
        document.getElementById('volume-mute').setAttribute("onclick",'soundOff()');
    }

    
}


async function loadFuntions() {
    if (intervalId === false) {
        // console.log(intervalId);
        await refreshDataTableJS();
    }
}
setInterval(loadFuntions, 5000);

//  Beep Sound Function
const beepSound = () => {

    const token = $("meta[name='csrf-token']").attr("content");
    beep_status = false;
    let generalsetting_beep_status = document.getElementById("beep_status").value;
    if (generalsetting_beep_status == 'A') {
        $.ajax({
            url: ordersoundbeep,
            method: 'POST',
            dataType: 'json',
            data: {
                '_token': token
            },
            success: function(response) {
                
                if (response.statuscode == 200) {
                    document.getElementById('beep_status_count').setAttribute('value',response.order_sound_status_count);
                    sound_beep_on = document.getElementById('beep');
                    sound_beep_on.play();
                } else {
                    document.getElementById('beep_status_count').setAttribute('value',response.order_sound_status_count);
                    document.getElementById('beep').pause();
                }
            },
            error: function(err) {
                console.log(err);
            },
        });
    }

}

beepSound();

// Close Order Sound 
const soundOff = () => {
  
    const token = $("meta[name='csrf-token']").attr("content");
    beep_status = false;
    let generalsetting_beep_status = document.getElementById("beep_status").value;
    if (generalsetting_beep_status == 'A') {
        $.ajax({
            url: order_soundbeep_off,
            method: 'POST',
            dataType: 'json',
            data: {
                '_token': token
            },
            success: function(response) {
                if (response.statuscode == 200) {
                    if(response.order_sound_status_count == 0){
                        document.getElementById('volume-mute').className = "fa fa-volume-mute btn btn-primary p-2";
                        document.getElementById('volume-mute').removeAttribute("onclick");
                    }else{
                        document.getElementById('volume-mute').className = "fa fa-volume-mute btn btn-primary p-2";
                        document.getElementById('volume-mute').removeAttribute("onclick");  
                    }
                } else {
                    console.log("Server Error",500);
                }
            },
            error: function(err) {
                console.log(err);
            },
        });
    }
}




$(document).ready(function() {

    // Order Details
    $(document).on('click', '.viewdata', function() {
        intervalId = true;
        var order_id = $(this).attr('value');
        const token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: view_order,
            method: 'POST',
            dataType: 'json',
            data: {
                'order_id': order_id,
                '_token': token
            },
            success: function(response) {
                if (response.statuscode == 422) {
                    console.log('Invalid data', 422);
                } else {
                    if (response.statuscode == 200) {
                        var retrieve_data =
                            '<div class="row "> ' + response.order_addtional_details +
                            `<div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Thumbnail</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Products</th>
                                            <th scope="col">Price</th>
                                            </tr>
                                    </thead>
                                            <tbody class="order_reciept">
                                                ${response.order_products}
                                            </tbody>
                                </table>
                        </div>` +
                            `<div class="row justify-content-end">
                                ${response.order_product_calc}
                            </div>` +
                            '</div>';

                        $(".modal-body").html(retrieve_data);

                    }
                }

            },
            error: function(err) {
                console.log(err);
            },

        });


    });

    // Order Details Hide
    $("#close_modal").click(function() {
        intervalId = false;
    })

    //  Order Cancel 
    $(document).on('click', '.order_cancel', function() {
        intervalId = true;
        var cancel_order_id = $(this).attr('value');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to cancel order!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ok"
        }).then((result) => {
            if (result.isConfirmed) {

                const token = $("meta[name='csrf-token']").attr("content");
                var table = $('#tblEmployee').DataTable();

                $.ajax({
                    url: cancel_order,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'cancel_order_id': cancel_order_id,
                        '_token': token
                    },
                    success: function(response) {

                        if (response.statuscode == 200) {
                            $('.data-table').DataTable().ajax.reload(null, false);
                            intervalId = false;

                            // <!-- Session Msg End-->
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: response.message,
                            });

                            // <!-- Session Msg -->
                        } else {
                            console.log("data failed", 500);
                        }
                    },
                    error: function(err) {

                        console.log(err);
                    }

                });

                Swal.fire({
                    title: "Deleted!",
                    text: "Your Order has been Cancelled ",
                    icon: "success"
                });
            }
        });

    });

    // Print Order
    $(document).on('click', '.print_order', async function() {
        intervalId = true;
        const token = $("meta[name='csrf-token']").attr("content");
        var order_id = $(this).attr('value');
        console.log(order_id);
        await $.ajax({
            url: order_print,
            method: 'POST',
            dataType: 'json',
            data: {
                'order_id': order_id,
                '_token': token
            },
            success: function(response) {
                if (response.statuscode == 422) {
                    console.log('Invalid data', 422);
                } else {
                    if (response.statuscode == 200) {
                        var retrieve_data =
                            '<div class="row "> ' + response.order_addtional_details +
                            `<div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Thumbnail</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Products</th>
                                            <th scope="col">Price</th>
                                            </tr>
                                    </thead>
                                            <tbody class="order_reciept">
                                                ${response.order_products}
                                            </tbody>
                                </table>
                        </div>` +
                            `<div class="row justify-content-end">
                                ${response.order_product_calc}
                            </div>` +
                            '</div>';

                        var iframe = document.createElement('iframe');
                        iframe.src = retrieve_data;
                        var val = iframe.getAttribute('src');
                        for (let i = 0; i < response.product_total_qty; i++) {
                            $(val).print();
                        }
                        intervalId = false;

                        //  Check Order Highlight 
                        if (response.order_highlight == 'A') {

                            $.ajax({
                                url: order_remove_highlight,
                                method: 'POST',
                                dataType: 'json',
                                data: {
                                    '_token': token,
                                    'order_slug': response.order_slug
                                },
                                success: function(response) {
                                    if (response.statuscode == 200) {

                                        $('.data-table').DataTable().ajax.reload(null, false);
                                        document.getElementById('beep').pause();
                                        beepSound();


                                    } else {
                                        document.getElementById('beep').pause();
                                    }
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            })
                        }

                    }
                }

            },
            error: function(err) {
                console.log(err);
            },
        });
    });

    //  Order Paid

    $(document).on('click', '.order_paid', function() {
        intervalId = true;
        const token = $("meta[name='csrf-token']").attr("content");
        order_paid_id = $(this).attr('value');
        if (order_paid_id) {
            Swal.fire({
                title: "Order Paid?",
                text: "Are you sure you want to this order paid!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: paid_order,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            'order_paid_id': order_paid_id,
                            '_token': token
                        },
                        success: function(response) {
                            if (response.statuscode == 200) {
                                $('.data-table').DataTable().ajax.reload(null, false);
                                intervalId = false;
                                // <!-- Session Msg End-->
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: response.message,
                                });

                            } else {
                                console.log('Server Error', 500);
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });

                }
            });

        } else {
            console.log('Server Error', 500);
        }


    })

    // hide Delete button
    $(".checkbox_delete").hide();
    // Checkboxes  Order Data
    var val = [];

    // Select Multi Checkbox Data
    $("#checkAll").change(function() {

        $("input:checkbox").prop('checked', $(this).prop("checked"));

        if ($("input:checkbox").prop('checked')) {
            // show Delete button           
            $(".checkbox_delete").show();
            intervalId = true;
        } else {
            // hide Delete button
            $(".checkbox_delete").hide();
            intervalId = false;

        }
    });

    // Multi Checkbox  delete data

    $(".checkbox_delete").click(function() {
        const token = $("meta[name='csrf-token']").attr("content");

        if ($('.ckboxes:checked').attr("value") != null) {
            // All checkboxes  value store in  array 
            $('.ckboxes:checked').each(function(i) {
                val[i] = $(this).val();
            });

            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this order!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: multi_checkbox,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            'multi_checkbox_data': val,
                            '_token': token
                        },
                        success: function(response) {
                            if (response.statuscode == 200) {
                                $('.data-table').DataTable().ajax.reload(null, false);
                                // console.log(response.message);
                            } else {
                                if (response.statuscode == 204) {
                                    console.log(response.message);
                                }
                            }
                        },
                        error: function(err) {

                            console.log(err);
                        },
                    });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your Order has been delete.",
                        icon: "success"
                    });
                }
            });



        } else {


        }


    });

});