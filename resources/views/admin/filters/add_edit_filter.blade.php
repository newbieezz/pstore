@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Filters</h3>
                    </div>
                </div>
            </div>
        </div>
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
                  <form class="forms-sample" @if(empty($filter['id'])) action="{{ url('admin/add-edit-filter') }}"
                  @else action="{{ url('admin/add-edit-filter/'.$filter['id']) }}" @endif
                  method="post"enctype="multipart/form-data"> @csrf
                  <div class="form-group">
                    <label for="cat_ids">Select Category</label>
                    <select name="cat_ids[]" id="cat_ids" class="form-control text-dark" multiple="" style="height: 200px;">
                        <option value="">Select</option>
                        @foreach($categories as $section) <!--SECTIONS -->
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach($section['categories'] as $category) <!--CATEGORY -->
                            <option @if(!empty($filter['category_id']==$category['id'])) selected="" @endif
                              value="{{ $category['id'] }}">&nbsp;&nbsp;&raquo;&nbsp;{{ $category['category_name'] }}</option>
                            @foreach($category['subcategories'] as $subcategory) <!-- SUBCATEGORY -->
                            <option @if(!empty($filter['category_id']==$subcategory['id'])) selected="" @endif
                              value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}</option>
                              @endforeach
                            @endforeach
                        @endforeach
                    </select>
                  </div>
                  <form class="forms-sample" @if(empty($filter['id'])) action="{{ url('admin/add-edit-filter') }}"
                        @else action="{{ url('admin/add-edit-filter/'.$filter['id']) }}" @endif
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                        <label for="filter_name">Filter Name</label>
                        <input type="text" class="form-control" id="filter_name" 
                            placeholder="Enter filter Name" name="filter_name"    
                            @if(!empty($filter['filter_name'])) value="{{ $filter['filter_name'] }}" 
                            @else value="{{ old('filter_name') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="filter_column">Filter Column</label>
                        <input type="text" class="form-control" id="filter_column" 
                            placeholder="Enter filter column" name="filter_column"    
                            @if(!empty($filter['filter_column'])) value="{{ $filter['filter_column'] }}" 
                            @else value="{{ old('filter_column') }}" @endif>
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