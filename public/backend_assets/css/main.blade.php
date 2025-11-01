<!-- Header File -->
@include('backend.admin.layout.header')

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="" alt="">
        <span class="d-none d-lg-block">Hospital</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            @php 
               $admin_details = auth()->guard('admins')->user();
               if(!empty($admin_details)){
                echo '<span class="d-none d-md-block dropdown-toggle ps-2">'.$admin_details->aname.'</span>';
               }
              @endphp
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            {{-- Logout Form --}}
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">@csrf</form>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @php  $segment =  Request::segment(2);  @endphp
 <!-- Dashboard Link  -->
      <li class="nav-item">
        <a class="{{($segment == 'dashboard') ? 'nav-link' : 'nav-link collapsed'}}" href="{{route('admin.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
<!-- Dashboard Link End  -->
     

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="icons-bootstrap.html">
              <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-remix.html">
              <i class="bi bi-circle"></i><span>Remix Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-boxicons.html">
              <i class="bi bi-circle"></i><span>Boxicons</span>
            </a>
          </li>
        </ul>
      </li> -->

  <!-- Doctor Link  -->
      <li class="nav-item">
        <a class="{{($segment == 'doctors') ? 'nav-link' : 'nav-link collapsed'}}" href="{{route('admin.doctors')}}">
        <i class="fa fa-briefcase-medical"></i>
          <span>Doctors</span>
        </a>
      </li>
  <!-- Doctor Link End -->
   <!-- Specialties Link  -->
   <li class="nav-item">
        <a class="{{($segment == 'specialties') ? 'nav-link' : 'nav-link collapsed'}}" href="{{route('admin.specialties')}}">
        <i class="fa fa-user-doctor"></i>
          <span>Specialties</span>
        </a>
      </li>
   <!-- Specialties Link End -->
      <!-- Schedule Link  -->
   <li class="nav-item">
        <a class="{{($segment == 'specialties') ? 'nav-link' : 'nav-link collapsed'}}" href="{{route('admin.specialties')}}">
        <i class="fa fa-user-doctor"></i>
          <span>Schedule</span>
        </a>
      </li>
   <!-- Schedule Link End -->

   <!-- logout Link  -->
   <li class="nav-item">
      <a class="nav-link collapsed" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i>
          <span>logout</span>
        </a>
      </li>
  <!-- logout Link End -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
          @yield('content')
  
        </div><!-- End Right side columns -->

      </div>
    </section>
  </main><!-- End #main -->

<!-- Footer File -->
 @include('backend.admin.layout.footer')