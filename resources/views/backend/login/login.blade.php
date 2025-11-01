@extends('backend.login.header')
<!-- Login Section -->
@section('content')

<main>
  <div class="container">
	<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
	  <div class="container">

		<div class="row justify-content-center">
		  <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

			<div class="d-flex justify-content-center py-4">
			  <h3 class="logo d-flex align-items-center w-auto">
				<span class="d-none d-lg-block">{{ ($Shop_Name) ? 'Shop' : 'Shop'}}</span>
			  </h3>
			</div><!-- End Logo -->

			<div class="card mb-3">

			  <!-- Session Msg -->
			  @if(Session::has('msg'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  {{session()->get('msg')}}
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			  @endif
			  <!-- Session Msg End-->

			  <div class="card-body">

				<div class="pt-4 pb-2">
				  <h5 class="card-title text-center pb-0 fs-3 text-black">Your Credentials!</h5>
				  {{-- <p class="text-center small">Enter your email & password to login</p> --}}
				</div>

				<form class="row g-3" action="{{route('admin.checklogin')}}" method="post">
				  @csrf
				  <div class="col-12">
					<label for="yourPhone" class="form-label">Email <span class="text-danger">*</span></label>
					<input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@gmail.com" required autocomplete="off" autofocus="">
					@error('email') <div class="text-danger">{{$message}}</div> @enderror
				  </div>

				  <div class="col-12">
					<label for="yourPassword" class="form-label">Password <span class="text-danger">*</span></label>
					<input type="password" name="password" value="{{ old('password') }}" min="0" max="20" class="form-control" id="yourPassword" placeholder="******" required>
					@error('password') <div class="text-danger">{{$message}}</div> @enderror
				  </div>

				  <div class="col-12">
					<button class="btn btn-primary w-100" type="submit">Login</button>
				  </div>

				  <div class="col-12">
					<!-- <p class="small mb-0">Don't have account? <a href="">Create an account</a></p> -->
					<p class="small mb-0">Goto <a href="{{route('website')}}">Website!</a></p>
				  </div>
				</form>

			  </div>

			</div>
		  </div>
		</div>

	  </div>
	</section>
  </div>
</main><!-- End #main -->

<button id="click">Click</button>
@endsection
@section('script')

<script>
	 $(document).ready(function() {
	
        // auto close all alerts
        setTimeout(function() {
          $(".alert").alert('close');
        }, 5000);
      });
</script>
<!-- <script type="text/javascript">
		function password(){
			let detect = document.getElementById("detect");
			let eyeicon = document.querySelector("#icontarget");
				if(detect.type == 'password'){
					detect.type = "text";
				}else{
					detect.type = "password";
				}
			eyeicon.classList.toggle("fa-eye-slash");
		}
	</script> -->
@endsection