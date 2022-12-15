<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    public function section(){
        //every product belongs to a section
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function category(){
        //every product belongs to a category
        return $this->belongsTo('App\Models\Category','category_id');
    }

    //relation to attributes
    public function attributes(){
        //one product can have many attributes
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images(){
        //one product can have many images
        return $this->hasMany('App\Models\ProductsImage');
    }

    //relation between vendor and product
    public function vendor(){
        //a product belongs to a vendor
        return $this->belongsTo('App\Models\Vendor','vendor_id')->with('vendorshopdetails');
    }

    //for the product discount, static to call it anywhere such as model controller etc
    public static function getDiscountedPrice($product_id){
        $proDetails = Product::select('product_price','product_discount','category_id')->where
                      ('id',$product_id)->first();
        //use array json to avoid more issue rather than using toArray
        $proDetails = json_decode(json_encode($proDetails),true);
        //fetch the category of the product
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);
   
        //condition to compare if a product is having a product discount or not
        if($proDetails['product_discount'] > 0) {
            //if added and exist, calculate the discounted price
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*
                                $proDetails['product_discount']/100);

        } else if($catDetails['category_discount'] > 0){
            //if product is not but category discount is added
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*
                                 $catDetails['category_discount']/100);

        } else {
            $discounted_price = 0;
        }

        return $discounted_price;
    }
    public static function getDiscountAttributePrice($product_id,$size){
        $proAttrPrice = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        //get product and category discount, fetch it from products table
        $proDetails = Product::select('product_discount','category_id')->where
                      ('id',$product_id)->first();//main price from here
        $proDetails = json_decode(json_encode($proDetails),true);
        //fetch the category of the product
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);

         //condition to compare if a product is having a product discount or not
         if($proDetails['product_discount'] > 0) {
            //if added and exist, calculate the discounted price
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price']*
                                $proDetails['product_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price;
        } else if($catDetails['category_discount'] > 0){
            //if product is not but category discount is added
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price']*
                                 $catDetails['category_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price;
        } else {
            $final_price = $proAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price'=>$proAttrPrice['price'],'final_price'=>$final_price,'discount'=>$discount);
    }
    // public function brand(){
    //     //every product belongs to some brand
    //     return $this->belongsTo('App\Models\Brand','brand_id');
    // }
    public function brands(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
    public static function isProductNew($product_id){
        //get the latest products added
        $productIds = Product::select('id')->where('status',1)->orderby('id','Desc')->Limit(4)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        
        if(in_array($product_id,$productIds)){
            $isProductNew = "Yes";
        } else {
            $isProductNew = "No";
        }

        return $isProductNew;
    }
}
