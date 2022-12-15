<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFilter;


class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding dummy records
        $filterRecords = [
            ['id'=>1, 'cat_ids'=>'1,6,7,8,9,10,11,12,13,14,21,30,31', 'filter_name'=>'Brand', 'filter_column'=>'brand', 'status'=>1],
            ['id'=>2, 'cat_ids'=>'15,16,17,18,19,20', 'filter_name'=>'Weigh', 'filter_column'=>'weigh', 'status'=>1],
        ];

        ProductsFilter::insert($filterRecords);
    }
}
