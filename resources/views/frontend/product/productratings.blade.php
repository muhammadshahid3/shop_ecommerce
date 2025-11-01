{{-- @extends('frontend.layout.master')

@section('content')

<h3 class="text-center" style="margin-top:40px">Rating & Reviews</h3>

 <div class="container">
    <div class="row">
        
            <div class="overflow-auto p-3" style="width:50%;height:200px; border:1px solid rgb(250, 242, 242); margin-top:50px; margin-bottom:100px">
                @foreach ($allratings as $rating)
                <div class="tp-product-details-review-list pr-110">
                <div class="tp-product-details-review-avater d-flex align-items-start">
                    <div class="tp-product-details-review-avater-thumb">
                        <span class="bg-primary me-3 text-white" style="width: 30px; height:30px; border-radius:50px; text-align: center;display: inline-block;">
                            @php
                              $first_character = substr($rating->username, 0, 1);
                               $upper_case_word = ucwords($first_character);
                               echo $upper_case_word;
                            @endphp
                        </span>
                    </div>
                 
                    <div class="tp-product-details-review-avater-rating">
                           @php
                            $fill_star = '';
                            $unfill_star = '';
                                if($rating->stars == 1){
                                    $fill_star   .='<span><i class="fa-solid fa-star"></i></span>';
                                    $unfill_star .='<span><i class="fa-light fa-star"></i></span>
                                    <span><i class="fa-light fa-star"></i></span>
                                    <span><i class="fa-light fa-star"></i></span>
                                    <span><i class="fa-light fa-star"></i></span>';
                                  
                                }else if($rating->stars == 2){
                                    $fill_star .='<span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>';
                                    $unfill_star .='<span><i class="fa-light fa-star"></i></span>
                                    <span><i class="fa-light fa-star"></i></span>
                                    <span><i class="fa-light fa-star"></i></span>';

                                }else if($rating->stars == 3){
                                  $fill_star .='<span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>';
                                    $unfill_star .='<span><i class="fa-light fa-star"></i></span>
                                    <span><i class="fa-light fa-star"></i></span>';
                                }else if($rating->stars == 4){
                                  $fill_star .='<span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>';
                                    $unfill_star .='<span><i class="fa-light fa-star"></i></span>';
                                }else if($rating->stars == 5){
                                  $fill_star .='<span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                     <span><i class="fa-solid fa-star"></i></span>';
                                }else{
                                  $unfill_star .='<span><i class="fa-light fa-star"></i></span>
                                        <span><i class="fa-light fa-star"></i></span>
                                        <span><i class="fa-light fa-star"></i></span>
                                        <span><i class="fa-light fa-star"></i></span>
                                        <span><i class="fa-light fa-star"></i></span>';
                                }
                                    echo $fill_star.$unfill_star;
                           @endphp 

                
                        <div class="tp-product-details-review-avater-rating d-flex align-items-center mt-2">
                            {{$rating->username}}
                        </div>
                        <h3 class="tp-product-details-review-avater-title">{{$rating->review_message}}</h3>
                        <div class="tp-product-details-review-avater-comment">
                      
                        </div>
                        </div>                   
                    </div>
                </div>
                @endforeach

            </div>
      
    </div>
 </div>

@endsection --}}