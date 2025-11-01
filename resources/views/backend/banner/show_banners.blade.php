@extends('backend.main.main')

@section('content')

<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Show Banner</h3>
    <a href="{{route('admin.banner.addbanner')}}" class="text-white float-right"> <button type="btn" class="btn btn-primary "
      style="padding:7px 15px"> <i class="fa fa-plus"></i> Add New</button></a>
</div>

<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Image</th>
            <th scope="col">Start Text</th>
            <th scope="col">Title</th>
            <th scope="col">Subtitle</th>
            <th scope="col">link</th>
            <th scope="col">Status</th>
            <th scope="col">Created at</th>
            <th width="100px">Action</th>

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

            processing: true,

            serverSide: true,

            "pageLength": 5,

            lengthMenu: [5, 10, 25, 50, 100],

            ajax: "{{route('admin.banner.showbanners')}}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                { data: 'banner_image', name: 'banner_image' },

                { data: 'banner_start_text', name: 'banner_start_text' },

                { data: 'banner_title', name: 'banner_title' },

                { data: 'banner_subtitle', name: 'banner_subtitle' },

                { data: 'banner_btnlink', name: 'banner_btnlink' },

                { data: 'banner_status', name: 'banner_status' },

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

