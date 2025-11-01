@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Edit Banner
        <span class="float-right">
            <a href="{{route('admin.banner.showbanners')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

<section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    {{--Edit Banner--}} 
     @if (isset($single_edit_banner))

    <div class="card p-3">
        <!-- form -->
        <form action="{{route('admin.banner.updatebanner')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner Text</label>
                        <input type="text" name="banner_text" value="{{$single_edit_banner->banner_start_text}}" class="form-control" placeholder="banner text">
                        <input type="hidden" name="banner_id" value="{{$single_edit_banner->id}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner Title</label>
                        <input type="text" name="banner_title" value="{{$single_edit_banner->banner_title}}" class="form-control" placeholder="banner title">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner SubTitle </label>
                        <input type="text" name="banner_subtitle" value="{{$single_edit_banner->banner_subtitle}}" class="form-control" placeholder="banner subtitle">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner link </label>
                        <input type="text" name="banner_btnlink" value="{{$single_edit_banner->banner_btnlink}}" class="form-control" placeholder="banner link">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner Image <span style="color:red">*</span></label>
                        <input type="file" name="banner_image" value="" class="form-control">
                        <br>
                        @if(!empty($single_edit_banner->banner_image))
                            @if(file_exists(public_path('upload/banner/' . $single_edit_banner->banner_image)))
                                <img src="{{asset('upload/banner/' . $single_edit_banner->banner_image)}}" width="60"
                                    height="60" alt="">
                            @else
                                <img src="{{asset('upload/product/dummy.png')}}" width="60" height="60" alt="">

                            @endif
                        @else
                            <img src="{{asset('upload/product/dummy.png')}}" width="60" height="60" alt="">
                        @endif
                    </div>
                </div>
    
           
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="">Status</label>
                        <select class="form-control"name="banner_status" >
                            @if ($single_edit_banner->banner_status == 'A')
                                 <option value="A" selected>Active</option>
                                 <option value="I" >Inctive</option>
                            @else   
                            <option value="A" >Active</option>
                            <option value="I" selected >Inctive</option>

                            @endif
                        </select>
                    @error('banner_status') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <!-- form end-->      
    </div>

    @endif

    {{--Edit Banner End--}} 


    <!-- /.card -->
</section>
@endsection

