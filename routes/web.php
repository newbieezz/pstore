<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Route Group for the Admin and Login
//Admin is required to admin route links
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    //Admin Login Route 
    Route::match(['get','post'],'login','AdminController@login');

    //Addning the dashboard of the Admin Middleware
    Route::group(['middleware' => ['admin']], function() {
    //All this routes will come/execute after admin login
        //Admin Dashboard Route 
         Route::get('dashboard','AdminController@dashboard');

        // Update Admin Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');

         // Check Admin Password
         Route::post('check-admin-password','AdminController@checkAdminPassword'); //checkAdminPassword will be created in the AdminController

        // Update Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        // Update Vendor Details (slug will work for updates on all vendor such as personal, bank etc.)
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');

        // View Admin / Subadmins / Vendors
        Route::get('admins/{type?}','AdminController@admins');

        // Display/View Vendor Details by the Admin
        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');
         
        // Update Admin Status
        Route::post('update-admin-status','AdminController@updateAdminStatus');
        
        //Admin Logout
         Route::get('logout','AdminController@logout');


        // SECTIONS
        Route::get('sections','SectionController@sections');
        // Update Section Status
        Route::post('update-section-status','SectionController@updateSectionStatus');
        // Delete Section Functionality 
        Route::get('delete-section/{id}','SectionController@deleteSection');
        // Add Section Functionality 
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

        // CATEGORIES
        Route::get('categories','CategoryController@categories');
        // Update Category Status
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        // Add-Edit Category
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        // Get route for the subcategory
        Route::get('append-categories-level','CategoryController@appendCategoryLevel');
        // Delete Category Functionality 
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        // Delete Category Image Functionality 
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

        // BRANDS
        Route::get('brands','BrandController@brands');
        // Update Brand Status
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        // Delete Brand Functionality 
        Route::get('delete-brand/{id}','BrandController@deleteBrand');
        // Add Brand Functionality 
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

        // PRODUCtS
        Route::get('products','ProductsController@products');
        // Update Product Status
        Route::post('update-product-status','ProductsController@updateProductStatus');
        // Delete Product Functionality 
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        // Add-Edit Product
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        //Delete Image
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        //Delete Video
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

        //ATTRIBUTES
        Route::match(['get','post'],'add-edit-attributes/{id?}','ProductsController@addAttributes');
        // Update Attribute Status
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        // Delete Attribute Functionality 
        Route::get('delete-atttribute/{id}','ProductsController@deleteAttribute');
        // Edit/Update Attribute
        Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttributes');

        //IMAGES
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
         // Update Image Status
        Route::post('update-image-status','ProductsController@updateImageStatus');
        // Delete Image Functionality 
        Route::get('delete-image/{id}','ProductsController@deleteImage');

        //BANNERS
        Route::get('banners','BannersController@banners');
        // Update BannerStatus
        Route::post('update-banner-status','BannersController@updateBannerStatus');
         // Delete Banner Functionality 
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
        // Add-Edit Banner
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');

        //PRODUcT FILTERS
        Route::get('filters','FilterController@filters');
        Route::get('filters-value','FilterController@filtersValue');
        // Update Filter Status
        Route::post('update-filter-status','FilterController@updateFilterStatus');
        Route::post('update-filter-value-status','FilterController@updateFilterValueStatus');
        //Add-Edit Filter Column
        Route::match(['get','post'],'add-edit-filter/{id?}','FilterController@addEditFilter');
        //Add-Edit Filter Column Value
        Route::match(['get','post'],'add-edit-filter-value/{id?}','FilterController@addEditFilterValue');
        //For the categoryFilter
        Route::post('category-filters','FilterController@categoryFilters');
    });
});

//Route Group for the Front Views 
Route::namespace('App\Http\Controllers\Front')->group(function(){
    //Route for the Index page
    Route::get('/','IndexController@index');
    //dynamic routes for the product listing page fetch by category
    $catUrl = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach($catUrl as $key => $url) {
        Route::match(['get','post'],'/'.$url,'ProductController@listing');
    }

    //Show all Vendor Products
    Route::get('/products/{vendorid}','ProductController@vendorListing');
    //Product Detail Page
    Route::get('/product/{id?}','ProductController@detail');
    //Get product attribute price, change price by sizes
    Route::post('get-product-price','ProductController@getProductPrice');
    //Route for the Vendor Logn/Register
    Route::get('vendor/login-register','VendorController@loginRegister');  
    //Vendor Register
    Route::post('vendor/register','VendorController@vendorRegister');
    //Send Confirm link/ Confirm Vendor Account
    Route::get('vendor/confirm/{code}','VendorController@confirmVendor');
    //Add to Cart
    Route::post('cart/add','ProductController@cartAdd');
    //Cart Page 
    Route::get('cart','ProductController@cart');
    //Update cart item Quantity
    Route::post('cart/update','ProductController@cartUpdate');
    //Delete cart item 
    Route::post('cart/delete','ProductController@cartDelete');

    //User Login-Register
    Route::get('user/login-register','UserController@loginRegister');
    //User Register
    Route::post('user/register', 'UserController@userRegister');
    //User Login
    Route::post('user/login','UserController@userLogin');
    //User  Logout
    Route::get('user/logout','UserController@userlogout');
    //Confirm User Account
    Route::get('user/confirm/{code}','UserController@confirmAccount');
    //User Forgot Password
    Route::match(['get','post'],'user/forgot-password', 'UserController@forgotPassword');
    //User Account
    Route::match(['GET','POST'],'user/account', 'UserController@userAccount');
    //User Update Password
    Route::post('user/update-password','Usercontroller@userUpdatePassword');
});
