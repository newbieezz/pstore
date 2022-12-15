<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get()->toArray();

        return view('admin.categories.categories')->with(compact('categories'));
    }

     // Update Category Status
    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
             $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                    $status = 0;
            } else{
                    $status = 1;
            }
                Category::where('id',$data['category_id'])->update(['status'=>$status]);
                //return details into the ajax response so we can add the response as well
                return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
         }
    }
    
    // Add-Edit Category
    public function addEditCategory(Request $request, $id=null){
        Session::put('page','categories');
        if($id==""){
            // Add Category Functionality
            $title = "Add Category";
            $category = new Category;
            $getCategories = array();
            $message = "Category added successfully!";
        } else {
            // Edit Functionality
            $title = "Edit Category";
            $category = Category::find($id);
            //getting the categories along with then subcategory, gets the subcategories also
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$category['section_id']])->get();
            $message = "Category updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            // Array of Validation Rules
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];
            $customMessages = [
                'category_name.required' => 'Category Name is required!',
                'category_name.regex' => 'Valid Category Name is required!',
                'section_id.required' => 'Section is required!',
                'url.required' => 'Category URL is required!',
            ];
                $this->validate($request,$rules,$customMessages);

            if($data['category_discount']==""){
                $data['category_discount'] =0;
            }

                // Upload Category Image/Photo
                if($request->hasFile('category_image')){
                    $image_tmp = $request->file('category_image');
                    if($image_tmp->isValid()){
                        // Building function to get the image extension of the file
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new image name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'front/images/category_images/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                        // Save the Image
                        $category->category_image = $imageName;
                    }
                } else {
                    $category->category_image = "";
                }

                $category->section_id = $data['section_id'];
                $category->parent_id = $data['parent_id'];
                $category->category_name = $data['category_name'];
                $category->category_discount = $data['category_discount'];
                $category->description = $data['description'];
                $category->url = $data['url'];
                $category->meta_title= $data['meta_title'];
                $category->meta_description = $data['meta_description'];
                $category->meta_keywords = $data['meta_keywords'];
                $category->status = 1;
                $category->save();

                return redirect('admin/categories')->with('success_message', $message);
        }

        $getSections = Section::get()->toArray();

        return view('admin.categories.add_edit_category')->with(compact('title','category','getSections','getCategories'));
    }

    // function for the Append Category Level
    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$data['section_id']])->get();
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }    
    }

    // delete category
    public function deleteCategory($id){
        Session::put('page','categories');
        //delete from categories table by id
        Category::where('id',$id)->delete();
        $message = "Category has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }

    // delete category image
    public function deleteCategoryImage($id){
        Session::put('page','categories');
        //get the data first
        $categoryImage = Category::select('category_image')->where('id',$id)->first();
       //then set the path of category image
       $category_image_path = 'front/images/category_images/';
       //delete category image from folder if exist
       if(file_exists($category_image_path.$categoryImage->category_image)){
          //use of unlink-to delete from the folder
          unlink($category_image_path.$categoryImage->category_image);
       } 
       //after deleting from the folder, delete it from the categories folder
       Category::where('id',$id)->update(['category_image'=>'']); //updating the image name to null 
       
       $message = "Category Image has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }
}
