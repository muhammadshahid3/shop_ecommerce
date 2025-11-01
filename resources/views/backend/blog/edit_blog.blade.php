@extends('backend.main.main')

@section('content')



<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Edit Blog</h3>
    <a href="{{route('admin.blog')}}" class="text-white"> <button type="btn" class="btn btn-primary "
            style="padding:7px 15px"> <i class="fa fa-circle-left"></i> Back </button></a>
</div>

{{--Add Blog--}}

<div class="pb-5 pt-2">
    <div class="card">
        @if(isset($blog_details))
            <!-- form -->
            <form action="{{route('admin.blog.update-blog')}}" method="post" enctype='multipart/form-data'>
                @csrf
                <div class="card-body pb-3 p-3">
                    <div class="row">

                        <div class="col-md-6 col-12 pb-3">
                            <div class="form-floating">
                                <input type="text" name="title" value="{{old('title', $blog_details->title)}}"
                                    class="form-control" placeholder="title" required>
                                    <input type="hidden" name="blog_id" value="{{$blog_details->id}}" id="">
                                <label for="" class="form-label">Blog Title <span style="color:red">*</span></label>
                            </div>
                            @error('title')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                        <div class="col-md-6 col-12 pb-3">
                            <div class="form-floating">
                                <textarea name="description" class="form-control" id="">{{$blog_details->description}}</textarea>
                                <label for="" class="form-label"> Description <span style="color:red">*</span></label>
                            </div>
                            @error('description')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                        <div class="col-md-6 col-12 pb-3">
                            <div class="form-floating">
                                <input type="file" name="thumbnail" value="" class="form-control">
                                <label for="" class="form-label"> Thumbnail </label>

                                @if (isset($blog_details->thumbnail))
                                    @if(file_exists(public_path('upload/blog/'. $blog_details->thumbnail)))
                                    
                                        <img src="{{asset('upload/blog/' . $blog_details->thumbnail)}}" class="mt-2" width="60" height="60"
                                            alt="">
                                    @else
                                        <img src="{{asset('upload/blog/dummy.png')}}" class="mt-2" width="60" height="60" alt="">
                                    @endif
                                @else
                                    <img src="{{asset('upload/blog/dummy.png')}}" class="mt-2" width="60" height="60" alt="">
                                @endif

                            </div>
                            @error('thumbnail')
                            <div class="text text-danger">{{$message}}</div>@enderror
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            <!-- form end-->
        @endif

    </div>
</div>

@endsection