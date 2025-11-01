@extends('Backend.main.main')

@section('content')

<div style=" display:flex; justify-content:space-between; align-items: center; padding-bottom:20px">
    <h3 class="text-primary">Edit FAQS</h3>
    <a href="{{route('admin.faqs')}}" class="text-white"> <button type="btn" class="btn btn-primary "
    style="padding:7px 15px">  <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
    
</div>

{{--Add Faq--}}
<div class="pb-5 pt-2">
    <div class="card">
        @if (isset($faq_details))
        <!-- form -->
        <form action="{{route('admin.faqs.update')}}" method="post">
            @csrf
            <div class="card-body pb-3 p-3">
                <div class="row">

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <input type="text" name="question" value="{{old('question',$faq_details->question)}}" class="form-control" required>
                            <input type="hidden" name="faq_id" value="{{$faq_details->id}}">
                            <label for="" class="form-label">Question </label>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 pb-3">
                        <div class="form-floating">
                            <textarea name="answer" class="form-control" id="">{{$faq_details->answer}}</textarea>
                            <label for="" class="form-label"> Answer</label>
                        </div>
                    </div>

                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
        <!-- form end-->
        @endif
    </div>
</div>

@endsection