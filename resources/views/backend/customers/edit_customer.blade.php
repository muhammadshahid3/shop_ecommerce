@extends('Backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Edit Customer
        <span class="float-right">
            <a href="{{route('admin.customer.show')}}"><button class="btn btn-primary">
                 <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

<div class="pb-5 pt-2">
    <div class="card">
                <!-- form div -->
                @if(!empty($customer_data))
                @foreach ($customer_data as  $customer_item)
                <form action="{{route('admin.customer.show.updatecustomer',$customer_item->id)}}" method="post">
                    @csrf
                    <div class="card-body pb-3 p-3">
                    <div class="row">

                 <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                                <input type="text"name="username" class="form-control" value="{{old('username',$customer_item->username)}}" placeholder="User Name">
                                <label for="" class="form-label">User Name</label>
                                @error('username') <div class="text-danger">{{$message}}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                                <input type="email" name="email" class="form-control" value="{{old('email',$customer_item->email)}}" placeholder="Email">
                                <label for="" class="form-label">Email</label>
                                @error('email') <div class="text-danger">{{$message}}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                                <input type="text" name="phone_number" class="form-control" value="{{old('phone_number',$customer_item->phone_number)}}" placeholder="Phone Number">
                                <label for="" class="form-label">Phone_Number</label>
                                @error('phone_number') <div class="text-danger">{{$message}}</div>@enderror
                            </div>
                        </div>

                    </div>

                    <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

                    </div>
                    </form>
                @endforeach
                @endif
          
        </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
@endsection

