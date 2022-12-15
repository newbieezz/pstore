@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Vendor Details</h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/vendor') }}">Back to Vendors</a></h6>
                    </div>
                </div>
            </div>
        </d iv>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Personal Information </h4>
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control" readonly="" @if(isset($vendorDetails['vendor_personal']['email'])) value="{{ $vendorDetails['vendor_personal']['email'] }}" @endif> 
                    </div>
                    <div class="form-group">
                        <label for="vendor_name">Name</label>
                        <input type="text" class="form-control"readonly=""  @if(isset($vendorDetails['vendor_personal']['name'])) value="{{ $vendorDetails['vendor_personal']['name'] }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="vendor_address">Address</label>
                        <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_personal']['address'])) value="{{ $vendorDetails['vendor_personal']['address'] }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="vendor_city">City</label>
                        <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_personal']['city'])) value="{{ $vendorDetails['vendor_personal']['city'] }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="vendor_zipcode">ZipCode</label>
                        <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_personal']['zipcode'])) value="{{ $vendorDetails['vendor_personal']['zipcode'] }}" @endif>
                      </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Mobile</label>
                      <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_personal']['mobile'])) value="{{ $vendorDetails['vendor_personal']['mobile'] }}" @endif>
                    </div>
                    @if(!empty($vendorDetails['image']))
                    <div class="form-group">
                        <label for="vendor_image">Photo</label>
                        <br>
                        <img style="width:200px;" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}"></img>
                      </div>
                    @endif
                  </form>
                </div>
              </div>
            </div> 
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Shop Information </h4>
                      <div class="form-group">
                        <label>Shop Name</label>
                        <input class="form-control" readonly="" @if(isset($vendorDetails['vendor_business']['shop_name'])) value="{{ $vendorDetails['vendor_business']['shop_name']}}" @endif> 
                      </div>
                      <div class="form-group">
                          <label for="vendor_name">Shop Address</label>
                          <input type="text" class="form-control"readonly="" @if(isset($vendorDetails['vendor_business']['shop_address'])) value="{{ $vendorDetails['vendor_business']['shop_address']}}" @endif>
                        </div>
                        <div class="form-group">
                          <label for="vendor_address">Shop City</label>
                          <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_business']['shop_city'])) value="{{ $vendorDetails['vendor_business']['shop_city']}}" @endif>
                        </div>
                        <div class="form-group">
                          <label for="vendor_pincode">Shop Pin Code</label>
                          <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_business']['shop_pincode'])) value="{{ $vendorDetails['vendor_business']['shop_pincode']}}" @endif>
                        </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Shop Mobile</label>
                        <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_business']['shop_mobile'])) value="{{ $vendorDetails['vendor_business']['shop_mobile']}}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="vendor_name">Shop Website</label>
                        <input type="text" class="form-control"readonly="" @if(isset($vendorDetails['vendor_business']['shop_website'])) value="{{ $vendorDetails['vendor_business']['shop_website']}}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="address_proof">Vendor Address Proof</label>
                        <input type="text" class="form-control" readonly="" @if(isset( $vendorDetails['vendor_business']['address_proof'])) value="{{ $vendorDetails['vendor_business']['address_proof'] }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="business_license_number">Business License Number </label>
                        <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_business']['shop_pincode'])) value="{{  $vendorDetails['vendor_business']['shop_pincode'] }}" @endif>
                      </div>
                      @if(!empty($vendorDetails['vendor_business']['address_proof_image']))
                        <div class="form-group">
                            <label for="vendor_image">Address Proof Image</label>
                            <br>
                            <img style="width:200px;" src="{{ url('admin/images/proofs/'.$vendorDetails['vendor_business']['address_proof_image'] ) }}"></img>
                          </div>
                      @else 
                        <div class="form-group">
                          <label for="vendor_image">Address Proof Image</label>
                          <br>
                          <img style="width:200px;" src="{{ url('admin/images/photos/noimage.gif') }}"></img>
                        </div>
                      @endif
                    </form>
                  </div>
                </div>
              </div>       
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Bank Information </h4>
                      <div class="form-group">
                        <label>Account Holder Name</label>
                        <input class="form-control" readonly="" @if(isset($vendorDetails['vendor_bank']['account_holder_name']))value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" @endif> 
                      </div>
                      <div class="form-group">
                          <label for="vendor_name">Bank Name</label>
                          <input type="text" class="form-control"readonly="" @if(isset($vendorDetails['vendor_bank']['bank_name'] ))value="{{ $vendorDetails['vendor_bank']['bank_name'] }}" @endif>
                        </div>
                        <div class="form-group">
                          <label for="vendor_address">Account Number</label>
                          <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_bank']['account_number'] ))value="{{  $vendorDetails['vendor_bank']['account_number'] }}" @endif>
                        </div>
                        <div class="form-group">
                          <label for="vendor_city">Bank SWIFT Code</label>
                          <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['vendor_bank']['bank_swift_code']))value="{{  $vendorDetails['vendor_bank']['bank_swift_code'] }}" @endif>
                        </div>
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