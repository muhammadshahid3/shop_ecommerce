@extends('frontend.layout.master')

@section('content')

   <main>
      <!-- error area start -->
      <section class="tp-error-area pt-90 pb-90">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xl-6 col-lg-8 col-md-10">
                  <div class="tp-error-content text-center">
                     <div class="tp-error-thumb">
                        <img src="{{asset('frontend_assets/img/error/error.png')}}" alt="no pic">
                     </div>

                     <h3 class="tp-error-title">Oops! Data not found</h3>
                     <p>Whoops, Looks like the page you were looking for wasn't found.</p>

                     <a href="{{route("website")}}" class="tp-error-btn">Back to Home</a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- error area end -->

   </main>
      
@endsection