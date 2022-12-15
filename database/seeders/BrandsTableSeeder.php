<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords = [
            ['id'=>1,'name'=>'Nestle','status'=>1],
            ['id'=>2,'name'=>'Del Monte','status'=>1],
            ['id'=>3,'name'=>'Dole','status'=>1],
            ['id'=>4,'name'=>'Knorr','status'=>1],
            ['id'=>5,'name'=>'Coca Cola','status'=>1],
            ['id'=>6,'name'=>'Nescafe','status'=>1],
            ['id'=>7,'name'=>'Colgate','status'=>1],
            ['id'=>8,'name'=>'Lucky Me','status'=>1],
        ];

        Brand::insert($brandRecords);
    }
}
