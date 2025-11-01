@extends('backend.main.main')
@section('content')

<div class="pagetitle mt-3 mb-4">
  <h1 class="text-primary">
    Admin Dashboard
    <span class="float-right text-primary">
      {{ date('Y-m-d') }} <i class="bi bi-calendar3"></i>
    </span>
  </h1>
</div>

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        {{-- Categories --}}
        <div class=" col-lg-3 col-md-3 col-sm-12 col-xl-3 col-xxl-3">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Categories</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa fa-layer-group nav-icon" style="font-size:23px;"></i>
                </div>
                <div class="ps-3">
                  @if(isset($category_count) && $category_count > 0)
                    <h6>{{$category_count}}</h6>
                  @else
                    <h6>0</h6>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- Products --}}
        <div class=" col-lg-3 col-md-3 col-sm-12 col-xl-3 col-xxl-3">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Products</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="fa fa-box-open nav-icon" style="font-size:23px;"></i>
                </div>
                <div class="ps-3">
                  @if(isset($product_count) && $product_count > 0)
                    <h6>{{$product_count}}</h6>
                  @else
                    <h6>0</h6>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- Customers --}}
        <div class=" col-lg-3 col-md-3 col-sm-12 col-xl-3 col-xxl-3">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Customers</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="nav-icon fas fa-users" style="font-size:23px;"></i>
                </div>
                <div class="ps-3">
                  @if(isset($customer_count) && $customer_count > 0)
                    <h6>{{$customer_count}}</h6>
                  @else
                    <h6>0</h6>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- Orders --}}
        <div class=" col-lg-3 col-md-3 col-sm-12 col-xl-3 col-xxl-3">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Orders</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-shield-plus"></i>
                </div>
                <div class="ps-3">
                  @if(isset($order_count) && $order_count > 0)
                    <h6>{{$order_count}}</h6>
                  @else
                    <h6>0</h6>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div><!-- End Right side columns -->

  </div>
</section>

@endsection