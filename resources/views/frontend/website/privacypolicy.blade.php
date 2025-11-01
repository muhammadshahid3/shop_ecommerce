@extends('frontend.layout.master')

@section('content')

  <main>

    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-50 pb-50">
      <div class="container">
        <div class="row">
          <div class="col-xxl-12">
            <div class="breadcrumb__content p-relative z-index-1">
              <h3 class="breadcrumb__title text-center">Privacy Policy</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- breadcrumb area end -->

    <section class="tp-shop-area pb-120">
        <div class="container">
          <div class="row">

            <div class="col-xl-12 col-lg-12">
              <div class="tp-shop-main-wrapper">
                  
                <div class="tp-contact-inner customcss-scroll-screen">
                  
                  @if ($privacy_policy)
                    {!! $privacy_policy !!}
                  @else
                    <h5 class="text-center">No Data Found</h5>
                  @endif

                </div>
                    
              </div>
            </div>

          </div>
        </div>
    </section>

  </main>
      
@endsection
