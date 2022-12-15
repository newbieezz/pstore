@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Settings</h3>
                    </div>
                </div>
            </div>
        </d iv>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Admin Password Form</h4>
                  
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
                  <form class="forms-sample" action="{{ url('admin/update-admin-password') }}"
                        method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm"> @csrf
                    <div class="form-group">
                      <label>Admin Username/Email</label>
                      <input class="form-control" readonly="" value="{{ $adminDetails['email']}}"> 
                    </div>
                    <div class="form-group">
                      <label>Admin Type</label>
                      <input class="form-control" readonly="" value="{{ $adminDetails['type']}}">
                    </div>
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" 
                            placeholder="Enter Current Password" name="current_password" required="">
                        <span id="check_password"></span>
                      </div>
                    <div class="form-group">
                      <label for="new_password">New Password</label>
                      <input type="password" class="form-control" id="new_password" 
                      placeholder="Enter New Password" name="new_password" required="">
                    </div>
                    <div class="form-group">
                      <label for="confrim_password">Confirm Password</label>
                      <input type="password" class="form-control" id="confirm_password" 
                      placeholder="Confrim New Password" name="confirm_password" required="">
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