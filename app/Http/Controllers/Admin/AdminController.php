<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetails;
use App\Models\VendorsBankDetails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }

    // function for the Update of Admin Password
    public function updateAdminPassword(Request $request){  
        Session::put('page','update_admin_password');
        if($request->isMethod('post')){
            $data = $request->all();

            // Check if current password entered by admin is correct
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                // Check if new password is matching with confirm password
                if($data['confirm_password']==$data['new_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>
                        bcrypt($data['new_password'])]);
                        return redirect()->back()->with('success_message','Password has been updated successfully!');
                }else{ 
                    return redirect()->back()->with('error_message','New and Confirm Password does not match!');
                }
            } else {
                return redirect()->back()->with('error_message','Your current password is Incorrect!');
            }
        }
          // get the admin details from the admin guard
          $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();

        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));

    }

    // function for the checking of Admin Password
    public function checkAdminPassword(Request $request){
        $data = $request->all();
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        } else {    
            return "false";
        }
    }

    public function updateAdminDetails(Request $request){
        Session::put('page','update_admin_details');
        if($request->isMethod('post')){
           $data = $request->all();

         // Array of Validation Rules
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];
                $customMessages = [
                    'admin_name.required' => 'Name is required!',
                    'admin_name.regex' => 'Valid Name is required!',
                    'admin_mobile.required' => 'Mobile is required!',
                    'admin_mobile.numeric' => 'Valid Mobile is required!',
                ];
                $this->validate($request,$rules,$customMessages);

                // Upload Admin Image/Photo
                if($request->hasFile('admin_image')){
                    $image_tmp = $request->file('admin_image');
                    if($image_tmp->isValid()){
                        // Building function to get the image extension of the file
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new image name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->save($imagePath);

                    }
                } else if(!empty($data['current_admin_image'])) {
                    $imageName = $data['current_admin_image'];
                } else {
                    $imageName = "";
                }

                 // Update Admin Details
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name']
                        ,'mobile'=>$data['admin_mobile'], 'image' => $imageName]);

                    return redirect()->back()->with('success_message','Admin details updated successfully!');
        }
        return view('admin.settings.update_admin_details');
    }

    // function for Vendor Details, Update and stuffs
    public function updateVendorDetails($slug, Request $request){
        Session::put('page','update_vendor_details');
        if($slug=="personal"){
            Session::put('page','personal');
            if($request->isMethod('post')){
                $data = $request->all();

                 // Array of Validation Rules
                $rules = [
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile' => 'required|numeric',
                    'vendor_zipcode' => 'required|numeric',
                ];
                    $customMessages = [
                        'vendor_name.required' => 'Name is required!',
                        'vendor_city.required' => 'City is required!',
                        'vendor_city.regex' => 'Name is required!',
                        'vendor_name.regex' => 'Valid City is required!',
                        'vendor_mobile.required' => 'Mobile is required!',
                        'vendor_mobile.numeric' => 'Valid Mobile is required!',
                        'vendor_zipcode.required' => 'Zipcode is required!',
                        'vendor_zipcode.numeric' => 'Valid Zipcode is required!',
                    ];
                    $this->validate($request,$rules,$customMessages);

                    // Upload Vendor Image/Photo
                    if($request->hasFile('vendor_image')){
                        $image_tmp = $request->file('vendor_image');
                        if($image_tmp->isValid()){
                            // Building function to get the image extension of the file
                            $extension = $image_tmp->getClientOriginalExtension();
                            // Generate new image name
                            $imageName = rand(111,99999).'.'.$extension;
                            $imagePath = 'admin/images/photos/'.$imageName;
                            // Upload the Image
                            Image::make($image_tmp)->save($imagePath);

                        }
                    } else if(!empty($data['current_vendor_image'])) {
                        $imageName = $data['current_vendor_image'];
                    } else {
                        $imageName = "";
                    }
                    $vendorCount = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->count();
                    if($vendorCount > 0 ){
                        // Update in Admins Table
                        Admin::where('id', Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name']
                                ,'mobile'=>$data['vendor_mobile'], 'image' => $imageName]);
                        // Update in Vendors Table
                        Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update(['name'=>$data['vendor_name']
                        ,'address'=>$data['vendor_address'],'city'=>$data['vendor_city'],'zipcode'=>$data['vendor_zipcode'],
                        'mobile'=>$data['vendor_mobile'] ]);
                        return redirect()->back()->with('success_message','Vendor details updated successfully!');
                    } else {
                        // Insert in Admins Table
                        Admin::insert(['id'=> Auth::guard('admin')->user()->id,'name'=>$data['vendor_name']
                                ,'mobile'=>$data['vendor_mobile'], 'image' => $imageName]);
                        // Insert in Vendors Table
                        Vendor::insert(['id'=> Auth::guard('admin')->user()->vendor_id,'name'=>$data['vendor_name']
                        ,'address'=>$data['vendor_address'],'city'=>$data['vendor_city'],'zipcode'=>$data['vendor_zipcode'],
                        'mobile'=>$data['vendor_mobile'] ]);
                        return redirect()->back()->with('success_message','Vendor details updated successfully!');
                    }

            }
            $vendorCount = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount > 0 ){
                $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            } else {
                $vendorDetails = array();
            }

        } else if($slug=="business"){
            Session::put('page','business');
            if($request->isMethod('post')){
                $data = $request->all();
                
                 // Array of Validation Rules
                $rules = [
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required|numeric',
                    'shop_pincode' => 'required|numeric',
                    'address_proof' => 'required',
                ];
                    $customMessages = [
                        'shop_name.required' => 'Shop Name is required!',
                        'shop_city.required' => 'City is required!',
                        'shop_city.regex' => 'Shop Name is required!',
                        'shop_name.regex' => 'Valid City is required!',
                        'shop_mobile.required' => 'Mobile is required!',
                        'shop_mobile.numeric' => 'Valid Mobile is required!',
                        'shop_pincode.required' => 'Mobile is required!',
                        'shop_pincode.numeric' => 'Valid Mobile is required!',
                    ];
                    $this->validate($request,$rules,$customMessages);

                    // Upload Shop Owner Address/Valid ID Image/Photo
                    if($request->hasFile('address_proof_image')){
                        $image_tmp = $request->file('address_proof_image');
                        if($image_tmp->isValid()){
                            // Building function to get the image extension of the file
                            $extension = $image_tmp->getClientOriginalExtension();
                            // Generate new image name
                            $imageName = rand(111,99999).'.'.$extension;
                            $imagePath = 'admin/images/proofs/'.$imageName;
                            // Upload the Image
                            Image::make($image_tmp)->save($imagePath);

                        }
                    } else if(!empty($data['current_address_proof'])) {
                        $imageName = $data['current_address_proof'];
                    } else {
                        $imageName = "";
                    }
                    $vendorCount = VendorsBusinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                    if($vendorCount > 0 ){
                        // Update in vendors_business_details Table
                        VendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name']
                        ,'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],
                        'shop_pincode'=>$data['shop_pincode'], 'shop_mobile'=>$data['shop_mobile'],'shop_website'=>$data['shop_website'],
                        'address_proof'=>$data['address_proof'], 'business_license_number'=>$data['business_license_number'],'address_proof_image'=>$imageName]);
                        return redirect()->back()->with('success_message','Vendor details updated successfully!');
                    } else {
                        // Insert in vendors_business_details Table
                        VendorsBusinessDetails::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'shop_name'=>$data['shop_name']
                        ,'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],
                        'shop_pincode'=>$data['shop_pincode'], 'shop_mobile'=>$data['shop_mobile'],'shop_website'=>$data['shop_website'],
                        'address_proof'=>$data['address_proof'], 'business_license_number'=>$data['business_license_number'],'address_proof_image'=>$imageName]);
                        return redirect()->back()->with('success_message','Vendor details updated successfully!');
                    }
            }
            $vendorCount = VendorsBusinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount > 0 ) {
                $vendorDetails = VendorsBusinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            } else { //empty array 
                $vendorDetails = array();
            }

        } else if($slug=="bank"){
            Session::put('page','bank');
            if($request->isMethod('post')){
                $data = $request->all();
                
                 // Array of Validation Rules
                $rules = [
                    'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'bank_name' => 'required',
                    'account_number' => 'required|numeric',
                    'bank_swift_code' => 'required',
                ];
                    $customMessages = [
                        'account_holder_name.required' => 'Account Holder Name is required!',
                        'account_holder_name.regex' => 'Account Holder Name is required!',
                        'bank_name.required' => 'Bank Name is required!',
                        'account_number.numeric' => 'Account Number is required!',
                        'bank_swift_code.required' => 'Swift Code is required!',
                    ];
                    $this->validate($request,$rules,$customMessages);
                    $vendorCount = $vendorDetails = VendorsBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                    if($vendorCount > 0) {
                        // Update in vendors_banks_details Table
                        VendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name']
                        ,'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_swift_code'=>$data['bank_swift_code']]);
                        return redirect()->back()->with('success_message','Vendor bank details updated successfully!');
                    } else {
                        // Update and Insert in vendors_banks_details Table
                        VendorsBankDetails::insert(['vendor_id'=> Auth::guard('admin')->user()->vendor_id,'account_holder_name'=>$data['account_holder_name']
                        ,'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_swift_code'=>$data['bank_swift_code']]);
                        return redirect()->back()->with('success_message','Vendor bank details updated successfully!'); 
                    }
            }
            $vendorCount = $vendorDetails = VendorsBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount > 0) {
                $vendorDetails = VendorsBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            } else { //empty array
                $vendorDetails = array();
            }
        }
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails'));
    }

    public function login(Request $request){

        //sends a request to get all data for login auth
        if($request->isMethod('post')){
            $data = $request->all();

            //Laravel validation
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            //For custom message show when error
            $customMessages = [
                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email Address is required',
                'password.required' => 'Password is required!',
            ];
            $this->validate($request,$rules,$customMessages);

            // if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1]))
            // {
            //     return redirect('/admin/dashboard');
            // }else{
            //     return redirect()->back()->with('error_message','Invalid Email or Password');
            // }

            // if email and pass is correct proceed to dashboard
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
            {
                //check wheter the user login is vendor or login
                if(Auth::guard('admin')->user()->type=="vendor" && Auth::guard('admin')->user()->confirm=="No"){
                    return redirect()->back()->with('error_message','Please confirm your email to activate your Vendor Account');
                } else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status=="0"){
                    return redirect()->back()->with('error_message','Your Admin account is not active!');
                } else {
                    return redirect('/admin/dashboard');
                }

            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }

        }
        return view('admin.login');
    }

    // function for the type of admins/ diff views 
    public function admins($type=null){
        $admins = Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type',$type);
            $title = ucfirst($type)."s"; //displays the type 
            Session::put('page','view_'.strtolower($title));
        } else {
            $title = "All Admins/Subadmins/Vendors";
            Session::put('page','view_all');    
        }
        $admins = $admins->get()->toArray();
        return view('admin.admins.admins')->with(compact('admins','title'));
    }

    // View Vendor Details by the Admin
    public function viewVendorDetails($id){
        Session::put('page','view_vendors');
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    // Update Admin Status
    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);

            $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();
            if($adminDetails['type']=="vendor" && $status==1){
                Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);
                //send approval email
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile']
                ];
                Mail::send('emails.vendor_approved',$messageData,function($message)use($email){
                    $message->to($email)->subject('Your Vendor Account is Approved!');
                });
            }

            //return details into the ajax response so we can add the response as well
            return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
        }
    }


    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
