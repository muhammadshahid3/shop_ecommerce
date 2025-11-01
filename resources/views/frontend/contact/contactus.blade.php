@extends('frontend.layout.master')

@section('content')

<main>

   <!-- breadcrumb area start -->
   <section class="breadcrumb__area include-bg text-center pt-95 pb-50">
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="breadcrumb__content p-relative z-index-1">
                  <h3 class="breadcrumb__title">Keep in Touch with Us</h3>
                  <div class="breadcrumb__list">
                     <span><a href="{{route('website')}}">Home</a></span>
                     <span>Contact</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- breadcrumb area end -->


   <!-- contact area start -->
   <section class="tp-contact-area pb-100">
      <div class="container">
         <div class="tp-contact-inner">
            <div class="row">
               <div class="col-xl-9 col-lg-8">
                  <div class="tp-contact-wrapper">
                     <h3 class="tp-contact-title">Sent a Message</h3>

                     <div class="tp-contact-form">
                        <form action="{{route('customer.contact.save')}}" method="POST">
                           @csrf
                           <div class="tp-contact-input-wrapper">
                              <div class="tp-contact-input-box">
                                 <div class="tp-contact-inputs">
                                    <input id="name" type="text"
                                       value="{{isset($customer_info->username)?$customer_info->username:''}}" required
                                       disabled>
                                 </div>
                                 <div class="tp-contact-input-title">
                                    <label for="username">Your Name</label>
                                 </div>
                              </div>
                              <div class="tp-contact-input-box">
                                 <div class="tp-contact-input">
                                    <input id="email" type="email"
                                       value="{{isset($customer_info->email)?$customer_info->email:''}}" required
                                       disabled>
                                 </div>
                                 <div class="tp-contact-input-title">
                                    <label for="email">Your Email</label>
                                 </div>
                              </div>
                              <div class="tp-contact-input-box">
                                 <div class="tp-contact-input">
                                    <input name="subject" id="subject" type="text" placeholder="Write your subject"
                                       required>
                                 </div>
                                 <div class="tp-contact-input-title">
                                    <label for="subject">Subject</label>
                                 </div>
                              </div>
                              <div class="tp-contact-input-box">
                                 <div class="tp-contact-input">
                                    <textarea id="message" name="message" placeholder="Write your message here..."
                                       required></textarea>
                                 </div>
                                 <div class="tp-contact-input-title">
                                    <label for="message">Your Message</label>
                                 </div>
                              </div>
                           </div>
                           <div class="tp-contact-btn">
                              <button type="submit">Send Message</button>
                           </div>
                        </form>
                        {{-- <p class="ajax-response"></p> --}}
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-4">
                  <div class="tp-contact-info-wrapper">
                     <div class="tp-contact-info-item">
                        <div class="tp-contact-info-icon">
                           <span>
                              <img src="{{asset('frontend_assets/img/contact/contact-icon-1.png')}}" alt="">
                           </span>
                        </div>
                        <div class="tp-contact-info-content">
                           @if(isset($generalsetting->email))
                           <p data-info="mail">{{$generalsetting->email}}</p>
                           @else
                           <p data-info="mail">info@stop.com</p>
                           @endif
                           @if(isset($generalsetting->contact))
                           <p data-info="phone">{{$generalsetting->contact}}</p>
                           @else
                           <p data-info="phone">+12 000 000 000</p>
                           @endif
                        </div>
                     </div>
                     <div class="tp-contact-info-item">
                        <div class="tp-contact-info-icon">
                           <span>
                              <img src="{{asset('frontend_assets/img/contact/contact-icon-2.png')}}" alt="">
                           </span>
                        </div>
                        <div class="tp-contact-info-content">
                           @if(isset($generalsetting->address))
                           <p>{{$generalsetting->address}}</p>
                           @else
                           <p>79 Sleepy Hollow St.Jamaica, <br> New York 1432</p>
                           @endif
                        </div>
                     </div>
                     <div class="tp-contact-info-item">
                        <div class="tp-contact-info-icon">
                           <span>
                              <img src="{{asset('frontend_assets/img/contact/contact-icon-3.png')}}" alt="">
                           </span>
                        </div>
                        <div class="tp-contact-info-content">
                           <div class="tp-contact-social-wrapper mt-5">
                              <h4 class="tp-contact-social-title">Find on social media</h4>

                              <div class="tp-contact-social-icon">
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
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- contact area end -->

</main>

@endsection