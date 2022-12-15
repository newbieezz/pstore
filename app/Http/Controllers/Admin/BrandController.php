<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function Brands(){
        Session::put('page','brands');
        $brands = Brand::get()->toArray();

        return view('admin.brands.brands')->with(compact('brands'));
    }   

    // Update Brand Status
    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
            //return details into the ajax response so we can add the response as well
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
        }
    }

    // Delete Brand
    public function deleteBrand($id){
        Session::put('page','brands');
        Brand::where('id',$id)->delete();
        $message = "Brand has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }
    // Add-Edit Brand
    public function addEditBrand(Request $request,$id=null){
        Session::put('page','brands');
        if($id==""){
            $title = "Add Brand";
            $brand = new Brand;
            $message = "Brand Added Successfully";
        } else {
            Session::put('page','brands');
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = "Brand updated successfully";
        }
        
        if($request->isMethod('post')){
            $data = $request->all();

             // Array of Validation Rules
            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                    'brand_name.required' => 'Brand Name is required!',
                    'brand_name.regex' => 'Valid Brand  Name is required!',
                ];
            $this->validate($request,$rules,$customMessages);
            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();
            
            $message = "Brand updated successfully";
            return redirect('admin/brands')->with('successs_message',$message);
        }
        
        return view('admin.Brands.add_edit_brand')->with(compact('title','brand'));
    }
}
