<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use App\Models\Section;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class FilterController extends Controller
{
    public function filters(){
        Session::put('page','filters');

        $filters = ProductsFilter::get()->toArray();

        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValue(){
        Session::put('page','filters');

        $filters_value = ProductsFiltersValue::get()->toArray();

        return view('admin.filters.filters_value')->with(compact('filters_value'));
    }

    // Update Filter Status
    public function updateFilterStatus(Request $request){
        if($request->ajax()){
            Session::put('page','filters');
            $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            ProductsFilter::where('id',$data['filter_id'])->update(['status'=>$status]);
            //return details into the ajax response so we can add the response as well
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    // Update FilterValue Status
    public function updateFilterValueStatus(Request $request){
        if($request->ajax()){
            Session::put('page','filters');
            $data = $request->all();
            //making the inactive->active, vice versa
            if($data['status']=="Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            ProductsFiltersValue::where('id',$data['filter_id'])->update(['status'=>$status]);
            //return details into the ajax response so we can add the response as well
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    // Add Edit Filter
    public function addEditFilter(Request $request, $id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Add Filter Columns";
            $filter = new ProductsFilter;
            $message = "Filter added successfully!";
        } else {
            $title = "Add Filter Columns";
            $filter = ProductsFilter::find($id);
            $message = "Filter updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            $cat_ids = implode(',',$data['cat_ids']);

            // save filer details in products_filters table
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->status = 1;
            $filter->save();

            // alter filter column in products table
            DB::statement('Alter table products add '.$data['filter_column'].' varchar(255) after description');
            return redirect('admin/filters')->with('success_message',$message);
        }

        //select category while adding the filter (every category has a specific filter)
        // get sections with categories and sub categories
        $categories = Section::with('categories')->get()->toArray();

        return view('admin.filters.add_edit_filter')->with(compact('title','categories','filter'));
    }

    // Add Edit Filter Value
    public function addEditFilterValue(Request $request, $id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Add Filter Value";
            $filter = new ProductsFiltersValue;
            $message = "Filter Value added successfully!";
        } else {
            $title = "Add Filter Column Values";
            $filter = ProductsFiltersValue::find($id);
            $message = "Filter Value updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;

            // save filer values details in products_filters_values table
            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = $data['filter_value'];
            $filter->status = 1;
            $filter->save();

            return redirect('admin/filters-value')->with('success_message',$message);
        }

        //get filters to show in the form
        $filters = ProductsFilter::where('status',1)->get()->toArray();

        return view('admin.filters.add_edit_filter_value')->with(compact('title','filters'));
    }

    //Reload CategoryFilters included in (add_edit_product)
    public function categoryFilters(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $category_id = $data['category_id'];
            return response()->json(['view'=>(String)View::make('admin.filters.category_filters')->with(compact('category_id'))]);
        }
    }
}
