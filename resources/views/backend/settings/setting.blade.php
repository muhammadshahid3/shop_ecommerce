@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
  <h1 class="text-primary">
    General Settings

  </h1>
</div>

{{--General Settings--}}

<div class="pb-5 pt-2">
  <div class="card">
    <form action="{{route('admin.setting.save')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card-body pb-3 p-3">
        <div class="row">

          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Shop Name <span class="text-danger">*</span></label>
              <input type="text" name="shop_name"
                value="{{isset($generalsetting->shop_name)?$generalsetting->shop_name:''}}" class="form-control"
                placeholder="Shop Name" required>
            </div>
            @error('shop_name') <div class="text text-danger">{{$message}}</div>@enderror
          </div>

          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Email</label>
              <input type="email" name="email" value="{{isset($generalsetting->email)?$generalsetting->email:''}}"
                class="form-control" placeholder="Email">
            </div>
            @error('email') <div class="text text-danger">{{$message}}</div>@enderror
          </div>

          {{-- <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Contact</label>
              <input type="text" name="contact" value="{{isset($generalsetting->contact)?$generalsetting->contact:''}}"
                class="form-control" placeholder="Contact">
            </div>
            @error('contact') <div class="text text-danger">{{$message}}</div>@enderror
          </div> --}}

          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Address</label>
              <input type="text" name="address" value="{{isset($generalsetting->address)?$generalsetting->address:''}}"
                class="form-control" placeholder="Address">
            </div>
            @error('address') <div class="text text-danger">{{$message}}</div>@enderror
          </div>

          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Status</label>
              <select name="status" class="form-control">
                @if(isset($generalsetting->status) && $generalsetting->status == 'A')
                <option value="A" selected>Active</option>
                <option value="I">Inactive</option>
                @elseif(isset($generalsetting->status) && $generalsetting->status == 'I')
                <option value="A">Active</option>
                <option value="I" selected>Inactive</option>
                @else
                <option value="A" selected>Active</option>
                <option value="I">Inactive</option>
                @endif
              </select>
            </div>
          </div>

          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Notification</label>
              <select name="notification" class="form-control">
                @if(isset($generalsetting->notification) && $generalsetting->notification == 'A')
                <option value="A" selected>Active</option>
                <option value="I">Inactive</option>
                @elseif(isset($generalsetting->notification) && $generalsetting->notification == 'I')
                <option value="A">Active</option>
                <option value="I" selected>Inactive</option>
                @else
                <option value="A">Active</option>
                <option value="I" selected>Inactive</option>
                @endif
              </select>
            </div>
          </div>

         

          <div class="col-12 col-md-6">
            <div class="col-12">
              <div class="col-12  mb-3 form-group">
                <label for="" class="form-label">Social Links</label>
                <div class="input-group mb-2">
                  <span class="input-group-text" id="facebook1"><i class="fa-brands fa-facebook-f"></i></span>
                  <input type="text" name="facebook"
                    value="{{isset($generalsetting->facebook)?$generalsetting->facebook:''}}" class="form-control"
                    placeholder="Facebook" aria-label="Facebook" aria-describedby="facebook1">
                </div>

                <div class="input-group mb-2">
                  <span class="input-group-text" id="instagram1"><i class="fa-brands fa-instagram"></i></span>
                  <input type="text" name="instagram"
                    value="{{isset($generalsetting->instagram)?$generalsetting->instagram:''}}" class="form-control"
                    placeholder="Instagram" aria-label="instagram" aria-describedby="instagram1">
                </div>

                <div class="input-group mb-2">
                  <span class="input-group-text" id="twitter1"><i class="fa-brands fa-twitter"></i></span>
                  <input type="text" name="twitter"
                    value="{{isset($generalsetting->twitter)?$generalsetting->twitter:''}}" class="form-control"
                    placeholder="Twitter" aria-label="Twitter" aria-describedby="twitter1">
                </div>

              </div>
            </div>

          </div>

          <div class="col-12 col-md-12 mb-3 form-group">
            <label for="" class="form-label">Description</label>
            <textarea name="description" cols="30" rows="5" class="form-control"
              placeholder="Description">{{isset($generalsetting->description)?$generalsetting->description:''}}</textarea>
            @error('description') <div class="text text-danger">{{$message}}</div>@enderror
          </div>


          {{-- <div class="col-12 col-md-6 mb-3 form-group">
            <label for="" class="form-label">Logo</label> <br> --}}
            {{-- <div class="custom-file"> --}}
              {{-- <input type="file" name="shop_logo" id="shopLogo1" class="btn btn-link px-0"> --}}
              {{-- <label class="custom-file-label" for="shopLogo1">Choose logo file</label> --}}
              {{--
            </div> --}}
            {{-- @error('shop_logo') <div class="text text-danger">{{$message}}</div>@enderror
          </div> --}}

          {{-- @if(isset($generalsetting->shop_logo))
          <div class="col-6 mb-3 form-group">
            <label for="" class="form-label">Old Logo</label><br>
            <img src="{{asset('upload/website/'.$generalsetting->shop_logo)}}" alt="shop logo">
          </div> --}}
          {{-- @endif --}}

        {{-- </div> --}}
        {{--Row End--}}

        {{--Row Start--}}
        <div class="row">

          {{--Discount Type--}}
          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3 mt-1">
              <label for="" class="form-label pb-2">Discount Type</label>
              <br>

              @if($generalsetting->discount_type == 'V')
                <input type="radio" class="mx-2" name="discount_price" value="V" checked>Value
                <input type="radio" class="mx-2" name="discount_price" value="P">Percentage
                <input type="radio" class="mx-2" name="discount_price" value="N">None
              @elseif($generalsetting->discount_type == 'P')
                <input type="radio" class="mx-2" name="discount_price" value="V">Value
                <input type="radio" class="mx-2" name="discount_price" value="P" checked>Percentage
                <input type="radio" class="mx-2" name="discount_price" value="N">None
              @else
                <input type="radio" class="mx-2" name="discount_price" value="V">Value
                <input type="radio" class="mx-2" name="discount_price" value="P">Percentage
                <input type="radio" class="mx-2" name="discount_price" value="N" checked>None
              @endif

            </div>
          </div>
          {{--Discount Type--}}

          {{--Discount Value--}}
          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Discount Value</label>
              <input type="text" name="discount_value"
                value="{{isset($generalsetting->discount_value) ? $generalsetting->discount_value : ''}}"
                class="form-control" placeholder="discount value">
            </div>
            @error('discount_value') <div class="text text-danger">{{$message}}</div>@enderror
          </div>
          {{--Discount Value End--}}


          {{--Shipping Status--}}
          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3 mt-1">
              <label for="" class="form-label pb-2">Shipping Status</label>
              <br>
              @if($generalsetting->shipping_status == 'F')

              <input type="radio" class="mx-2" name="Flat" value="F" checked>Flat
              <input type="radio" class="mx-2" name="Flat" value="N">None

              @else
              <input type="radio" class="mx-2" name="Flat" value="F">Flat
              <input type="radio" class="mx-2" name="Flat" value="N" checked>None
              @endif

            </div>
          </div>
          {{--Shipping Status End--}}

          {{--Shipping Charges--}}
          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label">Shipping Charges</label>
              <input type="text" name="shipping_charges"
                value="{{isset($generalsetting->shipping_charges) ? $generalsetting->shipping_charges : ''}}"
                class="form-control" placeholder="shipping charges">
            </div>
            @error('shipping_charges') <div class="text text-danger">{{$message}}</div>@enderror
          </div>
          {{--Shipping Charges End--}}

          {{--Colection Type--}}
          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label pb-2">Order Type</label>
              <br>

              @if($generalsetting->order_collection_type == 'C')
              <input type="checkbox" id="" name="order_collection_type" value="C" class="mx-2" checked> Collection
              @else
              <input type="checkbox" id="" name="order_collection_type" value="C" class="mx-2"> Collection
              @endif

              @if($generalsetting->order_delivery_type == 'D')
              <input type="checkbox" id="" name="order_delivery_type" value="D" class="mx-2" checked> Delivery
              @else
              <input type="checkbox" id="" name="order_delivery_type" value="D" class="mx-2"> Delivery
              @endif

            </div>
          </div>
          {{--Colection Type End--}}

           {{--Order Sound Beep Status--}}
           <div class="col-md-6 col-12 pb-3">
            <div class="mb-3 mt-1">
              <label for="" class="form-label pb-2">Beep Sound Status</label>
              <br>
              @if($generalsetting->beep_status == 'A')

              <input type="radio" class="mx-2" name="Beepsound" value="A" checked>Sound
              <input type="radio" class="mx-2" name="Beepsound" value="I">None

              @else
              <input type="radio" class="mx-2" name="Beepsound" value="A">Sound
              <input type="radio" class="mx-2" name="Beepsound" value="I" checked>None
              @endif

            </div>
          </div>
          {{--Order Sound Beep StatusEnd--}}

          {{--Payment Card--}}
          <div class="col-md-6 col-12 pb-3">
            <div class="mb-3">
              <label for="" class="form-label pb-2">Payment Method</label>
              <br>

              @if($generalsetting->pay_by_card == 'A')
                <input type="checkbox" id="" name="pay_by_card" value="A" class="mx-2" checked> Pay by Card
              @else
                <input type="checkbox" id="" name="pay_by_card" value="A" class="mx-2"> Pay by Card
              @endif

              @if($generalsetting->pay_by_cash == 'A')
                <input type="checkbox" id="" name="cash_on_delivery" value="A" class="mx-2" checked> Cash on Delivery
              @else
                <input type="checkbox" id="" name="cash_on_delivery" value="A" class="mx-2"> Cash on Delivery
              @endif

            </div>
          </div>
          {{--Payment Card End--}}

        </div>
        {{--Row End--}}



        <div>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>


</section>

@endsection

@section('script')

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