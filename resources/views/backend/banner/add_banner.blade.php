@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Add Banner
        <span class="float-right">
            <a href="{{route('admin.banner.showbanners')}}"><button class="btn btn-primary">
                    <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

<section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="card p-3">
        <!-- form -->
        <form action="{{route('admin.banner.storebanner')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner Text</label>
                        <input type="text" name="banner_text" value="" class="form-control" placeholder="banner text">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner Title</label>
                        <input type="text" name="banner_title" class="form-control" placeholder="banner title">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner SubTitle </label>
                        <input type="text" name="banner_subtitle" class="form-control" placeholder="banner subtitle">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner link </label>
                        <input type="text" name="banner_btnlink" class="form-control" placeholder="banner link">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Banner Image <span style="color:red">*</span></label>
                        <input type="file" name="banner_image" value="" class="form-control" required>
                    </div>
                    @error('banner_imge') <div class="text text-danger">{{$message}}</div>@enderror
                </div>
    
           
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="">Status</label>
                        <select class="form-control"name="category_status" >
                        <option value="A" selected>Active</option>
                        <option value="I">Inctive</option>
                        </select>
                    @error('banner_status') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <!-- form end-->      
    </div>
    <!-- /.card -->
</section>
@endsection