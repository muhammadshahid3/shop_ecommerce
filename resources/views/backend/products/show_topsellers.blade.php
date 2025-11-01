@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Top Sellers
       
    </h1>
</div>

{{--Table--}}
@if (isset($topsellers))
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
            @foreach ( $topsellers as $topsellers_data)
            <?php  $id++; ?>
                <tr>
                    <th scope="row">{{$id}}</th>
                    <td>{{ $topsellers_data->product_name}}</td>
                    <td>{{ $topsellers_data->category_name}}</td>
                    <form action="{{route('admin.product.top-seller.del',$topsellers_data->id)}}" method="post">
                        @csrf
                        @method('delete')
                    <td><button type="submit" class="btn text-primary"> <i class="fa fa-trash"></i</button></td>
                    <input type="hidden" name="old_topsellers_id" value="{{$topsellers_data->id}}">
                    </form>
                </tr>
            @endforeach
    </table>
@else
    <h5 class="text-center">No Top Sellers Available</h5>
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