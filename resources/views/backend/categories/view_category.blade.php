@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        View Category
        <span class="float-right">
            <a href="{{route('admin.category.showcategory')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>


{{--View Category--}}

@if (isset($category))
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Category</th>
                <th scope="col">Image</th>
                <th scope="col">Icon</th>
                <th scope="col">Order</th>
                <th scope="col">Status</th>
                <th scope="col">Created at</th>
            </tr>
        </thead>
        <tbody>
            <?php  $id=0; ?>
            @foreach ($category as $category_data)
                <?php  $id++; ?>
                <tr>
                    <th scope="row">{{$id}}</th>
                    <td>{{$category_data->category_name}}</td>

                        @if ($category_data->category_image)
                             <?php  $url = asset('upload/category/'.$category_data->category_image);?>
                            <td>
                                <img src="{{$url}}" width="40" height="40" alt="">
                            </td>
                        @endif

                    <td>
                    <i class="{{$category_data->category_icon}}"></i>
                    </td>
                    <td>{{$category_data->category_order}}</td>

                        @if ($category_data->category_status == 'A')
                            <td>Active</td>
                            @else
                                <td>InActive</td>
                        @endif

                    <td>{{$category_data->created_at->format('m/d/y')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h5 class="m-auto">No Data Available</h5>
@endif
@endsection