<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords = [
            ['id'=>1,'product_id'=>2,'size'=>'250ml','weight'=>250,'price'=>39.00,'stock'=>4,'sku'=>'CC2-250','status'=>1],
            ['id'=>2,'product_id'=>2,'size'=>'330ml','weight'=>330,'price'=>45.00,'stock'=>8,'sku'=>'CC2-330','status'=>1],
            ['id'=>3,'product_id'=>2,'size'=>'5000ml','weight'=>500,'price'=>56.00,'stock'=>6,'sku'=>'CC2-500','status'=>1],

        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}
