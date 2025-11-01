@extends('backend.main.main')

@section('content')

{{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Customer Review Message</h5>
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
    <h3 class="text-primary">Customer Ratings</h3>
  
</div>

{{--Show Category--}}

    <div class="card-body pb-0">
        <!-- <h5 class="card-title"></h5> -->
    <div style="min-height: 200px; padding-bottom:70px">
<table class="table table-bordered data-table text-center bg-white">
    <thead >
        <tr>
            <th scope="col" class="text-center">No</th>
            <th scope="col" class="text-center">Customer</th>
            <th scope="col" class="text-center">Category</th>
            <th scope="col" class="text-center">Product</th>
            <th scope="col" class="text-center">Rating</th>
            <th scope="col" class="text-center">Review Message</th>
            <th scope="col" class="text-center">Created at</th>
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

            processing: true,

            serverSide: true,

            "pageLength": 5,

            lengthMenu: [5, 10, 25, 50, 100],

            ajax: "{{route('admin.customer.rating')}}",

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                { data: 'customer_name', name: 'customer_name' },

                { data: 'category_name', name: 'category_name' },

                { data: 'product_name', name: 'product_name' },

                { data: 'stars', name: 'stars' },

                { data: 'view_icon', name: 'view_icon' },

                { data: 'created_at', name: 'created_at' },

                { data: 'action', name: 'action', orderable: true, searchable: true },

            ]

        });

    });

{{-- Session Msg --}}

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
{{-- Session Msg End--}}

{{--Review Message--}}
    $(document).ready(function () {
        $(document).on('click','.review_data',function(){
            $token = $("[name ='csrf-token']").attr('content');
           $review_message_id = $(this).attr('value');
            
        $.ajax({
            url : '{{route('admin.customer.rating.review-msg')}}',
            method: 'post',
            dataType : 'json',
            data : {'review_message_id' : $review_message_id, '_token' : $token},
            success :function(data){
                $(".modal-body").html(data);
            },
            error :function (err){
                console.log(err);
            }

        })
        })
    })

{{--Review Message End--}}

</script>

<script>

@endsection