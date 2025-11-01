@extends('Backend.main.main')

@section('content')

<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Customers</h3>
    <a href="{{route('admin.customer.add')}}" class="text-white float-right"> <button type="btn" class="btn btn-primary "
      style="padding:7px 15px"> <i class="fa fa-plus"></i> Add New</button></a>
</div>

{{--Show Customers--}}

<table class="table table-bordered data-table text-center bg-white w-100">
    <thead>
        <tr>
            <th scope="col" class="text-center">No</th>
            <th scope="col" class="text-center">Username</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col" class="text-center">Phone</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Created at</th>
            <th width="100px" class="text-center">Action</th>

        </tr>
    </thead>

    <body>


        </tbody>
</table>
@endsection

@section('script') 

<script type="text/javascript">
    $(function () {

        var table = $('.data-table').DataTable({

            processing: false,

            serverSide: true,

            "pageLength": 5,

            lengthMenu: [5, 10, 25, 50, 100],

            ajax: "{{route('admin.customer.show')}}",


            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                { data: 'username', name: 'username' },

                { data: 'email', name: 'email' },

                { data: 'phone_number', name: 'phone_number' },

                { data: 'status', name: 'status' },

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

