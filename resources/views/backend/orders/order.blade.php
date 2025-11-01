<!-- include Order Header -->
@include("backend.orders.order_header")

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <span href="" class="logo d-flex align-items-center">
                <img src="" alt="">
                <span class="d-none d-lg-block ms-5"><a href="{{route('admin.dashboard')}}">{{isset($generalsetting->shop_name)?$generalsetting->shop_name:'Shop'}}</a></span>
            </span>
           
        </div><!-- End Logo -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="fa-sharp fa-solid fa-circle-user fa-2x"></i>

                        <span class="d-none d-md-block dropdown-toggle ps-2"></span>



                    </a><!-- End Profile Iamge Icon -->

                    @php  $admin = auth()->guard('admins')->user(); @endphp
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6 class="d-none d-md-block dropdown-toggle ps-2">
                            {{($admin) ? $admin->email : ''}}
                            </h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider" style="color:#eee;">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{route('admin.profile')}}">
                                <i class="bi bi-person"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" style="color:#eee;">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{route('admin.setting')}}">
                                <i class="bi bi-gear"></i>
                                <span>General Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" style="color:#eee;">
                        </li>
                        <li>
                            <!-- <hr class="dropdown-divider"> -->
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{route('admin.logout')}}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>logout</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->


    <main id="main" class="main">

       @include('backend.orders.order_detail_modal')
  
       <div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
        <h3 class="text-primary">Order List</h3>
        @if(isset($order_beep_status) && $order_beep_status > 0 )
        <i class="fa fa-volume-up btn btn-primary p-2" id="volume-mute" onclick="soundOff()"></i>
        @else
            <i class="fa fa-volume-mute btn btn-primary p-2" id="volume-mute"></i>
        @endif
     
    </div>
        {{--Order Show--}}
        <input type="hidden" id="beep_status_count" value="">
        <input type="hidden" id="beep_status" value="{{$generalsetting->beep_status}}">
      
        <button class="btn btn-danger btn-sm checkbox_delete mb-3"> <i class="fa fa-trash"></i> </button>
        <table class="table table-bordered data-table text-center bg-white w-100">
            <thead>
                <tr>
                    <th scope="col" class="text-center"><input type="checkbox" id="checkAll"></th>
                    <th scope="col" class="text-center">Order No</th>
                    <th scope="col" class="text-center">Customer</th>
                    <th scope="col" class="text-center">Customer Address</th>
                    <th scope="col" class="text-center">Order Type</th>
                    <th scope="col" class="text-center">Payment Type</th>
                    <th scope="col" class="text-center">Order Total</th>
                    <th scope="col" class="text-center">Order Status</th>
                    <th scope="col" class="text-center">Order Cancel</th>
                    <th scope="col" class="text-center">Order Date</th>
                    <th width="" class="text-center">Action</th>
                    <!-- <th scope="col" class="text-center">Prints</th> -->

                </tr>
            </thead>

            <tbody>

                </tbody>
        </table>


    </main><!-- End #main -->

    <!-- include Order Footer  -->

    @include("backend.orders.order_footer")