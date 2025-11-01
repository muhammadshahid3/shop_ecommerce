
@extends('Backend.main.main')

@section('content')

{{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">FAQ Answer</h5>
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
    <h3 class="text-primary">FAQS</h3>
    <a href="{{route('admin.faqs.add-faq')}}" class="text-white"> <button type="btn" class="btn btn-primary "
    style="padding:7px 15px"> <i class="fa fa-plus"></i> Add New</button></a>
    
</div>
 {{--Show Faq--}}
 
<table class="table table-bordered data-table text-center bg-white w-100">
    <thead>
        <tr>
            <th scope="col" class="text-center">No</th>
            <th scope="col" class="text-center">Question</th>
            <th scope="col" class="text-center">Answer</th>
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

            ajax: "{{route('admin.faqs')}}",


            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                { data: 'question', name: 'question' },

                { data: 'view_icon', name: 'view_icon' },

                { data: 'created_at', name: 'created_at' },

                { data: 'action', name: 'action', orderable: true, searchable: true },

            ]

        });

    });

    // <!-- Session Msg -->
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
// <!-- Session Msg End-->

$(document).ready(function () {
    $(document).on('click' , '.answer_btn',function () {
        $token = $("meta[name = 'csrf-token']").attr('content');
         faq_id =  $(this).attr('value');
         $.ajax({
            url : '{{route('admin.faqs.view-message')}}',
            method: 'post',
            dataType : 'json',
            data : {'faq_id' :faq_id, '_token' : $token},
            success :function(data){
                $(".modal-body").html(data);
            },
            error :function (err){
                console.log(err);
            }

        })

    })
})

</script>


@endsection