@extends('backend.main.main')

@section('content')

<div class="pagetitle mt-3 mb-4">
    <h1 class="text-primary">
        Edit Contact 
        <span class="float-right">
            <a href="{{route('admin.contact.showcontact')}}"><button class="btn btn-primary">
                 <i class="fa fa-arrow-alt-circle-left"></i> Back</button></a>
        </span>
    </h1>
</div>

{{--Edit Contact Us--}}

<div class="pb-5 pt-2">
    <div class="card">
    @if (!empty($contact))
        @foreach ($contact as $contact_details)
          
                <!-- form -->
                <form action="{{route('admin.contact.showcontact.updatecontact',$contact_details->id)}}" method="post">
                    @csrf
                    <div class="card-body pb-3 p-3">
                    <div class="row">
                    <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                            <?php 
                                $customer_data= App\Models\Customer::all();
                                foreach ($customer_data as $key => $customer_data_list) {
                                    if($customer_data_list->id == $contact_details->customer_id){
                                        echo ' <input type="text" name="customer_id" value="'.$customer_data_list->username.'" class="form-control" placeholder="customer name"
                                        required>';
                                    }
                                }
                            ?>
                             <label for="" class="form-label">Customer Name <span style="color:red">*</span></label>
                            </div>
                            @error('customer_id')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                      <div class="col-md-6 col-12 pb-3">
                    <div class="form-floating">
                                <input type="text" name="subject" value="{{old('subject',$contact_details->subject)}}" class="form-control" placeholder="subject" required>
                                <label for="" class="form-label">Subject <span style="color:red">*</span></label>
                            </div>
                            @error('subject')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Message <span style="color:red">*</span></label>
                                <textarea name="message" cols="60" rows="5" class="form-control" style="width:100%" id=""
                                    placeholder="message">{{$contact_details->message}}</textarea>
                            </div>
                            @error('message')
                            <div class="text text-danger">{{$message}}</div>@enderror
                        </div>

                    </div>
                    <div>
                    <button type="submit" class="btn btn-primary">Save</button>
                        
                    </div>
                    </div>

                </form>
                <!-- form end-->
         
        @endforeach
    @endif
    </div>
    </div>

    <!-- /.card -->
</section>

@endsection