@extends('frontend.layout.master')

@section('content')

<main>
   <!-- blog grid area start -->
   <section class="tp-blog-grid-area pb-120 pt-50">
      <div class="container">
         <div class="row">
            <div class="col-xl-12 col-lg-12">
               <div class="tp-blog-grid-wrapper">
                  <div class=" d-flex  mb-40">
                     <!-- <div class="tp-blog-grid-result">
                           
                        </div> -->
                     <div class="tp-blog-grid-tab tp-tab border p-2 me-2">
                        <nav>
                           <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                 data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid"
                                 aria-selected="true">
                                 <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                       d="M16.3328 6.01317V2.9865C16.3328 2.0465 15.9061 1.6665 14.8461 1.6665H12.1528C11.0928 1.6665 10.6661 2.0465 10.6661 2.9865V6.0065C10.6661 6.95317 11.0928 7.3265 12.1528 7.3265H14.8461C15.9061 7.33317 16.3328 6.95317 16.3328 6.01317Z"
                                       stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                       stroke-linejoin="round" />
                                    <path
                                       d="M16.3328 15.18V12.4867C16.3328 11.4267 15.9061 11 14.8461 11H12.1528C11.0928 11 10.6661 11.4267 10.6661 12.4867V15.18C10.6661 16.24 11.0928 16.6667 12.1528 16.6667H14.8461C15.9061 16.6667 16.3328 16.24 16.3328 15.18Z"
                                       stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                       stroke-linejoin="round" />
                                    <path
                                       d="M7.33281 6.01317V2.9865C7.33281 2.0465 6.90614 1.6665 5.84614 1.6665H3.1528C2.0928 1.6665 1.66614 2.0465 1.66614 2.9865V6.0065C1.66614 6.95317 2.0928 7.3265 3.1528 7.3265H5.84614C6.90614 7.33317 7.33281 6.95317 7.33281 6.01317Z"
                                       stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                       stroke-linejoin="round" />
                                    <path
                                       d="M7.33281 15.18V12.4867C7.33281 11.4267 6.90614 11 5.84614 11H3.1528C2.0928 11 1.66614 11.4267 1.66614 12.4867V15.18C1.66614 16.24 2.0928 16.6667 3.1528 16.6667H5.84614C6.90614 16.6667 7.33281 16.24 7.33281 15.18Z"
                                       stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                       stroke-linejoin="round" />
                                 </svg>
                              </button>
                              <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list"
                                 type="button" role="tab" aria-controls="nav-list" aria-selected="false">
                                 <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 7.11133H1" stroke="currentColor" stroke-width="2"
                                       stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15 1H1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                       stroke-linejoin="round" />
                                    <path d="M15 13.2222H1" stroke="currentColor" stroke-width="2"
                                       stroke-linecap="round" stroke-linejoin="round" />
                                 </svg>
                              </button>
                           </div>
                        </nav>
                     </div>
                     <p style="font-size:25px; margin: auto 0;">Latest News</p>
                  </div> <!-- top end -->



                  {{--Blog Section Start--}}


                  <div class="tab-content" id="nav-tabContent">
                     <div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab"
                        tabindex="0">

                        <div class="tp-blog-grid-item-wrapper">
                           <div class="row tp-gx-30">
                              @if (isset($blog_details))
                              @foreach ($blog_details as $blog_details_data)

                              <div class="col-lg-6 col-md-6">
                                 <div class="tp-blog-grid-item p-relative mb-30">
                                    <div class="tp-blog-grid-thumb w-img fix mb-30">
                                       <a href="">
                                          <img src="{{asset('upload/Blog/'.$blog_details_data->thumbnail)}}"
                                             height="300" alt="">
                                       </a>
                                    </div>

                                    <div class="tp-blog-grid-content">
                                       <div class="tp-blog-grid-meta">
                                          <span>
                                             <span>

                                             </span>
                                             <?php  
                                       
                                                  echo   $blog_details_data->updated_at->diffForHumans();
                                                ?>
                                          </span>

                                       </div>
                                       <h3 class="tp-blog-grid-title">
                                          <a href="">{{$blog_details_data->title}}</a>
                                       </h3>
                                       <p> {{$blog_details_data->description}} </p>

                                       <div class="tp-blog-grid-btn">
                                          <a href="" class="tp-link-btn-3">

                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                              @endif
                              <!-- Pagination Links -->
                              {{-- {{ $blog_details->links() }} --}}

                              {{--Blog Section End--}}
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab"
                        tabindex="0">
                        <!-- blog list wrapper -->

                        <div class="tp-blog-list-item-wrapper">
                           @if (isset($blog_details))
                           @foreach ($blog_details as $blog_details_item )
                           <div class="tp-blog-list-item d-md-flex d-lg-block d-xl-flex">

                              <div class="tp-blog-list-thumb">
                                 <a href="">
                                    <img src="{{asset('upload/Blog/'.$blog_details_item->thumbnail)}}" height="300px"
                                       alt="">
                                 </a>
                              </div>

                              <div class="tp-blog-list-content">
                                 <div class="tp-blog-grid-content">
                                    <div class="tp-blog-grid-meta">
                                       <span>
                                          <?php  
                                                echo  $blog_details_item->updated_at->diffForHumans();
                                           ?>
                                       </span>
                                    </div>
                                    <h3 class="tp-blog-grid-title">
                                       <a href="">{{$blog_details_item->title}}</a>
                                    </h3>
                                    <p>{{$blog_details_item->description}}</p>

                                    <div class="tp-blog-grid-btn">
                                       <a href="blog-details.html" class="tp-link-btn-3">

                                       </a>
                                    </div>
                                 </div>

                              </div>
                           </div>
                           @endforeach
                           @endif
                           <!-- Pagination Links -->
                           {{-- {{ $blog_details->links() }} --}}
                        </div>
                        <!-- blog list wrapper End -->
                     </div>

                     <div class="col-xl-12">
                        <div class="tp-blog-pagination mt-30">


                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </div>
      </div>
   </section>
   <!-- blog grid area end -->

</main>

@endsection