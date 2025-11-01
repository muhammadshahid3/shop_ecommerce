@extends('backend.main.main')

@section('content')



<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Add Product
        <span class="float-right">
            <a href="{{route('admin.product.showproduct')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--Add Category--}}

<div class="pb-5 pt-2">
    <div class="card">
        <!-- form -->
        <form action="{{route('admin.product.storeproduct')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <div class="card-body pb-3 p-3">
                <div class="row">

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <!-- Display Category -->
                            @if (!empty($category))

                                <select class="form-control" name="category_id">
                                    <option selected value=""> choose category</option>
                                    @foreach ($category as $category_list)
                                        <option value="{{$category_list->id}}">{{$category_list->category_name}}</option>
                                    @endforeach
                                </select>
                                <label for="" class=""> Category <span style="color:red">*</span></label>
                            @endif
                        </div>
                        <!-- Display Category End-->
                        @error('category_id')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="product_name" value="{{old('product_name')}}" class="form-control"
                                placeholder="name">
                            <label for="" class="form-label"> Name <span style="color:red">*</span></label>
                        </div>
                        @error('product_name')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="product_old_price" value="{{old('product_old_price')}}"
                                class="form-control" placeholder=" old price">
                            <label for="" class="form-label"> Old Price</label>
                        </div>
                        @error('product_old_price')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="product_price" value="{{old('product_price')}}"
                                class="form-control" placeholder="price">
                            <label for="" class="form-label"> Price <span style="color:red">*</span></label>
                        </div>
                        @error('product_price')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="product_manufacturer" value="{{old('product_manufacturer')}}"
                                class="form-control" placeholder="manufacturer">
                            <label for="" class="form-label"> Manufacturer </label>
                        </div>
                        @error('product_manufacturer')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="product_supplier" value="{{old('product_supplier')}}"
                                class="form-control" placeholder="supplier">
                            <label for="" class="form-label"> Supplier </label>
                        </div>
                        @error('product_supplier')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="file" name="product_thumbnail" value="" class="form-control">
                            <label for="" class="form-label"> Thumbnail <span style="color:red">*</span></label>
                        </div>
                        @error('product_thumbnail')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="file" name="product_imgs[]" value="" class="form-control" multiple>
                            <label for="" class="form-label"> Product Images </label>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="product_weight" value="{{old('product_weight')}}"
                                class="form-control" placeholder="weight">
                            <label for="" class="form-label"> Weight </label>
                        </div>
                        @error('product_weight')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>


                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            @php  $order = count($order) @endphp
                            <input type="text" name="product_order" min="{{$order + 1}}" max="{{$order + 1}}"
                                value="{{old('product_order', $order + 1)}}" class="form-control" placeholder="order">
                            <label for="" class="form-label"> Order</label>
                        </div>
                        @error('product_order')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <select class="form-control" name="product_stock_status">
                                <option value="A" selected>Available</option>
                                <option value="I">Not Available</option>
                            </select>
                            <label for="" class=""> Stock Status </label>
                        </div>
                        @error('product_stock_status')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="stock_quantity" min="1" value="{{old('stock_quantity')}}"
                                class="form-control">
                            <label for="" class="form-label"> Stock Quanty </label>
                        </div>
                        @error('stock_quantity')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>
   
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <span style="font-weight:bold;"> Add item in specific group </span>
                            <br><br>
                            <input type="checkbox" class="mx-1" name="featured" value="1"> Featured
                            <input type="checkbox" class="mx-1" name="trending" value="1"> Trendding
                            <input type="checkbox" class="mx-1" name="topsellers" value="1"> Top Sellers
                        </div>
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <select class="form-control" name="product_status">
                                <option value="A" selected>Active</option>
                                <option value="I">InActive</option>
                            </select>
                            <label for="" class=""> Status </label>
                        </div>
                        @error('product_status')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="mb-3">
                            <label for="" class="form-label"> Description <span style="color:red">*</span></label>
                            <textarea class="summernote" name="product_description" value="{{old('product_description')}}">

                             </textarea>
                        </div>
                        @error('product_description')
                        <div class="text text-danger">{{$message}}</div>@enderror

                    </div>
                    {{--Add Additional Fields--}}
                    <div class="col-12 mb-2">
                        <div class="pagetitle mt-3 mb-4">
                            <h4>
                                Additional Detail
                            </h4>
                        </div>
                    </div>

                    <div class="multirecord">
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

                        </div> {{--Row End--}}



                    </div> {{--multi record--}}
                    {{--Add Btn--}}
                    <div class="col-12">
                        <div class="text-center pb-3">
                            <button class="btn btn-primary add_btn">Add <i class="fa fa-plus"
                                    style="font-size:13px"></i></button>
                        </div>
                    </div>

                    {{--Add Additional Fields End--}}
                    <div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>



                </div>
        </form>

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
                         <div class="row duplicate mt-2">

                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <input type="text" name="attribute[]" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 col-12 pb-3">
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

   



</script>
@endsection