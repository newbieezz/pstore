<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id'=>1, 'section_id'=>4, 'category_id'=>9, 'brand_id'=>5, 'vendor_id'=>2
            , 'admin_type'=>'vendor', 'product_name'=>'Coke', 'product_code'=>'CC1', 'product_price'=>'39.00'
            , 'product_discount'=>'0', 'product_image'=>'', 'product_video'=>''
            , 'description'=>'Coke 325ml Can', 'meta_title'=>'', 'meta_keywords'=>''
            , 'meta_description'=>'', 'is_featured'=>'Yes', 'status'=>1],
            ['id'=>2, 'section_id'=>4, 'category_id'=>9, 'brand_id'=>5, 'vendor_id'=>2
            , 'admin_type'=>'vendor', 'product_name'=>'Royal', 'product_code'=>'K1', 'product_price'=>'84.00'
            , 'product_discount'=>'0', 'product_image'=>'', 'product_video'=>''
            , 'description'=>'Knorr Liquid Seasoning Chili 130ml', 'meta_title'=>'', 'meta_keywords'=>''
            , 'meta_description'=>'', 'is_featured'=>'Yes', 'status'=>1]
        ];

        Product::insert($productRecords);
    }
}
