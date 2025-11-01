@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        New Arrivals
       
    </h1>
</div>

{{--Table--}}
@if (isset($arrivals))
    <table class="table border text-center">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Arrivals</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php  $id =0; ?>
            @foreach ($arrivals as $arrivals_data)
            <?php  $id++; ?>
                <tr>
                    <th scope="row">{{$id}}</th>
                    <td>{{$arrivals_data->product_name}}</td>
                    <td>{{$arrivals_data->category_name}}</td>
                    <form action="{{route('admin.product.new-arrival.del',$arrivals_data->id)}}" method="post">
                        @csrf
                        @method('delete')
                    <td><button type="submit" class="btn text-primary"> <i class="fa fa-trash"></i</button></td>
                    <input type="hidden" name="old_arrivals_id" value="{{$arrivals_data->id}}">
                    </form>
                </tr>
            @endforeach
    </table>
@else
    <h5 class="text-center">No arrivals Available</h5>
@endif
</tbody>

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