@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Add Customer
        <span class="float-right">
            <a href="{{route('admin.customer.show')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--Add Customer--}}

<div class="pb-5 pt-2">
    <div class="card">
        <!-- form -->
        <form action="{{route('admin.customer.store')}}" method="post">
            @csrf
            <div class="card-body pb-3 p-3">
                <div class="row">

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="username" value="{{old('username')}}" class="form-control"
                                placeholder="username" required>
                            <label for="" class="form-label">Username <span style="color:red">*</span></label>
                        </div>
                        @error('username')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control"
                                placeholder="email" required>
                            <label for="" class="form-label">Email <span style="color:red">*</span></label>
                        </div>
                        @error('email')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="password" name="password" value="{{old('password')}}" class="form-control"
                                placeholder="password" required>
                            <label for="" class="form-label">Password <span style="color:red">*</span></label>
                        </div>
                        @error('password')
                        <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="phone_number" value="{{old('phone_number')}}" class="form-control"
                                placeholder="phone number" required>
                            <label for="" class="form-label">Phone Number <span style="color:red">*</span></label>

                        </div>
                        @error('phone_number')
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


@endsection

<!-- @section('script')
<script type="text/javascript">
    function password() {
        let detect = document.getElementById("detect");
        let eyeicon = document.querySelector("#icontarget");
        if (detect.type == 'password') {
            detect.type = "text";
        } else {
            detect.type = "password";
        }
        eyeicon.classList.toggle("fa-eye-slash");
    }
</script>
@endsection -->