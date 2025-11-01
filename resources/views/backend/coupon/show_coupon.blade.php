@extends('backend.main.main')

@section('content')


<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Coupons</h3>
    <a href="{{route('admin.coupon.addcoupon')}}" class="text-white float-right"> <button type="btn"
            class="btn btn-primary " style="padding:7px 15px"> <i class="fa fa-plus"></i> Add New</button></a>
</div>

{{-- Show Coupons --}}

<div class="card-body pb-0">
    <!-- <h5 class="card-title"></h5> -->
    <div style="min-height: 200px; padding-bottom:70px">
        <table class="table table-bordered data-table text-center bg-white">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Code</th>
                    <th scope="col" class="text-center">Amount</th>
                    <th scope="col" class="text-center">Number of Uses</th>
                    <th scope="col" class="text-center">Limit per uses</th>
                    <th scope="col" class="text-center">Coupon Stock</th>
                    <th scope="col" class="text-center">Start Date</th>
                    <th scope="col" class="text-center">End Date</th>
                    <th scope="col" class="text-center">Status</th>
                    <th width="" class="text-center">Action</th>

                </tr>
            </thead>

            <body>
                </tbody>
        </table>
    </div>
</div>

{{-- Show Coupons End --}}

@endsection


@section('script')

<script type="text/javascript">
 $(function () {

    var table = $('.data-table').DataTable({

        processing: false,

        serverSide: true,

        "pageLength": 10,

        lengthMenu: [ 10, 25, 50, 100],

        ajax: "{{route('admin.coupon.allcoupons')}}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

            { data: 'coupon_code', name: 'coupon_code' },

            { data: 'coupon_amount', name: 'coupon_amount' },

            { data: 'number_of_uses', name: 'number_of_uses' },

            { data: 'limit_per_uses', name: 'limit_per_uses' },

            { data: 'coupon_stock', name: 'coupon_stock' },

            { data: 'coupon_start_date', name: 'coupon_start_date' },

            { data: 'coupon_end_date', name: 'coupon_end_date' },

            { data: 'coupon_status', name: 'coupon_status' },

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

</script>

@endsection