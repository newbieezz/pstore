<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getFilterName($filter_id){
        $getFilterName = ProductsFilter::select('filter_name')->where('id',$filter_id)->first();
        
        return  $getFilterName->filter_name;
    }

    public function filter_values(){
        //one filter column can has one or many values
        return $this->hasMany('App\Models\ProductsFiltersValue','filter_id');
    }

    //fetch alll the filters to show on the sidebar
    public static function productFilters(){
        $productFilters = ProductsFilter::with('filter_values')->where('status',1)->get()->toArray();
        // dd($productFilters);
        return $productFilters;
    }

    public static function filterAvailable($filter_id, $category_id){
        $filterAvailable = ProductsFilter::select('cat_ids')->where(['id'=>$filter_id,'status'=>1])->first()->toArray();
        $catIdsArr = explode(",",$filterAvailable['cat_ids']);
        //check wether the catefory_id is matching in the catIds Array/ show categories under the same catIds
        if(in_array($category_id,$catIdsArr)){
            $available = "Yes";
        } else {
            $available = "No";
        }
        return $available;
    }

    //get the sizes for every category
    public static function getSizes($url){
        //fetch the category details from the url (use the function from category model)
        $categoryDetails = Category::categoryDetails($url); //fetcht eh category ids from this function
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])->pluck('id')->toArray();
        $getProductSizes = ProductsAttribute::select('size')->whereIn('product_id',$getProductIds)->groupBy('size')->pluck('size')->toArray();//only gets the size from the products attribut table
   
        return $getProductSizes;
     }

    //get the brands for every category
    public static function getBrands($url){
        //fetch the category details from the url (use the function from category model)
        $categoryDetails = Category::categoryDetails($url); //fetcht eh category ids from this function
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])->pluck('id')->toArray();
        $brandIds = Product::select('brand_id')->whereIn('id',$getProductIds)->groupBy('brand_id')->pluck('brand_id')->toArray();
        $brandDetails = Brand::select('id','name')->whereIn('id',$brandIds)->get()->toArray();
        //echo "<pre>";print_r($brandDetails);die;
        return $brandDetails;
     }

}
