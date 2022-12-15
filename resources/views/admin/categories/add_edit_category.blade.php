@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Categories</h3>
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
                  <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}"
                        @else action="{{ url('admin/add-edit-category/'.$category['id']) }}" @endif
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" id="category_name" 
                            placeholder="Enter Category Name" name="category_name"    
                            @if(!empty($category['category_name'])) value="{{ $category['category_name'] }}" 
                            @else value="{{ old('category_name') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="section_id">Select Section</label>
                        <select name="section_id" id="section_id" class="form-control" style="color: black">
                            <option value="">Select</option>
                            @foreach($getSections as $section)
                            <option value="{{ $section['id'] }}" @if(!empty($category['section_id']) && $category['section_id']==$section['id'])
                            selected="" @endif> {{ $section['name'] }} </option>
                            @endforeach
                        </select>
                      </div>
                      <div id="appendCategoriesLevel">
                        @include('admin.categories.append_categories_level')
                      </div>
                      <div class="form-group">
                        <label for="category_image">Category Photo</label>
                        <input type="file" class="form-control" id="category_image" name="category_image" >
                        @if(!empty($category['category_image']))
                        <a target="_blank" href="{{ url('front/images/category_images/'.$category['category_image']) }}">View Image</a> &nbsp; &nbsp; | &nbsp; &nbsp;
                          <a href="javascript:void(0)" class="confirmDelete" module="category-image" 
                          moduleid="{{$category['id']}}">Delete Image</a>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="category_discount">Category Discount</label>
                        <input type="text" class="form-control" id="category_discount" 
                            placeholder="Enter Category Discount" name="category_discount"    
                            @if(!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" 
                            @else value="{{ old('category_discount') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="description">Category Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" >
                        </textarea>
                      </div>
                      <div class="form-group">
                        <label for="url">Category URL</label>
                        <input type="text" class="form-control" id="url" 
                            placeholder="Enter Category URL" name="url"    
                            @if(!empty($category['url'])) value="{{ $category['url'] }}" 
                            @else value="{{ old('url') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" 
                            placeholder="Enter Meta Title" name="meta_title"    
                            @if(!empty($category['meta_title'])) value="{{ $category['meta_title'] }}" 
                            @else value="{{ old('meta_title') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control" id="meta_description" 
                            placeholder="Enter Meta Description" name="meta_description"    
                            @if(!empty($category['meta_description'])) value="{{ $category['meta_description'] }}" 
                            @else value="{{ old('meta_description') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" 
                            placeholder="Enter Meta Keywords" name="meta_keywords"    
                            @if(!empty($category['meta_keywords'])) value="{{ $category['meta_keywords'] }}" 
                            @else value="{{ old('meta_keywords') }}" @endif>
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