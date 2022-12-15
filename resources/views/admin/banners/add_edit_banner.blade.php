@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Home Page Banners</h3>
                    </div>
                </div>
            </div>
        </d iv>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
                
                  <!--Validation Error Message -->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     @endif
                  @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error: </strong> {{ Session::get('error_message')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  @if(Session::has('success_message'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success: </strong> {{ Session::get('success_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif
                  <form class="forms-sample" @if(empty($banner['id'])) action="{{ url('admin/add-edit-banner') }}"
                        @else action="{{ url('admin/add-edit-banner/'.$banner['id']) }}" @endif
                        method="post"enctype="multipart/form-data"> @csrf
                      
                     <div class="form-group">
                        <label for="link">Banner Type</label>
                        <select class="form-control" id="type" name="type" required="">
                          <option value="">Select</option>
                          <option @if(!empty($banner['type']) && $banner['type']=="Slider") selected="" @endif
                            value="Slider">Slider</option>
                          <option @if(!empty($banner['type']) && $banner['type']=="Fix") selected="" @endif
                            value="Fix">Fix</option>
                        </select>
                      </div>
                     <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" class="form-control" id="image" name="image" >
                        @if(!empty($banner['image']))
                        <a target="_blank" href="{{ url('front/images/banner_images/'.$banner['image']) }}">View Image</a> &nbsp; &nbsp; | &nbsp; &nbsp;
                          <a href="javascript:void(0)" class="confirmDelete" module="banner-image" 
                          moduleid="{{$banner['id']}}">Delete Image</a>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="link">Banner Link</label>
                        <input type="text" class="form-control" id="link" 
                            placeholder="Enter Banner Link" name="link"    
                            @if(!empty($banner['link'])) value="{{ $banner['link'] }}" 
                            @else value="{{ old('link') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="title">Banner Title</label>
                        <input type="text" class="form-control" id="title" 
                            placeholder="Enter Banner Title" name="title"    
                            @if(!empty($banner['title'])) value="{{ $banner['title'] }}" 
                            @else value="{{ old('title') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="alt">Banner Alternate Text</label>
                        <input type="text" class="form-control" id="alt" 
                            placeholder="Enter banner URL" name="alt"    
                            @if(!empty($banner['alt'])) value="{{ $banner['alt'] }}" 
                            @else value="{{ old('alt') }}" @endif>
                      </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection