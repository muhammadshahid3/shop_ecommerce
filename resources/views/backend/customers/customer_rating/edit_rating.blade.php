@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Edit Customer Rating
        <span class="float-right">
            <a href="{{route('admin.customer.rating')}}"><button class="btn btn-primary">
                 <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--Edit Rating--}}

<div class="pb-5 pt-2">
    <div class="card">
    @if (isset($single_rating_details))          
                <!-- form -->
                <form action="{{route('admin.customer.rating.update')}}" method="post">
                    @csrf
                    <div class="card-body pb-3 p-3">
                    <div class="row">

                    <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                            <?php  
                                 $customer  = App\Models\Customer::all();
                                if(isset($customer)){
                                    foreach ($customer as $key => $customer_Details) {
                                            if($customer_Details->id == $single_rating_details->customer_id){
                                            echo  '<input type="text" name="customer_id" value="'.$customer_Details->username.'" class="form-control" required>';
                                            }
                                    }
                                  }else{
                                     echo  '<input type="text" name="customer_id" value="Empty" class="form-control" required>';
                                  }
                                
                            ?>
                                <label for="" class="form-label">Customer <span style="color:red">*</span></label>
                            </div>
                            @error('customer_id')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                        <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                                <?php  
                                 $category  = App\Models\Category::all();
                                 if(isset($category)){
                                     foreach ($category as $key => $category_Details) {
                                             if($category_Details->id == $single_rating_details->category_id){
                                             echo  '<input type="text" name="category_id" value="'.$category_Details->category_name.'" class="form-control" required>';
                                             }
                                     }
                                   }else{
                                      echo  '<input type="text" name="category_id" value="Empty" class="form-control" required>';
                                   }
                                ?>
                                <label for="" class="form-label"> Category <span style="color:red">*</span></label>
                            </div>
                            @error('category_id')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                        <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                             <?php  
                                $product  = App\Models\Product::all();
                                if(isset($product)){
                                    foreach ($product as $key => $product_Details) {
                                        if($product_Details->id == $single_rating_details->product_id){
                                        echo  '<input type="text" name="product_id" value="'.$product_Details->product_name.'" class="form-control" required>';
                                        }
                                    }
                                }else{
                                    echo  '<input type="text" name="product_id" value="Empty" class="form-control" required>';
                                }
                            ?>
                                <label for="" class="form-label"> Product <span style="color:red">*</span></label>
                            </div>
                            @error('product_id')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                      <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                                <input type="text" name="stars" value="{{old('stars',$single_rating_details->stars)}}" class="form-control"  required>
                                <input type="hidden" name="rating_id" value="{{$single_rating_details->id}}" class="form-control">
                                <input type="hidden" name="old_customer_id" value="{{$single_rating_details->customer_id}}" class="form-control">
                                <input type="hidden" name="old_category_id" value="{{$single_rating_details->category_id}}" class="form-control">
                                <input type="hidden" name="old_product_id" value="{{$single_rating_details->product_id}}" class="form-control">

                                <label for="" class="form-label">Rating Star <span style="color:red">*</span></label>
                            </div>
                            @error('stars')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>
                        
                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Review Message <span style="color:red">*</span></label>
                                <textarea name="review_message" cols="60" rows="5" class="form-control" style="width:100%" id=""
                                    placeholder="message">{{$single_rating_details->review_message}}</textarea>
                            </div>
                            @error('review_message')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                    </div>
                    <div>
                    <button type="submit" class="btn btn-primary">update</button>
                        
                    </div>
                    </div>

                </form>
                <!-- form end-->
         
  
    @endif
    </div>
    </div>

@endsection