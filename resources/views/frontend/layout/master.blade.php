<!doctype html>
<html class="no-js" lang="eng">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{isset($page_title) ? $page_title : 'Shop | Home'}}</title>
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{--
  <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}

  <!-- Place favicon.ico in the root directory -->
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend_assets/img/logo/favicon.png')}}">
  <!-- CSS here -->
  <link rel="stylesheet" href="{{asset('frontend_assets/css/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/animate.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/swiper-bundle.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/slick.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/magnific-popup.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/font-awesome-pro.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/flaticon_shofy.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/spacing.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/custom.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/main.css')}}">
  <link rel="stylesheet" href="{{asset('frontend_assets/css/pagination.css')}}">


  {{-- summernote editor --}}
  <link rel="stylesheet" href="{{asset('frontend_assets/Editor/summernote-bs4.min.css')}}">

  @yield('css_styles')

</head>

<body>

  <!-- uncomment following code to use summer note functionality  -->
  @if(auth()->guard('admins')->user())
    <button type="button" class="btn btn-dark" id="add-summernote-btn"
    style="position:fixed; z-index:100; right:0; top:20px; display:block;" onclick="allowSummernoteBtns()"><i
      class="fa fa-pencil"></i></button>
    <button type="button" class="btn btn-dark" id="remove-summernote-btn"
    style="position:fixed; z-index:100; right:0; top:60px; display:none;" onclick="removeSummernote()"><i
      class="fa fa-trash"></i></button>
  @endif

  <!-- back to top start -->
  <div class="back-to-top-wrapper">
    <button id="back_to_top" type="button" class="back-to-top-btn">
      <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
          stroke-linejoin="round" />
      </svg>
    </button>
  </div>
  <!-- back to top end -->

  <!-- offcanvas area start -->
  <div class="offcanvas__area offcanvas__radius">
    <div class="offcanvas__wrapper">
      <div class="offcanvas__close">
        <button class="offcanvas__close-btn offcanvas-close-btn">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="offcanvas__content">
        <div class="offcanvas__top mb-70 d-flex justify-content-between align-items-center">
          <div class="offcanvas__logo logo">
            <a href="{{route('website')}}">
           
              @if(isset($cms_texts))
                @foreach ($cms_texts as $cms_text_list)
                  @if($cms_text_list->tag === 'header_logo')
                    <a href="{{route('website')}}"  >
                      <img src="{{asset('upload/website/'.$cms_text_list->value)}}"  alt="logo">
                    </a>
                  @endif
                @endforeach
                @endif
            </a>
          </div>
        </div>
        <div class="offcanvas__category pb-40">
          <button class="tp-offcanvas-category-toggle">
            <i class="fa-solid fa-bars"></i>
            All Categories
          </button>
          <div class="tp-category-mobile-menu">

          </div>
        </div>
        <div class="tp-main-menu-mobile fix d-lg-none mb-40"></div>

        <div class="offcanvas__contact align-items-center d-none">
          <div class="offcanvas__contact-icon mr-20">
            <span>
              <img src="{{asset('frontend_assets/img/icon/contact.png')}}" alt="">
            </span>
          </div>
          <div class="offcanvas__contact-content">
            <h3 class="offcanvas__contact-title">
              <a href="tel:098-852-987">004524865</a>
            </h3>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="body-overlay"></div>
  <!-- offcanvas area end -->

  <!-- mobile menu area start -->
  <div id="tp-bottom-menu-sticky" class="tp-mobile-menu d-lg-none">
    <div class="container">
      <div class="row row-cols-5">
        <div class="col">
          <div class="tp-mobile-item text-center">
            <a href="{{route('website')}}" class="tp-mobile-item-btn">
              <i class="flaticon-store"></i>
              <span>Store</span>
            </a>
          </div>
        </div>
        <div class="col">
          <div class="tp-mobile-item text-center">
            <button class="tp-mobile-item-btn tp-search-open-btn">
              {{-- <i class="flaticon-search-1 mb-2"></i> --}}
              <svg class="mb-2" width="24" height="24" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M19 19L14.65 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
              <span>Search</span>
            </button>
          </div>
        </div>
        <div class="col">
          <div class="tp-mobile-item text-center">
            <a href="{{route('show.basket')}}" class="tp-mobile-item-btn">
              <span class="mb-2">
                {{-- <svg width="24" height="26" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M6.48626 20.5H14.8341C17.9004 20.5 20.2528 19.3924 19.5847 14.9348L18.8066 8.89359C18.3947 6.66934 16.976 5.81808 15.7311 5.81808H5.55262C4.28946 5.81808 2.95308 6.73341 2.4771 8.89359L1.69907 14.9348C1.13157 18.889 3.4199 20.5 6.48626 20.5Z"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  <path
                    d="M6.34902 5.5984C6.34902 3.21232 8.28331 1.27803 10.6694 1.27803V1.27803C11.8184 1.27316 12.922 1.72619 13.7362 2.53695C14.5504 3.3477 15.0081 4.44939 15.0081 5.5984V5.5984"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M7.70365 10.1018H7.74942" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M13.5343 10.1018H13.5801" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg> --}}
                <svg width="26" height="28" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.34706 4.53799L3.85961 10.6239C3.89701 11.0923 4.28036 11.4436 4.74871 11.4436H4.75212H14.0265H14.0282C14.4711 11.4436 14.8493 11.1144 14.9122 10.6774L15.7197 5.11162C15.7384 4.97924 15.7053 4.84687 15.6245 4.73995C15.5446 4.63218 15.4273 4.5626 15.2947 4.54393C15.1171 4.55072 7.74498 4.54054 3.34706 4.53799ZM4.74722 12.7162C3.62777 12.7162 2.68001 11.8438 2.58906 10.728L1.81046 1.4837L0.529505 1.26308C0.181854 1.20198 -0.0501969 0.873587 0.00930333 0.526523C0.0705036 0.17946 0.406255 -0.0462578 0.746256 0.00805037L2.51426 0.313534C2.79901 0.363599 3.01576 0.5995 3.04042 0.888012L3.24017 3.26484C15.3748 3.26993 15.4139 3.27587 15.4726 3.28266C15.946 3.3514 16.3625 3.59833 16.6464 3.97849C16.9303 4.35779 17.0493 4.82535 16.9813 5.29376L16.1747 10.8586C16.0225 11.9177 15.1011 12.7162 14.0301 12.7162H14.0259H4.75402H4.74722Z"
                    fill="currentColor" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.6629 7.67446H10.3067C9.95394 7.67446 9.66919 7.38934 9.66919 7.03804C9.66919 6.68673 9.95394 6.40161 10.3067 6.40161H12.6629C13.0148 6.40161 13.3004 6.68673 13.3004 7.03804C13.3004 7.38934 13.0148 7.67446 12.6629 7.67446Z"
                    fill="currentColor" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.38171 15.0212C4.63756 15.0212 4.84411 15.2278 4.84411 15.4836C4.84411 15.7395 4.63756 15.9469 4.38171 15.9469C4.12501 15.9469 3.91846 15.7395 3.91846 15.4836C3.91846 15.2278 4.12501 15.0212 4.38171 15.0212Z"
                    fill="currentColor" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.38082 15.3091C4.28477 15.3091 4.20657 15.3873 4.20657 15.4833C4.20657 15.6763 4.55592 15.6763 4.55592 15.4833C4.55592 15.3873 4.47687 15.3091 4.38082 15.3091ZM4.38067 16.5815C3.77376 16.5815 3.28076 16.0884 3.28076 15.4826C3.28076 14.8767 3.77376 14.3845 4.38067 14.3845C4.98757 14.3845 5.48142 14.8767 5.48142 15.4826C5.48142 16.0884 4.98757 16.5815 4.38067 16.5815Z"
                    fill="currentColor" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M13.9701 15.0212C14.2259 15.0212 14.4333 15.2278 14.4333 15.4836C14.4333 15.7395 14.2259 15.9469 13.9701 15.9469C13.7134 15.9469 13.5068 15.7395 13.5068 15.4836C13.5068 15.2278 13.7134 15.0212 13.9701 15.0212Z"
                    fill="currentColor" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M13.9692 15.3092C13.874 15.3092 13.7958 15.3874 13.7958 15.4835C13.7966 15.6781 14.1451 15.6764 14.1443 15.4835C14.1443 15.3874 14.0652 15.3092 13.9692 15.3092ZM13.969 16.5815C13.3621 16.5815 12.8691 16.0884 12.8691 15.4826C12.8691 14.8767 13.3621 14.3845 13.969 14.3845C14.5768 14.3845 15.0706 14.8767 15.0706 15.4826C15.0706 16.0884 14.5768 16.5815 13.969 16.5815Z"
                    fill="currentColor" />
                </svg>
              </span>
              {{-- <i class="flaticon-cart"></i> --}}
              <span>Cart</span>
            </a>
          </div>
        </div>
        <div class="col">
          <div class="tp-mobile-item text-center">
            @if(isset($customer_info))
        <a href="{{route('customer.profile')}}" class="tp-mobile-item-btn">
          <i class="flaticon-user"></i> <span>Account</span>
        </a>
      @else
    <a href="{{route('customer.login')}}" class="tp-mobile-item-btn">
      <i class="flaticon-user"></i> <span>Login</span>
    </a>
  @endif
          </div>
        </div>
        <div class="col">
          <div class="tp-mobile-item text-center">
            <button class="tp-mobile-item-btn tp-offcanvas-open-btn">
              <i class="flaticon-menu-1"></i>
              <span>Menu</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- mobile menu area end -->

  <!-- search area start -->
  <section class="tp-search-area">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="tp-search-form">
            <div class="tp-search-close text-center mb-20">
              <button class="tp-search-close-btn tp-search-close-btn"></button>
            </div>
            <form action="#">
              <div class="tp-search-input mb-10">
                <input type="text" class="search" name="search" placeholder="Search for product...">
                {{--Searched Product List Start--}}
                <div class="search_list bg-white"
                  style="position:absolute; top: 90%;  min-width:100%; max-height:auto; z-index:9999;"></div>
                {{--Searched Product List End--}}

              </div>
              <!-- <button type="submit"><i class="flaticon-search-1"></i></button> -->
          </div>

          {{-- <div class="tp-search-category">
            <span>Search by : </span>
            <a href="#">Men, </a>
            <a href="#">Women, </a>
            <a href="#">Children, </a>
            <a href="#">Shirt, </a>
            <a href="#">Demin</a>
          </div> --}}
          </form>
        </div>

      </div>

    </div>
    </div>
  </section>
  <!-- search area end -->

  <!-- header area start -->
  <header>
    <div class="tp-header-area p-relative z-index-11">

      <!-- header main start -->
      <div class="tp-header-main tp-header-sticky">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-xl-2 col-lg-2 col-md-4 col-6">
              <div class="logo">

              @if(isset($cms_texts))
                @foreach ($cms_texts as $cms_text_list)
                  @if($cms_text_list->tag === 'header_logo')
                    <input type="hidden" value="{{$cms_text_list->tag}}" name="" id="header_logo_id">
                    <input type="hidden" name="" value="{{$cms_text_list->value}}" id="logo_path" >
                    <a href="{{route('website')}}" id="summernote_cms_texts_logo">
                      <img src="{{asset('upload/website/'.$cms_text_list->value)}}"  alt="logo">
                    </a>
                  @endif
                @endforeach
        
              @endif

              </div>
            </div>

            <div class="col-xl-6 col-lg-7 d-none d-lg-block">
              <div class="tp-header-search pl-30 pr-30">
                {{-- <form action=""> --}}
                  <div class="tp-header-search-wrapper d-flex align-items-center">

                    <div class="tp-header-search-box">
                      <input type="text" id="search" name="search" placeholder="Search for Products..." required
                        autocomplete="off">
                    </div>

                    <div class="tp-header-search-btn">
                      <div class="search-btn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          <path d="M19 19L14.65 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        </svg>
                      </div>
                    </div>

                    {{--Searched Product List Start--}}
                    <div class="search_list bg-white"
                      style="position:absolute; top: 100%;  width:100%; max-height:auto; z-index:9999;"></div>
                    {{--Searched Product List End--}}

                  </div>
                  {{--
                </form> --}}

              </div>
            </div>


            <div class="col-xl-4 col-lg-3 col-md-8 col-6">
              <div class="tp-header-main-right d-flex align-items-center justify-content-end">
                <div class="tp-header-login d-none d-lg-block">

                  <div class="d-flex align-items-center">

                    @if (auth()->guard('admins')->user())
                      <a href="{{route('admin.dashboard')}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        title="Admin Profile">
                      @elseif (isset($customer_info))
                            <a href="{{route('customer.profile')}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Customer Profile">
                        @else
                      <a href="{{route('customer.login')}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        title="Sign In">
                     @endif
                          <div class="tp-header-login-icon">
                            <span>
                              <svg width="17" height="21" viewBox="0 0 17 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.57894" cy="5.77803" r="4.77803" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.00002 17.2014C0.998732 16.8655 1.07385 16.5337 1.2197 16.2311C1.67736 15.3158 2.96798 14.8307 4.03892 14.611C4.81128 14.4462 5.59431 14.336 6.38217 14.2815C7.84084 14.1533 9.30793 14.1533 10.7666 14.2815C11.5544 14.3367 12.3374 14.4468 13.1099 14.611C14.1808 14.8307 15.4714 15.27 15.9291 16.2311C16.2224 16.8479 16.2224 17.564 15.9291 18.1808C15.4714 19.1419 14.1808 19.5812 13.1099 19.7918C12.3384 19.9634 11.5551 20.0766 10.7666 20.1304C9.57937 20.2311 8.38659 20.2494 7.19681 20.1854C6.92221 20.1854 6.65677 20.1854 6.38217 20.1304C5.59663 20.0773 4.81632 19.9641 4.04807 19.7918C2.96798 19.5812 1.68652 19.1419 1.2197 18.1808C1.0746 17.8747 0.999552 17.5401 1.00002 17.2014Z"
                                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round" />
                              </svg>
                            </span>
                          </div>
                        </a>

                        <div class="tp-header-login-content d-none d-xl-block">
                          @if (auth()->guard('admins')->user())
                <span>Hello, Admin</span>
                <a href="{{route('admin.dashboard')}}">
                <h5 class="tp-header-login-title">{{ucwords(auth()->guard('admins')->user()->username)}}
                </h5>
                </a>
              @elseif (isset($customer_info))
          <span>Hello, Customer</span>
          <a href="{{route('customer.profile')}}">
          <h5 class="tp-header-login-title">{{ucwords($customer_info->username)}}</h5>
          </a>
        @else
        <span>Hello, Sign in</span>
        <a href="{{route('customer.login')}}">
        <h5 class="tp-header-login-title">Your Account</h5>
        </a>
      @endif
                          {{-- <div class="dropdown"> --}}
                            {{-- <a href="javascript:void(0);" class="tp-header-login-title dropdown-toggle"
                              id="customerdropdown" data-bs-toggle="dropdown" aria-expanded="true">
                              John Doe
                            </a>
                            <ul class="dropdown-menu mt-2 py-0" aria-labelledby="customerdropdown">
                              <li><a class="dropdown-item" href="#"><small>Profile</small></a></li>
                              <li>
                                <hr class="dropdown-divider my-0">
                              </li>
                              <li><a class="dropdown-item" href="index.php"><small>Logout</small></a></li>
                            </ul> --}}
                            {{--
                          </div> --}}

                        </div>
                  </div>
                </div>
                <div class="tp-header-action d-flex align-items-center ml-50">
                  {{-- <div class="tp-header-action-item d-none d-lg-block" style="cursor:pointer"> --}}
                  <div class="tp-header-action-item" style="cursor:pointer">
                    <a onclick="window.location='{{route("show.wishlist")}}'" class="tp-header-action-btn"
                      data-bs-toggle="tooltip" data-bs-placement="bottom" title="Favourite Items">
                      <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M11.239 18.8538C13.4096 17.5179 15.4289 15.9456 17.2607 14.1652C18.5486 12.8829 19.529 11.3198 20.1269 9.59539C21.2029 6.25031 19.9461 2.42083 16.4289 1.28752C14.5804 0.692435 12.5616 1.03255 11.0039 2.20148C9.44567 1.03398 7.42754 0.693978 5.57894 1.28752C2.06175 2.42083 0.795919 6.25031 1.87187 9.59539C2.46978 11.3198 3.45021 12.8829 4.73806 14.1652C6.56988 15.9456 8.58917 17.5179 10.7598 18.8538L10.9949 19L11.239 18.8538Z"
                          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.26062 5.05302C6.19531 5.39332 5.43839 6.34973 5.3438 7.47501" stroke="currentColor"
                          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <span class="tp-header-action-badge wishlist_items-counter"></span>
                    </a>
                  </div>
                  <div class="tp-header-action-item">
                    <button type="button" class="tp-header-action-btn" data-bs-toggle="tooltip"
                      data-bs-placement="bottom" title="Cart Items"
                      onclick="window.location='{{route("show.basket")}}'">
                      <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M6.48626 20.5H14.8341C17.9004 20.5 20.2528 19.3924 19.5847 14.9348L18.8066 8.89359C18.3947 6.66934 16.976 5.81808 15.7311 5.81808H5.55262C4.28946 5.81808 2.95308 6.73341 2.4771 8.89359L1.69907 14.9348C1.13157 18.889 3.4199 20.5 6.48626 20.5Z"
                          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                          d="M6.34902 5.5984C6.34902 3.21232 8.28331 1.27803 10.6694 1.27803V1.27803C11.8184 1.27316 12.922 1.72619 13.7362 2.53695C14.5504 3.3477 15.0081 4.44939 15.0081 5.5984V5.5984"
                          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.70365 10.1018H7.74942" stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.5343 10.1018H13.5801" stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <span class="tp-header-action-badge basket-items-counter"></span>
                    </button>
                  </div>
                  <div class="tp-header-action-item d-lg-none">
                    <button type="button" class="tp-header-action-btn tp-offcanvas-open-btn">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" viewBox="0 0 30 16">
                        <rect x="10" width="20" height="2" fill="currentColor" />
                        <rect x="5" y="7" width="25" height="2" fill="currentColor" />
                        <rect x="10" y="14" width="20" height="2" fill="currentColor" />
                      </svg>
                    </button>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- header bottom start -->
      <div class="tp-header-bottom tp-header-bottom-border d-none d-lg-block tp-header-border-shadow">
        <div class="container">
          <div class="tp-mega-menu-wrapper p-relative">
            <div class="row align-items-center">

              <div class="col-xl-3 col-lg-3">
                <div class="tp-header-category tp-category-menu tp-header-category-toggle">
                  <button class="tp-category-menu-btn tp-category-menu-toggle">
                    <span>
                      <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M0 1C0 0.447715 0.447715 0 1 0H15C15.5523 0 16 0.447715 16 1C16 1.55228 15.5523 2 15 2H1C0.447715 2 0 1.55228 0 1ZM0 7C0 6.44772 0.447715 6 1 6H17C17.5523 6 18 6.44772 18 7C18 7.55228 17.5523 8 17 8H1C0.447715 8 0 7.55228 0 7ZM1 12C0.447715 12 0 12.4477 0 13C0 13.5523 0.447715 14 1 14H11C11.5523 14 12 13.5523 12 13C12 12.4477 11.5523 12 11 12H1Z"
                          fill="currentColor" />
                      </svg>
                    </span>
                    All Categories
                  </button>
                  <nav class="tp-category-menu-content">
                    <ul>
                      @if(isset($categories))
              @foreach ($categories as $category)
          <li>
          <a href="{{route("category.products", $category->category_slug)}}">
          <span><i class="{{$category->category_icon}} fontawesome-width"></i></span>
          {{$category->category_name}}
          </a>
          </li>
        @endforeach
            @endif
                    </ul>
                  </nav>
                </div>
              </div>

              <div class="col-xl-6 col-lg-6">
                <div class="main-menu menu-style-1">
                  <nav class="tp-main-menu-content">
                    <ul>

                      <li><a href="{{route('website')}}">Home</a></li>
                      <li><a href="{{route('products')}}">Shop</a></li>

                      <li class="has-dropdown has-mega-menu">
                        <a href="#">Products</a>
                        <div class="shop-mega-menu tp-submenu tp-mega-menu">
                          <div class="row">

                            @if (isset($product_list))
                              @foreach ($product_list as $product_list_details)
                                  <div class="col-lg-2">
                                    <div class="shop-mega-menu-list">
                                    <a href="{{route("category.products", $product_list_details->category_slug)}}"
                                    class="shop-mega-menu-title">{{$product_list_details->category_name}}</a>
                                    <ul>
                                    <li><a
                                      href="{{route('product.detail', $product_list_details->product_slug)}}">{{$product_list_details->product_name}}</a>
                                    </li>
                                    <!-- <li><a href="shop.html">Grid Layout</a></li> -->
                                    </ul>
                                    </div>
                                  </div>
                              @endforeach
                            @endif
                          </div>
                        </div>
                      </li>

                      <li><a href="{{route('about')}}">About</a></li>
                      <li><a href="{{route('faq')}}">FAQ</a></li>
                      <li><a href="{{route('customer.contact')}}">Contact</a></li>
                    </ul>
                  </nav>
                </div>
              </div>

              <div class="col-xl-3 col-lg-3">
                <div class="tp-header-contact d-flex align-items-center justify-content-end">
                  <div class="tp-header-contact-icon">
                    <span>
                      <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M1.96977 3.24859C2.26945 2.75144 3.92158 0.946726 5.09889 1.00121C5.45111 1.03137 5.76246 1.24346 6.01544 1.49057H6.01641C6.59631 2.05874 8.26011 4.203 8.35352 4.65442C8.58411 5.76158 7.26378 6.39979 7.66756 7.5157C8.69698 10.0345 10.4707 11.8081 12.9908 12.8365C14.1058 13.2412 14.7441 11.9219 15.8513 12.1515C16.3028 12.2459 18.4482 13.9086 19.0155 14.4894V14.4894C19.2616 14.7414 19.4757 15.0537 19.5049 15.4059C19.5487 16.6463 17.6319 18.3207 17.2583 18.5347C16.3767 19.1661 15.2267 19.1544 13.8246 18.5026C9.91224 16.8749 3.65985 10.7408 2.00188 6.68096C1.3675 5.2868 1.32469 4.12906 1.96977 3.24859Z"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.936 1.23685C16.4432 1.62622 19.2124 4.39253 19.6065 7.89874" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.936 4.59337C14.6129 4.92021 15.9231 6.23042 16.2499 7.90726" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </span>
                  </div>
                  <div class="tp-header-contact-content">
                    <h5>Hotline:</h5>
                    @if(isset($cms_texts))
                      @foreach ($cms_texts as $cms_text_list)
                        @if($cms_text_list->tag === 'header_contact')
                          <input type="hidden" value="{{$cms_text_list->tag}}" name="" id="header_contact_id">
                        <p id="summernote_cms_texts_contact" >{{$cms_text_list->value}}</p>

                        @endif
                      @endforeach
                
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- header area end -->

  <div id="header-sticky-2" class="tp-header-sticky-area">
    <div class="container">
      <div class="tp-mega-menu-wrapper p-relative">
        <div class="row align-items-center">
          <div class="col-xl-3 col-lg-3 col-md-3 col-6">
            <div class="logo">
              <a href="{{route('website')}}">
                @if(isset($cms_texts))
                @foreach ($cms_texts as $cms_text_list)
                  @if($cms_text_list->tag === 'header_logo')
                    <a href="{{route('website')}}">
                      <img src="{{asset('upload/website/'.$cms_text_list->value)}}"  alt="logo">
                    </a>
                  @endif
                @endforeach
      
              @endif
              </a>
            </div>
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6 d-none d-md-block">
            <div class="main-menu menu-style-1">
              <nav class="tp-main-menu-content">
                <ul>

                  <li><a href="{{route('website')}}">Home</a></li>
                  <li><a href="{{route('products')}}">Shop</a></li>


                  <li class="has-dropdown has-mega-menu">
                    <a href="#">Products</a>
                    <div class="shop-mega-menu tp-submenu tp-mega-menu">
                      <div class="row">

                        @if (isset($product_list))
                           @foreach ($product_list as $product_list_details)
                            <div class="col-lg-2">
                            <div class="shop-mega-menu-list">
                            <a href="{{route("category.products", $product_list_details->category_slug)}}"
                              class="shop-mega-menu-title">{{$product_list_details->category_name}}</a>
                             <ul>
                              <li><a
                              href="{{route('product.detail', $product_list_details->product_slug)}}">{{$product_list_details->product_name}}</a>
                              </li>
                              <!-- <li><a href="shop.html">Grid Layout</a></li> -->
                                </ul>
                              </div>
                            </div>
                             @endforeach
                          @endif
                      </div>
                    </div>
                  </li>

                  <li><a href="{{route('about')}}">About</a></li>
                  <li><a href="{{route('faq')}}">FAQ</a></li>
                  <li><a href="{{route('customer.contact')}}">Contact</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="col-xl-3 col-lg-3 col-md-3 col-6">
            <div class="tp-header-action d-flex align-items-center justify-content-end ml-50">

              <div class="tp-header-action-item d-none d-lg-block">
                @if(isset($customer_info))
          <a href="{{route('customer.profile')}}" class="tp-header-action-btn">
            <svg width="22" height="22" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="8.57894" cy="5.77803" r="4.77803" stroke="currentColor" stroke-width="1.5"
              stroke-linecap="round" stroke-linejoin="round" />
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M1.00002 17.2014C0.998732 16.8655 1.07385 16.5337 1.2197 16.2311C1.67736 15.3158 2.96798 14.8307 4.03892 14.611C4.81128 14.4462 5.59431 14.336 6.38217 14.2815C7.84084 14.1533 9.30793 14.1533 10.7666 14.2815C11.5544 14.3367 12.3374 14.4468 13.1099 14.611C14.1808 14.8307 15.4714 15.27 15.9291 16.2311C16.2224 16.8479 16.2224 17.564 15.9291 18.1808C15.4714 19.1419 14.1808 19.5812 13.1099 19.7918C12.3384 19.9634 11.5551 20.0766 10.7666 20.1304C9.57937 20.2311 8.38659 20.2494 7.19681 20.1854C6.92221 20.1854 6.65677 20.1854 6.38217 20.1304C5.59663 20.0773 4.81632 19.9641 4.04807 19.7918C2.96798 19.5812 1.68652 19.1419 1.2197 18.1808C1.0746 17.8747 0.999552 17.5401 1.00002 17.2014Z"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
        @else
      <a href="{{route('customer.login')}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="Sign in">
        {{-- <i class="fa-regular fa-arrow-right-to-bracket" style="font-size:22px; margin-top:5px;"></i> --}}
        <i class="fa-light fa-circle-user" style="font-size:25px; margin-top:5px;"></i>
      </a>
    @endif
              </div>

              <div class="tp-header-action-item d-none d-lg-block">
                <a onclick="window.location='{{route("show.wishlist")}}'" class="tp-header-action-btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                  title="Favourite Items">
                  <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M11.239 18.8538C13.4096 17.5179 15.4289 15.9456 17.2607 14.1652C18.5486 12.8829 19.529 11.3198 20.1269 9.59539C21.2029 6.25031 19.9461 2.42083 16.4289 1.28752C14.5804 0.692435 12.5616 1.03255 11.0039 2.20148C9.44567 1.03398 7.42754 0.693978 5.57894 1.28752C2.06175 2.42083 0.795919 6.25031 1.87187 9.59539C2.46978 11.3198 3.45021 12.8829 4.73806 14.1652C6.56988 15.9456 8.58917 17.5179 10.7598 18.8538L10.9949 19L11.239 18.8538Z"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.26062 5.05302C6.19531 5.39332 5.43839 6.34973 5.3438 7.47501" stroke="currentColor"
                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <span class="tp-header-action-badge wishlist_items-counter"></span>
                </a>
              </div>

              <div class="tp-header-action-item">
                <button type="button" class="tp-header-action-btn " data-bs-toggle="tooltip" data-bs-placement="bottom"
                  title="Cart Items" onclick="window.location='{{route("show.basket")}}'">
                  <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M6.48626 20.5H14.8341C17.9004 20.5 20.2528 19.3924 19.5847 14.9348L18.8066 8.89359C18.3947 6.66934 16.976 5.81808 15.7311 5.81808H5.55262C4.28946 5.81808 2.95308 6.73341 2.4771 8.89359L1.69907 14.9348C1.13157 18.889 3.4199 20.5 6.48626 20.5Z"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                      d="M6.34902 5.5984C6.34902 3.21232 8.28331 1.27803 10.6694 1.27803V1.27803C11.8184 1.27316 12.922 1.72619 13.7362 2.53695C14.5504 3.3477 15.0081 4.44939 15.0081 5.5984V5.5984"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.70365 10.1018H7.74942" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round" />
                    <path d="M13.5343 10.1018H13.5801" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                  <span class="tp-header-action-badge basket-items-counter"></span>
                </button>
              </div>

              <div class="tp-header-action-item d-lg-none">
                <button type="button" class="tp-header-action-btn tp-offcanvas-open-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" viewBox="0 0 30 16">
                    <rect x="10" width="20" height="2" fill="currentColor" />
                    <rect x="5" y="7" width="25" height="2" fill="currentColor" />
                    <rect x="10" y="14" width="20" height="2" fill="currentColor" />
                  </svg>
                </button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- attach section as content --}}
  @yield('content') 


  <!-- footer area start -->
  <footer>
    <div class="tp-footer-area" data-bg-color="footer-bg-grey">
      <div class="tp-footer-top pt-95 pb-40">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
              <div class="tp-footer-widget footer-col-1 mb-50">
                <div class="tp-footer-widget-content">
                  <div class="tp-footer-logo">
                    <a href="index.html">
                      @if(isset($cms_texts))
                      @foreach ($cms_texts as $cms_text_list)
                        @if($cms_text_list->tag === 'header_logo')
                          <a href="{{route('website')}}">
                            <img src="{{asset('upload/website/'.$cms_text_list->value)}}"  alt="logo">
                          </a>
                        @endif
                      @endforeach
              
                    @else
                      <a href="{{route('website')}}">
                        <h2>Shop</h2>
                      </a>
                    @endif
                    </a>
                  </div>
                  @if(isset($generalsetting->description))
            <p class="tp-footer-desc">{{$generalsetting->description}}</p>
          @else
        <p class="tp-footer-desc">We are a team of designers and developers that create high quality Projects
        </p>
      @endif
                  <div class="tp-footer-social">
                    @if(isset($generalsetting->facebook))
            <a href="{{$generalsetting->facebook}}" target="_blank" title="Facebook"><i
              class="fa-brands fa-facebook-f"></i></a>
          @endif

                    @if(isset($generalsetting->instagram))
            <a href="{{$generalsetting->instagram}}" target="_blank" title="Instagram"><i
              class="fa-brands fa-instagram"></i></a>
          @endif

                    @if(isset($generalsetting->twitter))
            <a href="{{$generalsetting->twitter}}" target="_blank" title="Twitter"><i
              class="fa-brands fa-twitter"></i></a>
          @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
              <div class="tp-footer-widget footer-col-2 mb-50">
                <h4 class="tp-footer-widget-title">My Account</h4>
                <div class="tp-footer-widget-content">
                  <ul>
                    <li><a href="{{route("show.wishlist")}}">Wishlist</a></li>
                    <li><a href="{{route('customer.profile')}}">My Account</a></li>
                    <li><a href="{{route('customer.login')}}">Login</a></li>
                    <li><a href="{{route('customer.register')}}">Register</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
              <div class="tp-footer-widget footer-col-3 mb-50">
                <h4 class="tp-footer-widget-title">Infomation</h4>
                <div class="tp-footer-widget-content">
                  <ul>
                    <li><a href="{{route('privacypolicy')}}">Privacy Policy- T&Cs</a></li>
                    <!-- <li><a href="{{route('privacypolicy')}}">Terms & Conditions</a></li> -->
                    <li><a href="{{route('show-blog')}}">Latest News</a></li>
                    <li><a href="{{route('customer.contact')}}">Contact Us</a></li>
                    <!-- <li><a href="{{url('/reset/caches')}}">Clear All Caches</a></li> -->
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
              <div class="tp-footer-widget footer-col-4 mb-50">
                <h4 class="tp-footer-widget-title">Talk To Us</h4>
                <div class="tp-footer-widget-content">
                  <div class="tp-footer-talk mb-20">
                    <span>Got Questions? Call us</span>
                    @if(isset($cms_texts))
                    @foreach ($cms_texts as $cms_text_list)
                      @if($cms_text_list->tag === 'header_contact')
                      <h4 id="summernote_cms_texts_contact" >{{$cms_text_list->value}}</h4>

                      @endif
                    @endforeach
              
                  @endif
                  </div>
                  <div class="tp-footer-contact">
                    <div class="tp-footer-contact-item d-flex align-items-start">
                      <div class="tp-footer-contact-icon">
                        <span>
                          <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 5C1 2.2 2.6 1 5 1H13C15.4 1 17 2.2 17 5V10.6C17 13.4 15.4 14.6 13 14.6H5"
                              stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                              stroke-linejoin="round" />
                            <path d="M13 5.40039L10.496 7.40039C9.672 8.05639 8.32 8.05639 7.496 7.40039L5 5.40039"
                              stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                              stroke-linejoin="round" />
                            <path d="M1 11.4004H5.8" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 8.19922H3.4" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </span>
                      </div>
                      <div class="tp-footer-contact-content">
                        @if(isset($generalsetting->email))
                            <p>{{$generalsetting->email}}</p>
                          @else
                          <p>info@stop.com</p>
                        @endif
                      </div>
                    </div>
                    <div class="tp-footer-contact-item d-flex align-items-start">
                      <div class="tp-footer-contact-icon">
                        <span>
                          <svg width="17" height="20" viewBox="0 0 17 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M8.50001 10.9417C9.99877 10.9417 11.2138 9.72668 11.2138 8.22791C11.2138 6.72915 9.99877 5.51416 8.50001 5.51416C7.00124 5.51416 5.78625 6.72915 5.78625 8.22791C5.78625 9.72668 7.00124 10.9417 8.50001 10.9417Z"
                              stroke="currentColor" stroke-width="1.5" />
                            <path
                              d="M1.21115 6.64496C2.92464 -0.887449 14.0841 -0.878751 15.7889 6.65366C16.7891 11.0722 14.0406 14.8123 11.6313 17.126C9.88298 18.8134 7.11704 18.8134 5.36006 17.126C2.95943 14.8123 0.210885 11.0635 1.21115 6.64496Z"
                              stroke="currentColor" stroke-width="1.5" />
                          </svg>
                        </span>
                      </div>
                      <div class="tp-footer-contact-content">
                        @if(isset($generalsetting->address))
                            <p>{{$generalsetting->address}}</p>
                          @else
                          <p>79 Sleepy Hollow St.Jamaica, New York 1432</p>
                        @endif
                      </div>
                      <p></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tp-footer-bottom">
      <div class="container">
        <div class="tp-footer-bottom-wrapper">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="tp-footer-copyright">
                <p class="text-center">&copy; {{date('Y')}} All Rights Reserved | A Web Solution by <a
                    href="" target="_blank">Uzair</a></p>
                    {{-- https://jjahanzab.github.io/resume/index.html --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </footer>
  <!-- footer area end -->


  <!-- JS here -->
  {{--
  <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> --}}
  <script src="{{asset('frontend_assets/js/vendor/jquery.js')}}"></script>  
  <script src="{{asset('frontend_assets/js/vendor/waypoints.js')}}"></script>
  <script src="{{asset('frontend_assets/js/bootstrap-bundle.js')}}"></script>
  <script src="{{asset('frontend_assets/js/meanmenu.js')}}"></script>
  <script src="{{asset('frontend_assets/js/swiper-bundle.js')}}"></script>
  <script src="{{asset('frontend_assets/js/slick.js')}}"></script>
  <script src="{{asset('frontend_assets/js/range-slider.js')}}"></script>
  <script src="{{asset('frontend_assets/js/magnific-popup.js')}}"></script>
  <script src="{{asset('frontend_assets/js/nice-select.js')}}"></script>
  <script src="{{asset('frontend_assets/js/purecounter.js')}}"></script>
  <script src="{{asset('frontend_assets/js/countdown.js')}}"></script>
  <script src="{{asset('frontend_assets/js/wow.js')}}"></script>
  <script src="{{asset('frontend_assets/js/isotope-pkgd.js')}}"></script>
  <script src="{{asset('frontend_assets/js/infinite-scroll.js')}}"></script>
  <script src="{{asset('frontend_assets/js/imagesloaded-pkgd.js')}}"></script>
  <script src="{{asset('frontend_assets/js/ajax-form.js')}}"></script>
  <script src="{{asset('frontend_assets/js/main.js')}}"></script>
  <script src="{{asset('frontend_assets/js/axios.min.js')}}"></script>
  <script src="{{asset('backend_assets/Toasts/toasts.js')}}"></script>

  {{-- summernote editor --}}
  <script src="{{asset('frontend_assets/Editor/summernote-bs4.min.js')}}"></script>
 

  <script type="text/javascript">
    
  const _token                   = "{{ csrf_token() }}";
  const  website_url              = "{!!route('website')!!}";
  const basket_url               = "{!!route('show.basket')!!}";
  const basket_checkout_url      = "{!!route('basket.checkout')!!}";
  const verify_basket            = "{!!route('verify.basket')!!}";
  const  logout_url              = "{!!route('customer.logout')!!}";
  const  update_password_url     =  "{!!route('customer.updatepassword')!!}";
  const  customer_order_detail   = "{!!route('customer.order.detail')!!}";
  const website_route            = "{!!route('website')!!}";
  const checkout_route           = "{!!route('basket.checkout')!!}";
  const place_order_route        = "{!!route('orderplace')!!}";
  const coupon_url               = "{!!route('couponcode')!!}";
  const edit_content_url         = "{!!route('admin.edit-content')!!}";
  const logo_url                 = "{!!route('admin.summernote-upload-image')!!}";
    // Search Product
    $(document).ready(function () {

      $("#search,.search").keyup(function () {

        $token = $("meta[name ='csrf-token']").attr('content');
        var search_value = $(this).val();

        if (search_value == "") {

          $(".search_list").html('');

        } else {

          $.ajax({
            url: '{{route('search')}}',
            method: 'post',
            dataType: 'json',
            data: { 'product_name': search_value, '_token': $token },
            success: function (data) {
              console.log(data);
              $(".search_list").html(data);

            },
            error: function (err) {

              console.log(err);
            }
          });
        }
      });
    });

  </script>

  {{-- custom js files --}}
  {{--
  <script src="{{asset('frontend_assets/custom-js/customone.js')}}"></script> --}}
  <!-- Custom js files -->
  <script src="{{asset('frontend_assets/custom-js/summernote.js')}}"></script>
  <script src="{{asset('frontend_assets/custom-js/frontend-helper.js')}}"></script>
  <script src="{{asset('frontend_assets/custom-js/customer-profile.js')}}"></script>
  <script src="{{asset('frontend_assets/custom-js/basket.js')}}"></script>
  <script src="{{asset('frontend_assets/custom-js/wishlist.js')}}"></script>

  @yield('js_scripts')

</body>

</html>