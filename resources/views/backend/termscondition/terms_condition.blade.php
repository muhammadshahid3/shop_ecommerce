@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
  <h1 class="text-primary">
    Privacy Policy
  </h1>
</div>



@if (isset($TermCondition))
    <div class="col-md-12">
       <div class="card">
       <form action="{{route('admin.privacy-policy.update-privacy-policy',$TermCondition->id)}}" method="post">
            @csrf
            <div class="card-body pt-4">
                <textarea id="summernote" style="height:100px;" name="termcondition">
                  {{$TermCondition->value}} 
              </textarea>
                <button type="submit" class="btn btn-primary mt-3">Save</button>
                
        

        </div>
        </form>
       </div>
    </div>
    <!-- /.col-->
    @else
        <h5 class="m-auto">No Data Available</h5>
        @endif
</div>
</div>

<!-- ./row -->

@endsection

{{--Editor JS--}}

@section('script')
<script type="text/javascript">

    $(function () {
        // Summernote
        $('#summernote').summernote({
          height: 350,
          airMode: false,
          // toolbarContainer: false

        });

        
    });

</script>
<!-- Session Msg -->
<script type="text/javascript">
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

