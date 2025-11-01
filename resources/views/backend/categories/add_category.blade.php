@extends('backend.main.main')

@section('content')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Add Category
        <span class="float-right">
            <a href="{{route('admin.category.showcategory')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--Add Category--}}

<div class="pb-5 pt-2">
    <div class="card">
        <!-- form -->
        <form action="{{route('admin.category.store')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <div class="card-body pb-3 p-3">
                <div class="row">

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="category_name" value="" class="form-control"
                                placeholder="category name" required>
                            <label for="" class="form-label">Category Name <span style="color:red">*</span></label>
                        </div>
                        @error('category_name') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="file" name="category_image" value="" class="form-control" required>
                            <label for="" class="form-label">Category Image <span style="color:red">*</span></label>

                        </div>
                        @error('category_image') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="category_icon" class="form-control" placeholder="select icon"
                                data-fa-browser required>
                            <label for="" class="form-label">Category Icon <span style="color:red">*</span></label>
                        </div>
                        @error('category_icon') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            @php $order = count($category) @endphp
                            <input type="number" name="category_order" value="{{old('category_order',$order+1)}}"
                                class="form-control" min="{{$order+1}}" max="{{$order+1}}" placeholder="category order"
                                required>
                            <label for="" class="form-label">Category Order <span style="color:red">*</span></label>
                        </div>
                        @error('category_order') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <select class="form-control" name="category_status">
                                <option value="A" selected>Active</option>
                                <option value="I">Inctive</option>
                            </select>
                            <label for="" class="">Status</label>
                            @error('category_status') <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        <!-- form end-->
    </div>
</div>

@endsection
@section('script')
<script>
    $(function($) {
    $.fabrowser();
});
</script>
@endsection