@extends('Backend.main.main')

@section('content')


<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Edit Coupon
        <span class="float-right">
            <a href="{{route('admin.coupon.allcoupons')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{-- Edit Coupon Section --}}

<div class="pb-5 pt-2">
    <div class="card">
        <!-- form -->
        <form action="{{route('admin.coupon.updatecoupon')}}" method="post">
            @csrf
            <div class="card-body pb-3 p-3">
                <div class="row">

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="coupon_code"
                                value="{{old('coupon_code',$coupon_detail->coupon_code)}}" class="form-control"
                                placeholder="coupon code" required>
                                <input type="hidden" name="coupon_id" value="{{$coupon_detail->id}}" id="">
                            <label for="" class="form-label">coupon code <span style="color:red">*</span></label>
                        </div>
                        @error('coupon_code')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="number" name="coupon_amount"
                                value="{{old('coupon_amount',$coupon_detail->coupon_amount)}}" class="form-control"
                                placeholder="coupon amount" required>
                            <label for="" class="form-label">coupon amount <span style="color:red">*</span></label>
                        </div>
                        @error('coupon_amount')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>


                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="number" name="number_of_uses"
                                value="{{old('number_of _uses',$coupon_detail->number_of_uses)}}" class="form-control"
                                placeholder="number of uses" required>
                            <label for="" class="form-label">number of uses <span style="color:red">*</span></label>
                        </div>
                        @error('number_of_uses')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>


                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="number" name="limit_per_uses"
                                value="{{old('limit_per_uses',$coupon_detail->limit_per_uses)}}" class="form-control"
                                placeholder="limit_per_uses" required>
                            <label for="" class="form-label">limit per uses <span style="color:red">*</span></label>
                        </div>
                        @error('limit_per_uses')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="number" name="coupon_stock" value="{{old('coupon_stock',$coupon_detail->coupon_stock)}}"
                                class="form-control" placeholder="coupon stock" required >
                            <label for="" class="form-label">coupon stock <span style="color:red">*</span></label>
                        </div>
                        @error('coupon_stock')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <select class="form-control" name="coupon_status">
                                @if($coupon_detail->coupon_status == 'A')
                                <option value="A" selected>Active</option>
                                <option value="I">Inctive</option>
                                @else
                                <option value="A">Active</option>
                                <option value="I" selected>Inctive</option>
                                @endif
                            </select>
                            <label for="" class="">coupon status</label>
                            @error('coupon_status') <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="date" name="coupon_start_date"
                                value="{{old('coupon_start_date',$coupon_detail->coupon_start_date)}}"
                                class="form-control" placeholder="coupon_start_date" required>
                            <label for="" class="form-label">coupon_start_date <span style="color:red">*</span></label>
                        </div>
                        @error('coupon_start_date')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="date" name="coupon_end_date"
                                value="{{old('coupon_end_date',$coupon_detail->coupon_end_date)}}" class="form-control"
                                placeholder="coupon_end_date" required>
                            <label for="" class="form-label">coupon_end_date <span style="color:red">*</span></label>
                        </div>
                        @error('coupon_end_date')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

           

                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <!-- form end-->
    </div>
</div>

{{-- Edit Coupon Section End --}}



@endsection