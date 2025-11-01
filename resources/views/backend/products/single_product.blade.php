@extends('backend.main.main')

@section('content')
<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        View Product
        <span class="float-right">
            <a href="{{route('admin.product.showproduct')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--View Product--}}

<!-- Card -->
<div class="card mb-3 p-4">
    @if (!empty($single_product))
        <div class="row g-0">

            <div class="col-md-4">
                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{asset('upload/product/' . $single_product->product_thumbnail)}}" class="" alt="...">
                        </div>
                        <?php    $images = App\Models\Product_images::where('product_id', $single_product->id)->get(); ?>
                        @if (!empty($images))
                            @foreach ($images as $image_list)
                                <div class="swiper-slide">
                                    <img src="{{asset('upload/product/gallery_imgs/' . $image_list->product_images)}}" class=""
                                        alt="...">
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <img src="{{asset('upload/product/gallery_imgs/dummy.png')}}" class="" alt="...">
                            </div>
                        @endif

                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div thumbsSlider="" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{asset('upload/product/' . $single_product->product_thumbnail)}}" class="" alt="...">
                        </div>
                        <?php    $images = App\Models\Product_images::where('product_id', $single_product->id)->get(); ?>
                        @if (!empty($images))
                            @foreach ($images as $image_list)
                                <div class="swiper-slide">
                                    <img src="{{asset('upload/product/gallery_imgs/' . $image_list->product_images)}}" class=""
                                        alt="...">
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <img src="{{asset('upload/product/gallery_imgs/dummy.png')}}" class="" alt="...">
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card-body mx-3">
                    @php    $category = App\Models\Category::get(); @endphp
                    @if (count($category))
                        @foreach ($category as $category_item)
                            @if ($category_item->id == $single_product->category_id)
                                <h5 class="card-title" style="float:none">{{$category_item->category_name}}</h5>
                            @endif
                        @endforeach
                    @endif
                    <h3 class="">{{$single_product->product_name}}</h3>
                    @if ($single_product->product_stock_status == 'A')
                        <p class="card-text text-bold text-success">In Stock</p>
                    @else
                        <p class="card-text text-bold text-danger">Out Stock</p>
                    @endif
                    <p class="card-text">{{$single_product->product_description}}</p>
                    <div style="font-size:20px">
                    <p class="card-text">$ <del>{{number_format($single_product->product_old_price, 2)}}
                    </del><span class="mx-4">$ {{number_format($single_product->product_price, 2)}}</span>
                    </p>
                    </div>
            
                </div>
            </div>
        </div>
    @endif
</div>



@endsection

{{--Swiper JS--}}
@section('script')
<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>
@endsection