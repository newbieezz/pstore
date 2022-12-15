<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function sections(){
        Session::put('page','sections');
        $sections = Section::get()->toArray();

        return view('admin.sections.sections')->with(compact('sections'));
    }   

    // Update Section Status
    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            //return details into the ajax response so we can add the response as well
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }

    // Delete Section
    public function deleteSection($id){
        Section::where('id',$id)->delete();
        $message = "Section has been deleted successfully";
        return redirect()->back()->with('success_message',$message);
    }
    // Add-Edit Section
    public function addEditSection(Request $request,$id=null){
        Session::put('page','sections');
        if($id==""){
            $title = "Add Section";
            $section = new Section;
            $message = "Section Added Successfully";
        } else {
            $title = "Edit Section";
            $section = Section::find($id);
            $message = "Section updated s   uccessfully";
        }
        
        if($request->isMethod('post')){
            $data = $request->all();

             // Array of Validation Rules
            $rules = [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                    'section_name.required' => 'Section Name is required!',
                    'section_name.regex' => 'Valid Section  Name is required!',
                ];
            $this->validate($request,$rules,$customMessages);
            $section->name = $data['section_name'];
            $section->status = 1;
            $section->save();

            return redirect('admin/sections')->with('successs_message',$message);
        }

        return view('admin.sections.add_edit_section')->with(compact('title','section'));
    }

}
