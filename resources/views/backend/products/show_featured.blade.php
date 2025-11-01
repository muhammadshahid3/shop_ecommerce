@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Featured
       
    </h1>
</div>

{{--Table--}}
@if (isset($featured))
    <table class="table border text-center">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Featured</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php  $id =0; ?>
            @foreach ($featured as $featured_data)
                   <?php $id++;  ?>     
                <tr>
                    <th scope="row">{{$id}}</th>
                    <td>{{$featured_data->product_name}}</td>
                    <td>{{$featured_data->category_name}}</td>
                    <form action="{{route('admin.product.featured.del',$featured_data->id)}}" method="post">
                        @csrf
                        @method('delete')
                    <td><button type="submit" class="btn text-primary"> <i class="fa fa-trash"></i</button></td>
                         <input type="hidden" name="old_featured_id" value="{{$featured_data->id}}">
                    </form>
                </tr>   
            @endforeach
            </tbody>
    </table>
    @else
        <h5 class="text-center">No Featured Available</h5>
    @endif

@endsection

@section('script')
    <!-- Session Msg -->
<script>
@if(Session()->has('msg'))
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
  title: "{{session()->get('msg')}}",
  showCloseButton: true
});
@enderror
</script>
<!-- Session Msg End-->
@endsection