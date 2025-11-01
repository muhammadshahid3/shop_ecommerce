@extends('backend.main.main')

@section('content')
<main id="" class="main pb-5">

    <div class="pagetitle pb-5">
        <h1>Profile</h1>

    </div>
    {{--Admin Profile Details --}}

            @if(isset($admin_details))
            @foreach ($admin_details as $admin_details_data )
            
            <section class="section profile">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card p-2">
                            <div class="card-body  profile-card  pt-4 d-flex flex-column align-items-center">
                                <i class="fa-sharp fa-solid fa-circle-user fa-5x " style="color:#012970;"></i>
                                <h5 class="my-2 ">{{$admin_details_data->username}}</h5>
                                <h5 class="my-3">{{$admin_details_data->email}}</h5>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">

                        <div class="card">
                            <div class="card-body pt-3">
                                <!-- Bordered Tabs -->
                                <ul class="nav nav-tabs nav-tabs-bordered">

                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#profile-overview">Overview</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                            Profile</button>
                                    </li>

                                    <!-- <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#profile-change-password">Change Password</button>
                                    </li> -->

                                </ul>
                                <div class="tab-content pt-2">

                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                        <h5 class="card-title">Profile Details</h5>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                            <div class="col-lg-9 col-md-8">{{$admin_details_data->username}}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Email</div>
                                            <div class="col-lg-9 col-md-8">{{$admin_details_data->email}}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Phone</div>
                                            <div class="col-lg-9 col-md-8">{{$admin_details_data->phone_number}}</div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->
                                        <form id="edit_form" action="" method="post">
                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="username" type="text" class="form-control" id="username"
                                                        value="{{old('username',$admin_details_data->username)}}">
                                                    <input type="hidden" name="admin_id" id="admin_id"
                                                        value="{{$admin_details_data->id}}">
                                                    <span class="error username_err text-danger"></span>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="email" type="email" class="form-control" id="email"
                                                        value="{{old('email',$admin_details_data->email)}}">
                                                    <span class="error email_err text-danger"></span>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="phone_number" type="text" class="form-control" id="phone_number"
                                                        value="{{old('phone_number',$admin_details_data->phone_number)}}">
                                                    <span class="error phone_number_err text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary" id="btn">Save Changes</button>
                                            </div>
                                        </form>


                                    </div>

                                    <div class="tab-pane fade pt-3" id="profile-settings">

                                    </div>

                                    <div class="tab-pane fade pt-3" id="profile-change-password">
                                        <!-- Change Password Form -->
                                        <form id="password_submit" action="" method="post">
                                    
                                            <div class="row mb-3">
                                                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="apassword" value="" type="password" class="form-control"
                                                        id="current_password">
                                                    <span class="err current_password_err text-danger"></span>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="newpassword" type="password" class="form-control"
                                                        id="new_password">
                                                    <span class=" err  new_password_err text-danger"></span>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                                    Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="renewpassword" type="password" class="form-control"
                                                        id="renew_password">
                                                    <span class="err  renew_password_err text-danger"></span>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                        </form><!-- End Change Password Form -->


                                    </div>

                                </div><!-- End Bordered Tabs -->

                            </div>
                        </div>

                    </div>
                </div>
            </section>
            @endforeach
            @else
                <h5>Example@gmail.com</h5>
                <h5>03xxx-xxx-xxx</h5>

            @endif
 
    {{--Admin Profile Details End--}}


</main><!-- End #main -->

@endsection

@section('script')

<script>

$(document).ready(function () {
       
       //  Edit profile ajax
       $("#edit_form").submit(function (event) {
           event.preventDefault();
           const token = $("meta[name='csrf-token']").attr("content");
           var username = document.getElementById('username').value;
           var  email = document.getElementById('email').value;
           var phone_number = document.getElementById('phone_number').value;
           var id = document.getElementById('admin_id').value;
           $.ajax({
               'url': '{{route('admin.update-profile')}}',
               'method': 'post',
               'dataType': 'json',
               'data': { 'username': username, 'email': email, 'phone_number' : phone_number , 'id': id, '_token': token },
               success: function (data) {
                   if (data.error) {
                       $(".error").text('');
                       PrintErrorsMsg(data.error);
                   } else {
                       window.location.reload();
                   }
               },
               error: function (err) {
                
                   console.log(err);
               }
           });
       });

       // PrintErrorsMsg Function
       function PrintErrorsMsg(msg) {
           $.each(msg, function (key, value) {
               $("." + key + "_err").text(value);
               // console.log(key);
           });

       }
         //  Edit profile ajax End  

   })

//  {{-- Session Msg --}}

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





 
      
 


