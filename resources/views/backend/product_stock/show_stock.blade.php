@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Product Stock Management
    </h1>
</div>

<div class="card p-3">
    <div class="card-body">
        {{--From--}}
        <form action="" method="POST">
            @csrf
            <div class="container">
                <div class="row">
                    {{--Select Category Section--}}

                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Select Category</label>
                            <select class="form-select category_item" name="">
                                <option selected value="">choose this one</option>
                                @if (isset($categories))
                                    @foreach ($categories as $categories_items)
                                        <option value="{{$categories_items->id}}">{{$categories_items->category_name}}</option>

                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    {{--Select Category Section End--}}

                    {{--Select Product Section--}}
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label ">Select Product</label>
                            <select class="form-select products_fetch_data" name="">
                            </select>
                        </div>
                    </div>
                    <hr class="mt-4 mb-4">
                    {{--Select Product Section End--}}

                    {{--Product stock table--}}
                    <!-- <div class="col-12"> -->
                    <table class="table table-bordered w-50 text-center">
                        <thead>
                            <tr>
                                <th scope="col">Allow Stock</th>
                                <th scope="col"> Code</th>
                                <th scope="col"> Name</th>
                                <th scope="col"> Stock</th>
                            </tr>
                        </thead>
                        <tbody class="table_body">

                        </tbody>
                    </table>
                        <!-- <div class="response"></div> -->
                    <!-- </div> -->
                    <hr class="mt-4">
                </div>
            </div>

            <div class="stock_btn">
                <button class="btn btn-outline-primary" id="stock_save_btn">Save</button>
            </div>

        </form>
        {{--From End--}}

    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">

    $(document).ready(function () {
        // Category Ajax
        $('.category_item').change(function () {

            var category_id = $(this).val();

            if (category_id) {

                $.ajax({
                    'url': "{{route('admin.category-fetch', '')}}/" + category_id,
                    'type': 'GET',

                    success: function (response) {
                        if (response.response == 200) {

                            $('.products_fetch_data').html(response.categories);

                        } else {
                            console.log(response.status);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

            }

        }); 
              // Product Stock Ajax
        $('.products_fetch_data').change(function () {
            var product_id = $(this).val();
            if (product_id) {
                $.ajax({
                    url: '{{route('admin.product-fetch', '')}}/' + product_id,
                    type: 'GET',
                    success: function (response) {
                        if (response.response == 200) {
                            // $('.response').html('');
                            $('.table_body').html(response.products);
                        }else{
                            // $('.response').html(response.response);
                            console.log(response.status);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            }else{
                $('.table_body').html('<p class="mx-auto">Opps Data Not Found</p>');
            }
        });

        // Stock Permission Allow and not
        $("#stock_save_btn").click(function(e){
            e.preventDefault();
            const token = $("meta[name='csrf-token']").attr("content");
            stock_value = $("#stock_value").attr('value');
            product_stock_id = $("#product_stock_id").attr('value');
            if ($('#check_allow_stock').is(":checked")){
             var checkbox_value =  $("#check_allow_stock").attr('value');
            }
            
            if(product_stock_id && product_stock_id != null && product_stock_id != ''){
                $.ajax({
                    url : "{{route('admin.product.stock-manage')}}",
                    method : 'POST',
                    dataType : "json",
                    data : {'product_stock_id': product_stock_id ,'checkbox_value' : checkbox_value , 'stock_value' : stock_value , '_token' : token},
                    success : function (response){
                        if(response.statuscode == 200){
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
                            title: response.success,
                            showCloseButton: true
                            });
                           
                        }else if(response.statuscode == 400){
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
                            title: response.success,
                            showCloseButton: true
                            });
                        }else{
                            console.log("Server Error",500);
                        }
                    },
                    error : function(error){
                        console.log(error);
                    },
                });
            }
               
        }); 
    });



</script>

@endsection