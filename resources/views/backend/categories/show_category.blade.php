@extends('backend.main.main')

@section('content')



<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Categories</h3>
    <a href="{{route('admin.category.add')}}" class="text-white"> <button type="btn" class="btn btn-primary "
      style="padding:7px 15px"> <i class="fa fa-plus"></i> Add New</button></a>
</div>

{{--Show Category--}}

    <div class="card-body pb-0">
        <!-- <h5 class="card-title"></h5> -->
    <div style="min-height: 200px; padding-bottom:70px">
<table class="table table-bordered data-table text-center bg-white">
    <thead>
        <tr>
            <th scope="col" class="text-center">No</th>
            <th scope="col" class="text-center">Category</th>
            <th scope="col" class="text-center">Image</th>
            <th scope="col" class="text-center">Icon</th>
            <th scope="col" class="text-center">Order</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Created at</th>
            <th width="" class="text-center">Action</th>

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

            processing: true,

            serverSide: true,

            "pageLength": 10,

            lengthMenu: [ 10, 25, 50, 100],

            ajax: "{{route('admin.category.showcategory')}}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                { data: 'category_name', name: 'category_name' },

                { data: 'image', name: 'image' },

                { data: 'category_icon', name: 'category_icon' },

                { data: 'category_order', name: 'category_order' },

                { data: 'category_status', name: 'category_status' },

                { data: 'created_at', name: 'created_at' },

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
@endif
</script>
<!-- Session Msg End-->

@endsection