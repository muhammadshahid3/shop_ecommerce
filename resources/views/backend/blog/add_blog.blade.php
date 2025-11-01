@extends('backend.main.main')

@section('content')



<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Add Blog</h3>
    <a href="{{route('admin.blog')}}" class="text-white"> <button type="btn" class="btn btn-primary "
      style="padding:7px 15px"> <i class="fa fa-circle-left"></i> Back </button></a>
</div>

{{--Add Blog--}}

<div class="pb-5 pt-2">
    <div class="card">
        <!-- form -->
        <form action="{{route('admin.blog.storeblog')}}" method="post" enctype='multipart/form-data'>
            @csrf
            <div class="card-body pb-3 p-3">
                <div class="row">

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="title" value="" class="form-control"
                                placeholder="title" required>
                            <label for="" class="form-label">Blog Title <span style="color:red">*</span></label>
                        </div>
                        @error('title') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                            <input type="file" name="thumbnail" value="" class="form-control" required>
                            <label for="" class="form-label"> Thumbnail <span style="color:red">*</span></label>

                        </div>
                        @error('thumbnail') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                            <textarea name="description" class="form-control" id=""></textarea>
                            <label for="" class="form-label"> Description <span style="color:red">*</span></label>
                        </div>
                        @error('description') <div class="text text-danger">{{$message}}</div>@enderror
                    </div>


                    <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                            <select class="form-control" name="blog_status">
                                <option value="A" selected>Active</option>
                                <option value="I">Inctive</option>
                            </select>
                            <label for="" class="">Status</label>
                        </div>
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        <!-- form end-->
    </div>
</div>

@endsection
