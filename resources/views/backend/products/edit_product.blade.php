@extends('backend.main.main')

@section('content')

{{--Edit Model--}}

@include("backend.products.stock_edit_model.edit_model")

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Edit Product
        <span class="float-right">
            <a href="{{route('admin.product.showproduct')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--Add Category--}}

<div class="pb-5 pt-2">
    <div class="card">
        @if (!empty($editproduct_record))
                <!-- form -->
                <form action="{{route('admin.product.showproduct.updateproduct')}}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <input type="hidden" name="product_id" value="{{$editproduct_record->id}}">
                    <div class="card-body pb-3 p-3">
                        <div class="row">

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <select class="form-control" name="category_id">
                                        @php
                                            foreach ($category as $category_item) {
                                                if ($category_item->id == $editproduct_record->category_id) {
                                                    echo '<option value="' . $category_item->id . '" selected>' . $category_item->category_name . '</option>';
                                                } else {
                                                    echo '<option value="' . $category_item->id . '" >' . $category_item->category_name . '</option>';
                                                }
                                            }
                                        @endphp
                                    </select>
                                    <label for="" class="">Product Category <span style="color:red">*</span></label>
                                </div>
                                @error('category_id')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>


                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="product_name"
                                        value="{{old('product_name', $editproduct_record->product_name)}}" class="form-control"
                                        placeholder="Product Name">
                                    <input type="hidden" name="slug" value="{{$editproduct_record->product_slug}}" id="">
                                    <label for="" class="form-label">Product Name <span style="color:red">*</span></label>
                                </div>
                                @error('product_name')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="product_old_price"
                                        value="{{old('product_old_price', $editproduct_record->product_old_price)}}"
                                        class="form-control" placeholder="Product old Price">
                                    <label for="" class="form-label">Product old Price</label>
                                </div>
                                @error('product_old_price')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="product_price"
                                        value="{{old('product_price', $editproduct_record->product_price)}}"
                                        class="form-control" placeholder="Product Price">
                                    <label for="" class="form-label">Product Price <span style="color:red">*</span></label>
                                </div>
                                @error('product_price')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="product_manufacturer"
                                        value="{{old('product_manufacturer', $editproduct_record->product_manufacturer)}}"
                                        class="form-control" placeholder="Product Mnufacturer">
                                    <label for="" class="form-label">Product Manufacturer</label>

                                </div>
                                @error('product_manufacturer')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="product_supplier"
                                        value="{{old('product_supplier', $editproduct_record->product_supplier)}}"
                                        class="form-control" placeholder="Product Supplier">
                                    <label for="" class="form-label">Product Supplier</label>
                                </div>
                                @error('product_supplier')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="product_weight"
                                        value="{{old('product_weight', $editproduct_record->product_weight)}}"
                                        class="form-control" placeholder="Product Weight">
                                    <label for="" class="form-label">Product Weight</label>
                                </div>
                                @error('product_weight')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="product_order"
                                        value="{{old('product_order', $editproduct_record->product_order)}}"
                                        class="form-control" placeholder="Product Order">
                                    <input type="hidden" name="old_product_order"
                                        value="{{$editproduct_record->product_order}}">
                                    <input type="hidden" name="old_product_barcode"
                                        value="{{$editproduct_record->product_barcode}}" id="">
                                    <label for="" class="form-label">Product Order</label>
                                </div>
                                @error('product_order')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <select class="form-control" name="product_stock_status">
                                        @if ($editproduct_record->product_stock_status == 'A')
                                            <option value="A" selected>Available</option>
                                            <option value="I">None</option>
                                        @else
                                            <option value="A">Available</option>
                                            <option value="I" selected>None</option>
                                        @endif
                                    </select>
                                    <label for="" class="">Stock Status</label>
                                </div>
                                @error('product_stock_status')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating input-group">
                                    <input type="text" name="stock_quantity" id="stock_value" min="1" value="{{old('stock_quantity',$editproduct_record->stock_quantity)}}" disabled
                                        class="form-control">
                                        <input type="hidden" name="old_stock" value="{{$editproduct_record->stock_quantity}}">
                                        <input type="hidden" name="old_product_id" id="product_id" value="{{$editproduct_record->id}}">
                                    <button class="btn btn-outline-primary stock_edit" type="button" id="button-addon2"><i class="fa fa-pen"></i></button>
                                    <label for="" class="form-label"> Stock Quanty </label>
                                </div>
                                @error('stock_quantity')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            {{--Product Featured--}}

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <span for="" style="font-weight:bold;"> Add item in specific group </span>
                                    <br><br>
                                    <?php 

                                    if (!empty($trending_products)) {
                                           // foreach ($trending_products as $key => $trending_products) {
                                        if ($editproduct_record->id == $trending_products->feature_product_id) {
                                            echo ' <input type="checkbox" class="mx-1" name="featured" value="1" checked> Featured';

                                        } else {
                                            echo ' <input type="checkbox" class="mx-1" name="featured" value="1"> Featured';

                                        }
                                        if ($editproduct_record->id == $trending_products->newarrival_product_id) {
                                            echo ' <input type="checkbox" class="mx-1" name="newarrivals" value="1" checked> new arrivals';

                                        } else {
                                            echo ' <input type="checkbox" class="mx-1" name="newarrivals" value="1"> new arrivals';

                                        }
                                        if ($editproduct_record->id == $trending_products->topseller_product_id) {
                                            echo ' <input type="checkbox" class="mx-1" name="topsellers" value="1" checked> Top Sellers';

                                        } else {
                                            echo ' <input type="checkbox" class="mx-1" name="topsellers" value="1"> Top Sellers';

                                        }

                                     }

                                ?>

                                </div>
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <select class="form-control" name="product_status">
                                        @if ($editproduct_record->product_status == 'A')
                                            <option value="A" selected>Active</option>
                                            <option value="I">InActive</option>
                                        @else
                                            <option value="A">Active</option>
                                            <option value="I" selected>InActive</option>
                                        @endif
                                    </select>
                                    <label for="" class="">Product Status</label>
                                </div>
                                @error('product_status')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>
                            {{--Upload Images--}}

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="file" name="product_thumbnail" value="" class="form-control mb-3">
                                    @if(!empty($editproduct_record->product_thumbnail))
                                        @if(file_exists(public_path('upload/product/' . $editproduct_record->product_thumbnail)))
                                            <img src="{{asset('upload/product/' . $editproduct_record->product_thumbnail)}}" width="60"
                                                height="60" alt="">
                                        @else
                                            <img src="{{asset('upload/product/dummy.png')}}" width="60" height="60" alt="">

                                        @endif
                                    @else
                                        <img src="{{asset('upload/product/dummy.png')}}" width="60" height="60" alt="">
                                    @endif
                                    <label for="" class="form-label">Product Thumbnail</label>
                                </div>
                                @error('product_thumbnail')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="file" name="product_images[]" value="" class="form-control mb-2" multiple>
                                    @php
                                        $images = App\Models\Product_images::where('product_id', $editproduct_record->id)->pluck('product_images');
                                        if (!empty($images)) {

                                            foreach ($images as $image) {
                                                if (file_exists(public_path('upload/product/gallery_imgs/' . $image))) {
                                                    $url = asset('upload/product/gallery_imgs/' . $image);
                                                    echo '<img src="' . $url . '" class="mx-2" width="60" height="60" alt="">';
                                                } else {
                                                    $url = asset('upload/product/gallery_imgs/dummy.png');
                                                    echo '<img src="' . $url . '" width="60" height="60" alt="">';
                                                }
                                            }
                                        } else {
                                            $url = asset('upload/product/gallery_imgs/dummy.png');
                                            echo '<img src="' . $url . '" width="60" height="60" alt="">';
                                        } 
                                    @endphp
                                    <label for="" class="form-label">Product Images</label>
                                </div>
                                @error('product_images')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-12 col-md-62">
                                <div class="mb-3">
                                    <label for="" class="form-label">Product Description</label>
                                    <textarea class="summernote" name="product_description">
                                                            {!! $editproduct_record->product_description !!}
                                                                </textarea>
                                </div>
                                @error('product_description')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            {{--Additional Details--}}

                            <div class="col-12 mb-2">
                                <div class="pagetitle mt-3 mb-4">
                                    <h4>
                                        Additional Detail
                                    </h4>
                                </div>
                            </div>

                            <div class="multirecord">
                                @if (isset($additional_details))
                                    @foreach ($additional_details as $additional_details_list)

                                        <div class="row duplicate align-items-center">

                                            <div class="col-md-4 col-12 pb-3">
                                                <h6> Attribute</h6>
                                                <div class="mb-3">
                                                    <input type="text" name="attribute[]"
                                                        value="{{$additional_details_list->attribute}}" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12 pb-3">
                                                <h6 class="text-left"> Detail</h6>
                                                <div class="mb-3">
                                                    <textarea name="detail[]" class="form-control" cols="50" rows="1"
                                                        id="">{{$additional_details_list->detail}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <button class="btn btn-outline-danger mb-1" id="remove_btn"><i class="fa fa-trash"
                                                        style="font-size:13px"></i></button>
                                            </div>

                                        </div> {{--Row End--}}

                                    @endforeach
                                @endif
                            </div> {{--multi record--}}
                            {{--Add Btn--}}
                            <div class="col-12">
                                <div class="text-center pb-3">
                                    <button class="btn btn-primary add_btn">Add <i class="fa fa-plus"
                                            style="font-size:13px"></i></button>
                                </div>
                            </div>

                            {{--Add Additional Fields End--}}


                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
        @endif
        <!-- form end-->
    </div>
</div>

<!-- /.card -->
</section>
@endsection


@section('script')
<script>
    $(function () {
        // Summernote
        $('.summernote').summernote({
            height: 200,
        });
    });

    //add rows when add button is clicked
    $(".add_btn").click(function (e) {
        e.preventDefault();
        $(".multirecord").append(`
                         <div class="row duplicate align-items-center">

                            <div class="col-md-4 col-12 pb-3">
                       <h6> Attribute</h6>
                                <div class="mb-3">
                                    <input type="text" name="attribute[]" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                       <h6 class="text-left"> Detail</h6>
                                <div class="mb-3">
                                    <textarea name="detail[]" class="form-control" cols="50" rows="1" id=""></textarea>
                                </div>
                            </div>

                            <div class="col-2">
                       
                                <button class="btn btn-outline-danger mb-1" id="remove_btn"><i class="fa fa-trash"
                                        style="font-size:13px"></i></button>
                            </div>

                        </div> {{--Row End--}}`);

    });

    //remove rows when remove button is clicked
    $(document).on('click', '#remove_btn', function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });

    // Stock Edit 

    $('.stock_edit').click(function () {
        $('#staticBackdrop').modal('show');
        $token = $("meta[name = 'csrf-token']").attr('content');
       var  stock_value = $('#stock_value').val();

       $.ajax({
        url : '{{route('admin.product-qnty')}}',
        method: 'post',
        data: {'stock_value': stock_value, '_token' : $token},
        success:function (response){
            if(response.status== 200){
                $('.modal-body').html(response.product_stock_qnty);
            }else{
                console.log(response.status);
            }
        },
        error :function (err){
            console.log(err);
        }
       });

    });

    // Save Product Stock
    $('.stock_btn').click(function(){
        $token = $("meta[name = 'csrf-token']").attr('content');

       var  product_id= $('#product_id ').val();
       var  old_stock_qnty = $('#stock_value').val();
       var new_stock_qnty = $('#new_Stock_qnty').val();

       $.ajax({
        url : '{{route('admin.save-qnty')}}',
        method: 'POST',
        data: {'old_stock_qnty' : old_stock_qnty ,'new_stock_qnty' : new_stock_qnty , 'product_id' : product_id ,'_token' : $token},
        success:function (response){

                if(response.status == 200){

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
                        icon: "success",
                        title:  response.message,
                        showCloseButton: true
                        });
                    
                       setTimeout(function() {
                        window.location.reload();
                       },2000);
                        
                }else{

                    if(response.status == 204){

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
                        icon: "success",
                        title:  response.message,
                        showCloseButton: true
                        });

                    }

                }
                // $('.modal-body').html(response.product_stock_qnty);
                // console.log(response);
            
        },
        error :function (err){
            console.log(err);
        }
       });

    }) 


</script>
@endsection