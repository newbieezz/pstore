<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\ProductsAttribute;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; //debug to check if data passes
                //fetch current url route
                $url = $data['url'];
                $_GET['sort'] = $data['sort'];
                //check if url exist in category table or not
                $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
                if($categoryCount > 0) {
                    //get category details
                    $categoryDetails = Category::categoryDetails($url);
                    //fetch all the products in the category with use of simple pagination
                    $categoryProducts = Product::with('brands')->whereIn('category_id',$categoryDetails['catIds'])
                                        ->where('status',1);

                    //checking for (filter) dynamically 
                    $productFilters = ProductsFilter::productFilters(); //fetching the product filters
                    foreach($productFilters as $key => $filter){
                        //if particular filter is selected then check if it's coming(calue will come in $data)
                        if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && 
                            !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){

                            $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                        }
                    }     

                    //checking for size (product attribute)
                    if(isset($data['size']) && !empty($data['size'])){
                        $productIds = ProductsAttribute::select('product_id')->whereIn('size',$data['size'])
                                      ->pluck('product_id')->toArray();//fetching th product Ids
                        $categoryProducts->whereIn('products.id',$productIds);
                    }

                    //checking for price
                    if(isset($data['price']) && !empty($data['price'])){
                        foreach($data['price'] as $key => $price){
                            $priceArray = explode('-',$price);//every price will convert to an element of an array
                            $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArray[0],$priceArray[1]])
                                            ->pluck('id')->toArray();//fetching th product Ids

                        }
                        $productIds = call_user_func_array('array_merge',$productIds);//merge all the products into one array
                        $categoryProducts->whereIn('products.id',$productIds);
                    }

                    //checking for product brand
                    if(isset($data['brands']) && !empty($data['brands'])){
                        $productIds = Product::with('brands')->select('id')->whereIn('brand_id',$data['brands'])
                                      ->pluck('id')->toArray();//fetching th product Ids
                        $categoryProducts->whereIn('products.id',$productIds);
                    }

                    //condition for sorting
                    if(isset($_GET['sort']) && !empty($_GET['sort'])){
                        if($_GET['sort']=="product_latest"){
                            //if true, show latest product in desc order
                            $categoryProducts->orderby('products.id','Desc');
                        } else if($_GET['sort']=="price_lowest"){
                            //show in asscending then compare the price
                            $categoryProducts->orderby('products.product_price','Asc');
                        } else if($_GET['sort']=="price_highest"){
                            //show in asscending then compare the price
                            $categoryProducts->orderby('products.product_price','Desc');
                        } else if($_GET['sort']=="name_a_z"){
                            //show name in asscending 
                            $categoryProducts->orderby('products.product_name','Asc');
                        } else if($_GET['sort']=="name_z_a"){
                            //show name in desc
                            $categoryProducts->orderby('products.product_name','Desc');
                        }
                    }               

                    $categoryProducts = $categoryProducts->paginate(20);

                    return view('front.products.product_listing')->with(compact('categoryDetails','categoryProducts','url'));
                } else {
                    abort(404);
                }
        } else{
            //fetch current url route
            $url = Route::getFacadeRoot()->current()->uri();
            //check if url exist in category table or not
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount > 0) {
                //get category details
                $categoryDetails = Category::categoryDetails($url);
                //fetch all the products in the category with use of simple pagination
                $categoryProducts = Product::with('brands')->whereIn('category_id',$categoryDetails['catIds'])
                                    ->where('status',1);
                //condition for sorting
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        //if true, show latest product in desc order
                        $categoryProducts->orderby('products.id','Desc');
                    } else if($_GET['sort']=="price_lowest"){
                        //show in asscending then compare the price
                        $categoryProducts->orderby('products.product_price','Asc');
                    } else if($_GET['sort']=="price_highest"){
                        //show in asscending then compare the price
                        $categoryProducts->orderby('products.product_price','Desc');
                    } else if($_GET['sort']=="name_a_z"){
                        //show name in asscending 
                        $categoryProducts->orderby('products.product_name','Asc');
                    } else if($_GET['sort']=="name_z_a"){
                        //show name in desc
                        $categoryProducts->orderby('products.product_name','Desc');
                    }
                }               

                $categoryProducts = $categoryProducts->paginate(20);

                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            } else {
                abort(404);
            }
        }

    }

    //detail.blade.php list of products details
    public function detail($id){
        $productDetails = Product::with(['section','category','attributes'=>function($query){
                            $query->where('stock','>',0)->where('status',1);
                         },'images','brands','vendor'])->find($id)->toArray();
        //call category for the breadcrumbs, pass the urlt o get the complete category details
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        // dd($productDetails);

        //get related/similar products ids
        $similarProducts = Product::with('brands')->where('category_id',$productDetails['category']['id'])
                            ->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();

        //set sessio for recently viewed products
        if(empty(Session::get('session_id'))){ //if empty then create variable session_id
            $session_id = rand(10000,10000000);
        } else {
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id); 

        //insert product in table if not already exists, count recent;y viewd products first
        $countRVP = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRVP==0){
            date_default_timezone_set("Asia/Taipei");
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id,
                        'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]); //insert in the table
        }
        //get recently viewed products,fetch the id from the table
        $recentProductsId = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)
                            ->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');

        //fetch the porducts, get recently viewed products
        $recenltyViewedProd = Product::with('brands')->whereIn('id',$recentProductsId)->get()->toArray();

        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
        return view('front.products.product_details')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recenltyViewedProd'));
    }

    //get the price
    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function vendorListing($vendorid){
        //fetch/get vendor shop name
        $getVendorShop = Vendor::getVendorShop($vendorid);
        //get vendor products
        $vendorProducts = Product::with('brands')->where('vendor_id',$vendorid)->where('status',1);

        $vendorProducts = $vendorProducts->paginate(30);
        // dd($vendorProducts);
       return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
    }

    public function cartAdd(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            //check product stock is available or not
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'],$data['size']);
            //condition if stock less than number of product stock
            if($getProductStock<$data['quantity']){
                return redirect()->back()->wiwth('error_message','Required Quantity is not available!');
            }

            //generate session id if not exists
            $session_id = Session::get('session_id');//check
            if(empty($session_id)){
                $session_id = Session::getId(); //if not exist then generate
                Session::put('session_id',$session_id);
            }

            //check product if already exists in the user cart
            if(Auth::check()){ //check is the function used to chek if user exist/logged in or not
                //user is logged in, then count prods &compare user id
                $user_id = Auth::user()->id;//get user id
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();

            } else{
                //user is not logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();

            }

            if($countProducts>0){
                return redirect()->back()->with('error_message','Product already existed in Cart!');
            }
            //save/add products in carts table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            return redirect()->back()->with('success_message','Product has been added to Cart!');
        }
    }

    public function cart(){
        $getCartItems = Cart::getCartItems();
        // dd($getCartItems);
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function cartUpdate(Request $request){
        if($request->ajax()){
            $data = $request->all();

            //get cart details from cartid
            $cartDetails = Cart::find($data['cartid']);

            //get available product stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>
                    $cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();

            //check availability of stock
            if($data['qty'] > $availableStock['stock']){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Stock is not available!',
                    'view'=>(String)View::make('front.products.cart_items')
                     ->with(compact('getCartItems'))
             ]);
            }   

            //chech if product size is available
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],
                        'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize == 0){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Size is not available. Please remove this Product and choose another one!',
                    'view'=>(String)View::make('front.products.cart_items')
                     ->with(compact('getCartItems'))
                 ]);
            }

            //update qty in carts table
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems(); //call cartitems to pass

            return response()->json([
                   'status'=>true,
                   'view'=>(String)View::make('front.products.cart_items')
                    ->with(compact('getCartItems'))
            ]);
        }   
    }

    public function cartDelete(Request $request){
        if($request->ajax()){
            $data = $request->all();

            Cart::where('id',$data['cartid'])->delete();
            $getCartItems = Cart::getCartItems(); //call cartitems to pass

            return response()->json([
                   'view'=>(String)View::make('front.products.cart_items')
                    ->with(compact('getCartItems'))
            ]);
        }
    }
}
