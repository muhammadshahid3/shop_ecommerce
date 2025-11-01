@php
$generalsetting = DB::table('general_settings')->first();
@endphp

<!-- Top Header file -->
@include('backend.main.header')

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <span href="" class="logo d-flex align-items-center">
      {{-- <img src="" alt=""> --}}
      @if(isset($generalsetting->shop_name))
      <a href="{{route('admin.dashboard')}}">
        <span class="d-none d-lg-block ms-5">{{$generalsetting->shop_name}}</span>
      </a>
      @else
      <a href="{{route('admin.dashboard')}}">
        <span class="d-none d-lg-block ms-5">{{$generalsetting->shop_name}}</span>
      </a>
      @endif

    </span>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>

      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <i class="fa-sharp fa-solid fa-circle-user fa-2x"></i>

          <span class="d-none d-md-block dropdown-toggle ps-2"></span>



        </a><!-- End Profile Iamge Icon -->
        @php $admin = auth()->guard('admins')->user(); @endphp

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
<aside id="sidebar" class="sidebar">
  @php
  $route_segment_two = Request::segment(2);
  $route_segment_three = Request::segment(3);
  @endphp
  <ul class="sidebar-nav" id="sidebar-nav">
    <!-- nav-link collapsed -->
    {{-- Dashboard Link --}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " dashboard") ? "nav-link " : "nav-link collapsed " }}"
        href="{{route('admin.dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->

    {{-- Dashboard Link End --}}

    {{-- Category Link End --}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " category") ? 'nav-link' : 'nav-link collapsed' }}"
        data-bs-target="#category-nav" data-bs-toggle="collapse" href="#">
        <i class="fa fa-layer-group nav-icon"></i><span>Category</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="category-nav" class=" {{($route_segment_two == " category") ? 'nav-content show ' : 'nav-content collapse'
        }} "
        data-bs-parent=" #sidebar-nav">
        <li>
          <a href="{{route('admin.category.showcategory')}}" class="{{($route_segment_three == " showcategory")
            ? 'nav-link' : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i>
            <span>List</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.category.add')}}" class="{{($route_segment_three == " addcategory") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>Create</span>
          </a>
        </li>

      </ul>
    </li>
    {{-- Category Link End --}}

    {{-- Product Link End --}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " product") ? 'nav-link' : 'nav-link collapsed' }}"
        data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
        <i class="fa fa-box-open nav-icon"></i><span>Product</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="product-nav" class=" {{($route_segment_two == " product") ? 'nav-content show' : 'nav-content collapse' }} "
        data-bs-parent=" #sidebar-nav">
        <li>
          <a href="{{route('admin.product.showproduct')}}" class="{{($route_segment_three == " showproduct")
            ? 'nav-link' : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>List</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.product.add')}}" class="{{($route_segment_three == " addproduct") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>Create</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.product.featured')}}" class="{{($route_segment_three == " featured") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>Featured</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.product.new-arrivals')}}" class="{{($route_segment_three == " new-arrivals")
            ? 'nav-link' : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>New Arrivals</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.product.top-sellers')}}" class="{{($route_segment_three == " top-sellers")
            ? 'nav-link' : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>Top Sellers</span>
          </a>
        </li>
      </ul>
    </li>
    {{-- Product Link End --}}

    {{--Customer Link Active--}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " customer") ? 'nav-link' : 'nav-link collapsed' }}"
        data-bs-target="#customer-nav" data-bs-toggle="collapse" href="#">
        <i class="nav-icon fas fa-users"></i><span>Customer</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="customer-nav" class=" {{($route_segment_two == " customer") ? 'nav-content show' : 'nav-content collapse'
        }} "
        data-bs-parent=" #sidebar-nav">
        <li>
          <a href="{{route('admin.customer.show')}}" class="{{($route_segment_three == " show") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>List</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.customer.add')}}" class="{{($route_segment_three == " add") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>Create</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="{{($route_segment_three == " rating") ? "nav-link " : "nav-link collapsed " }}"
            href="{{route('admin.customer.rating')}}">
            <i class="bi bi-circle"></i>
            <span>Rating</span>
          </a>
        </li>

      </ul>
    </li>
    {{--Customer Link Active End--}}

    {{--Coupon Link Active--}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " coupon") ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#coupon-nav"
        data-bs-toggle="collapse" href="#">
        <i class="fa fa-gift"></i><span>Coupon</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="coupon-nav" class="{{($route_segment_two == " coupon") ? 'nav-content show' : 'nav-content collapse' }}"
        data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('admin.coupon.allcoupons')}}" class="{{($route_segment_three == " allcoupons") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>List</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.coupon.addcoupon')}}" class="{{($route_segment_three == " addcoupon") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>Create</span>
          </a>
        </li>

      </ul>
    </li>
    {{--Coupon Link Active End--}}

    {{--Order Link Active--}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " order") ? "nav-link " : "nav-link collapsed " }}"
        href="{{route('admin.order')}}">
        <i class="fa fa-box-open nav-icon"></i>
        <span>Orders</span>
      </a>
    </li>
    {{--Order Link Active End--}}

    {{--Banner Link Active--}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " banner") ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#banner-nav"
        data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Banner</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="banner-nav" class="{{($route_segment_two == " banner") ? 'nav-content show' : 'nav-content collapse' }}"
        data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('admin.banner.showbanners')}}" class="{{($route_segment_three == " showbanners") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>List</span>
          </a>
        </li>
        <li>
          <a href="{{route('admin.banner.addbanner')}}" class="{{($route_segment_three == " addbanner") ? 'nav-link'
            : 'nav-link collapsed' }}">
            <i class="bi bi-circle"></i><span>Create</span>
          </a>
        </li>

      </ul>
    </li>
    {{--Banner Link Active End--}}


    {{--FAQ Link Active--}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " faqs") ? "nav-link " : "nav-link collapsed " }}"
        href="{{route('admin.faqs')}}">
        <i class="fa-solid fa-circle-question"></i>
        <span>FAQs</span>
      </a>
    </li>
    {{--FAQ Link Active End--}}

    {{--Blog Link Active--}}
    <li class="nav-item">
      <a class="{{($route_segment_two == " blog") ? "nav-link " : "nav-link collapsed " }}"
        href="{{route('admin.blog')}}">
        <i class="fa fa-note-sticky"></i>
        <span>Blog</span>
      </a>
    </li>
    {{--Blog Link Active End--}}

    {{--Stock Management Link Active--}}

    <li class="nav-item">
      <a class="{{($route_segment_two == " product-stock") ? "nav-link " : "nav-link collapsed " }}"
        href="{{route('admin.product-stock')}}">
        <i class="fa fa-box-open"></i>
        <span>Stock</span>
      </a>
    </li>

    {{--Stock Management Link Active End--}}




    {{--Contact Us Link Active--}}
    <li class="nav-item">
      <a href="{{route('admin.contact.showcontact')}}" class="{{($route_segment_three == " showcontact") ? 'nav-link'
        : 'nav-link collapsed' }}">
        <i class="fas fa-envelope nav-icon"></i>
        <span>Contact Us</span>
      </a>
    </li>
    {{--Contact Us Link Active End--}}

    {{-- Privacy Policy Link --}}
    <li class="nav-item">
      <a href="{{route('admin.privacy-policy')}}" class="{{($route_segment_two == " privacy-policy") ? 'nav-link'
        : 'nav-link collapsed' }}">
        <i class="fas fa-shield-alt nav-icon"></i>
        <span>Privacy Policy</span>
      </a>
    </li>
    {{-- Privacy Policy Link End --}}

    <hr>
    {{-- Specialties Link --}}
    <li class="nav-item">
      <a href="{{route('admin.profile')}}" class="{{($route_segment_two == " profile") ? 'nav-link'
        : 'nav-link collapsed' }}">
        <i class="fa fa-user"></i>
        <span>Profile</span>
      </a>
    </li>
    {{-- Specialties Link End --}}

    {{-- General Setting Link --}}
    <li class="nav-item">
      <a href="{{route('admin.setting')}}" class="{{($route_segment_two == " setting") ? 'nav-link'
        : 'nav-link collapsed' }}">
        <i class="fa fa-gear"></i>
        <span>General Settings</span>
      </a>
    </li>
    {{-- General Setting Link End --}}

    <li class="nav-item">
      <a class="nav-link collapsed " href="{{route('admin.logout')}}">
        <i class="fa fa-sign-out"></i>
        <span>logout</span>
      </a>
    </li>
    {{-- logout Link End --}}
  </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

  @yield('content')

</main><!-- End #main -->



<!-- Footer file -->
@include('backend.main.footer')