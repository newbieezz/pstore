<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetails;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //creating an array of vendorRecords
         $vendorRecords = [
            ['id'=>1, 'vendor_id'=>1, 'account_holder_name'=> 'Cherry Ann Veloso', 'bank_name'=>'China Bank',
                'account_number'=>'1234567890','bank_code'=>'12345'],
        ];
        VendorsBankDetails::insert($vendorRecords);
    }
}
