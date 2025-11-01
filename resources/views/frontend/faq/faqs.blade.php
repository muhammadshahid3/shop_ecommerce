@extends('frontend.layout.master')

@section('content')

<div class="container">
   <div class="row">
      <div class="col-12">
         <p class="text-center pt-4 bold" style="font-size:25px;">FAQs</pcla>
      </div>
   </div>
</div>

<main>
   <div class="container pb-120 pt-30 ">
      <div class="row">
         <div class="col-12">
            @if (isset($faq_details))
               @foreach ($faq_details as $faq_details_data)
            
            <div class="accordion" id="accordionExample">
   
               {{--Acoordion Start--}}
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{$faq_details_data->id}}" aria-expanded="false" aria-controls="collapseThree">
                           {{$faq_details_data->question}}
                     </button>
                  </h2>
                  <div id="collapse{{$faq_details_data->id}}" class="accordion-collapse collapse" aria-labelledby="headingThree"
                     data-bs-parent="#accordionExample">
                     <div class="accordion-body">
                        <p>{{$faq_details_data->answer}}</p>
                     </div>
                  </div>
               </div>
               {{--Acoordion End--}}

            </div>
            @endforeach
            @endif
         </div>
      </div>
   </div>



</main>

@endsection