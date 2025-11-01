@extends('backend.main.main')


@section('content')
<!-- Button trigger modal -->

{{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Customer Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    {{--Model End--}}


    <div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Contact Us</h3>
   
</div>

<table class="table table-bordered data-table text-center bg-white w-100">
    <thead>
        <tr>
            <th scope="col" class="text-center">No</th>
            <th scope="col" class="text-center" >Customer</th>
            <th scope="col" class="text-center">Subject</th>
            <th scope="col" class="text-center">Message</th>
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

            processing: true,

            serverSide: true,

            "pageLength": 5,

            lengthMenu: [5, 10, 25, 50, 100],

            ajax: "{{route('admin.contact.showcontact')}}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                { data: 'customer', name: 'customer' },

                { data: 'subject', name: 'subject' },

                { data: 'msg_btn', name: 'msg_btn' },

                { data: 'created_at', name: 'created_at' },

                { data: 'action', name: 'action', orderable: true, searchable: true },

            ]

        });

    });

{{--Session Msg--}}

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

{{--Model Msg--}}
$(document).on('click', '.editdata', function () {
        
        var id = $(this).attr('value');
        const token = $("meta[name='csrf-token']").attr("content");
      $.ajax({
           url: '{{route('admin.contact.msgdata')}}',
           method: 'POST',
           dataType: 'json',
           data : { id : id , _token :token},
          success: function(data)
          {
  
              $(".modal-body").html(data);
              // console.log(data);
          },
          error: function(err)
          {
              console.log(err);
          }
            
          });
  });
       
</script>

@endsection

  