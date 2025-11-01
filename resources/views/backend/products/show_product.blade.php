@extends('backend.main.main')

@section('content')

<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Products</h3>
    <a href="{{route('admin.product.add')}}" class="text-white"> <button type="btn" class="btn btn-primary "
      style="padding:7px 15px"> <i class="fa fa-plus"></i> Add New</button></a>
</div>

{{--Show Product--}}

<div class="card-body pb-0">
        <!-- <h5 class="card-title"></h5> -->
    <div style="min-height: 200px; padding-bottom:70px">
<table class="table table-bordered data-table text-center bg-white">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Thumbnail</th>
            <th scope="col">Category</th>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Stock</th>
            <th scope="col">Status</th>
            <th scope="col">Created</th>
            <th width="">Action</th>
        </tr>
    </thead>

    <body>
        </tbody>
</table>
</div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function () {

        var table = $('.data-table').DataTable({

            processing: false,

            serverSide: true,

            "pageLength": 10,

            lengthMenu: [ 10, 25, 50, 100],

            ajax: "{{route('admin.product.showproduct')}}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                { data: 'thumbnail', name: 'thumbnail' },

                { data: 'category', name: 'category' },

                { data: 'product_name', name: 'product_name' },

                { data: 'product_price', name: 'product_price' },
            
                { data: 'product_stock_status', name: 'product_stock_status' },

                { data: 'product_status', name: 'product_status' },

                { data: 'create_at', name: 'create_at' },

                { data: 'action', name: 'action', orderable: true, searchable: true },

            ]

        });

    });
</script>
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