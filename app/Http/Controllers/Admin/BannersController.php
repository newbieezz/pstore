<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get()->toArray();

        return view('admin.banners.banners')->with(compact('banners'));
    }

    //update banner status
    public function updateBannerStatus(Request $request){
        Session::put('page','banners');
        if($request->ajax()){
            $data = $request->all();
           //making the inactive->active, vice versa
           if($data['status']=="Active"){
                   $status = 0;
           } else{
                   $status = 1;
           }
               Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
               //return details into the ajax response so we can add the response as well
               return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }

    // delete banner
    public function deleteBanner($id){
        Session::put('page','banners');
        //get banner image
        $bannerImage = Banner::where('id',$id)->first();
        //get banner image path
        $banner_image_path = 'front/images/banner_images/';

        //delete if image exists inside the folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        //delete from table
        Banner::where('id',$id)->delete();
        $message = "Banner has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }

    //Add-Edit Banner
    public function addEditBanner(Request $request, $id=null){
        Session::put('page','banners');

        if($id==""){
            Session::put('page','banners');
            // Add Banner Functionality
            $title = "Add Banner Image";
            $banner = new Banner;
            $getBanners = array();
            $message = "Banner added successfully!";
        } else {
            Session::put('page','banners');
            // Edit Functionality
            $title = "Edit Banner Image";
            $banner = Banner::find($id);
            $message = "Banner updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();

                $banner->type = $data['type'];
                $banner->link = $data['link'];
                $banner->title = $data['title'];
                $banner->alt = $data['alt'];
                $banner->status = 1;

                if($data['type']=="Slider"){
                    $width = "1920";
                    $height = "720";
                }else if($data['type']=="Fix"){
                    $width = "1920";
                    $height = "420";
                }

            // Upload banner Image/Photo
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    // Building function to get the image extension of the file
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/banner_images/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);
                    // Save the Image
                    $banner->image = $imageName;
                }
            } else {
                $banner->image = "";
            }

            $banner->save();

            return redirect('admin/banners')->with('success_message', $message);
        }

        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }
}
