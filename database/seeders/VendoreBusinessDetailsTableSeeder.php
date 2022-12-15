<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetails;

class VendoreBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   //creating an array of vendorRecords
        $vendorRecords = [
            ['id'=>1, 'vendor_id'=>1, 'shop_name'=> 'Raketship Mart', 'shop_address'=>'398-K Jones Avenue',
                'shop_city'=>'Cebu City','shop_pincode'=>'110001','shop_mobile'=>'09280442135',
                'shop_website'=>'sitemakers.in','address_proof'=>'Passport','address_proof_image'=>'test.jpg','business_license_number'=>'23156489',
                'business_permit_image'=>'permit.jpg'],
        ];
        VendorsBusinessDetails::insert($vendorRecords);
    }
}
