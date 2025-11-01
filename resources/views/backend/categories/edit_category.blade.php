@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Edit Category
        <span class="float-right">
            <a href="{{route('admin.category.showcategory')}}"><button class="btn btn-primary">
                 <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--Edit Category--}}

<div class="pb-5 pt-2">
    <div class="card">
        <!-- form -->
        @if(!empty($cate))
            @foreach ($cate as $cate_item)
                <form action="{{route('admin.category.showcategory.update', $cate_item->id)}}" method="post"
                    enctype='multipart/form-data'>
                    @csrf
                    <div class="card-body pb-3 p-3">
                        <div class="row">

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="category_name" class="form-control"
                                        value="{{old('category_name', $cate_item->category_name)}}" placeholder="Category Name">
                                    <label for="" class="form-label">Category Name</label>

                                </div>
                                @error('category_name')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="category_icon"
                                        value="{{old('category_icon', $cate_item->category_icon)}}" class="form-control"
                                        placeholder="Select icon" data-fa-browser />
                                    <label for="" class="form-label">Category Icon</label>
                                </div>
                                @error('category_icon')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>

                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="text" name="category_order"
                                        value="{{old('category_order', $cate_item->category_order)}}" class="form-control"
                                        placeholder="Category Order" required>
                                        <input type="hidden" name="old_category_order" value="{{$cate_item->category_order}}">
                                    <label for="" class="form-label">Category Order</label>
                                </div>
                                @error('category_order')
                                <div class="text text-danger">{{$message}}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <select class="form-control" name="category_status">
                                        @if($cate_item->category_status == "A")
                                            <option value="A" selected>Active</option>
                                            <option value="I">InActive</option>
                                        @else
                                            <option value="A">Active</option>
                                            <option value="I" selected>InActive</option>
                                        @endif
                                    </select>
                                    <label for="" class="">Status</label>
                                    @error('category_status')
                                    <div class="text text-danger">{{$message}}</div>@enderror

                                </div>
                            </div>
                            <div class="col-md-6 col-12 pb-3">
                                <div class="form-floating">
                                    <input type="file" name="category_image" value="" class="form-control mb-3">
                                    @if(!empty($cate_item->category_image))
                                        @if (file_exists(public_path('upload/category/' . $cate_item->category_image)))
                                            <img src="{{asset('upload/category/' . $cate_item->category_image)}}" width="60" height="60"
                                                alt="">
                                        @else
                                            <img src="{{asset('upload/category/dummy.png')}}" width="60" height="60" alt="">
                                        @endif
                                    @else
                                        <img src="{{asset('upload/category/dummy.png')}}" width="60" height="60" alt="">
                                    @endif
                                    <label for="" class="form-label">Category Image</label>
                                </div>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            @endforeach
        @endif
        <!-- form end-->
    </div>
</div>

<!-- /.card -->
</section>
@endsection
@section('script')
<script>
    $(function ($) {
        $.fabrowser();
    });
</script>
@endsection