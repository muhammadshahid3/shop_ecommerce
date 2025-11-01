@extends('backend.main.main')

@section('content')



<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">View Blog</h3>
    <a href="{{route('admin.blog')}}" class="text-white"> <button type="btn" class="btn btn-primary "
            style="padding:7px 15px"> <i class="fa fa-circle-left"></i> Back </button></a>
</div>

{{--View Blog--}}

<div class="card mb-3">
  <div class="row g-0">
    @if(isset($view_details))
    <?php  $url = asset('upload/blog/'.$view_details->thumbnail)  ?>
    <div class="col-md-4">
      <img src="{{$url}}" class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{{$view_details->title}}</h5>
        <p class="card-text">{{$view_details->description}}</p>
        <p class="card-text"><small class="text-muted">Last updated {{$date}}</small></p>
      </div>
    </div>
    @endif
  </div>
</div>

@endsection