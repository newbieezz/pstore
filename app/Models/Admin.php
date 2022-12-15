<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $guard = 'admin';

    // Creating a relation to vendors_personal
    public function vendorPersonal(){
        return $this->belongsTo('App\Models\Vendor','vendor_id');
    } 
        // Creating a relation to vendors_business/shop
    public function vendorBusiness(){
        return $this->belongsTo('App\Models\VendorsBusinessDetails','vendor_id');
    } 

        // Creating a relation to vendors_bank
    public function vendorBank(){
        return $this->belongsTo('App\Models\VendorsBankDetails','vendor_id');
    } 
}
