@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Attributes</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Attributes</h4>
                
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
                  <form class="forms-sample" action="{{ url('admin/add-edit-attributes/'.$product['id']) }}" 
                  method="post"> @csrf
                  <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}"
                        @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                            &nbsp; {{ $product['product_name'] }}
                      </div>
                      <div class="form-group">
                        <label for="product_code">Product Code</label>
                             &nbsp; {{ $product['product_code'] }}
                      </div>
                      <div class="form-group">
                        <label for="product_price">Product Price</label>
                             &nbsp; {{ $product['product_price'] }}
                      </div>
                      <div class="form-group">
                        <label for="product_image">Product Photo </label>
                            @if(!empty($product['product_image']))
                                <img style="width:120px;" src="{{ url('front/images/product_images/large/'.$product['product_image']) }}">
                            @else 
                                 <img style="width:120px;" src="{{ url('front/images/product_images/small/noimage.png') }}">
                            @endif
                      </div>
                      <div class="form-group">
                        <div class="field_wrapper">
                            <div>
                                <input type="text" name="size[]" placeholder="Size" style="width:120px;" required=""/>
                                <input type="text" name="weight[]" placeholder="Weight" style="width:120px;" required=""/>
                                <input type="text" name="sku[]" placeholder="SKU-Code" style="width:120px;" required=""/>
                                <input type="text" name="price[]" placeholder="Price" style="width:120px;" required=""/>
                                <input type="text" name="stock[]" placeholder="Stock" style="width:120px;" required=""/>
                                <a href="javascript:void(0);" class="add_button" title="Add field">  Add</a>
                            </div>
                        </div>
                      </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                    <br> <br>
                    <h4 class="card-title">Product Attributes</h4>
                    <form method="post" action="{{ url('admin/edit-attributes/'.$product['product_name']) }}"> @csrf
                    <table id="products" class="table table-bordered"> 
                    <thead> 
                      <tr> 
                          <th> ID </th> 
                          <th> Size </th> 
                          <th> Weight </th> 
                          <th> SKU-Code </th>  
                          <th> Price </th> 
                          <th> Stock </th>   
                          <th> Status </th> 
                      </tr> 
                    </thead> 
                    <tbody> 
                    @foreach ($product['attributes'] as $attribute)
                    <input type="text" style="display: none;" name="attributeId[]" value="{{ $attribute['id']}}">
                      <tr> 
                           <td> {{ $attribute['id']}}  </td> 
                           <td> {{ $attribute['size']}}  </td>
                           <td> {{ $attribute['weight']}}  </td> 
                           <td> {{ $attribute['sku']}}  </td>
                           <td> 
                               <input type="number" name="price[]" value="{{ $attribute['price']}}" required="" style="width:70px;">
                           </td>  
                           <td>
                            <input type="number" name="stock[]" value="{{ $attribute['stock']}}" required="" style="width:70px;"> 
                           </td>    
                           <td> @if($attribute['status']==1)   &nbsp;
                                  <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}"
                                      href="javascript:void(0)">  
                                  <i style="font-size:30px" class="mdi mdi-check-circle" status="Active"> </i> </a>
                                @else  &nbsp;
                                <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}"
                                      href="javascript:void(0)"> 
                                  <i style="font-size:30px" class="mdi mdi-check-circle-outline" status="Inactive"> </i> </a>
                                @endif
                          </td>                       
                      </tr> 
                      @endforeach
                    </tbody> 
                    </table> 
                      <button type="submit" class="btn btn-primary mr-2">Update Attributes</button>
                  </form>
                </div>
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