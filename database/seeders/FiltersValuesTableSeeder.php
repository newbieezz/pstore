<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFiltersValue;

class FiltersValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filtersValueRecords = [
            ['id'=>1, 'filter_id'=>1, 'filter_value'=>'Luckyme', 'status'=>1],
            ['id'=>2, 'filter_id'=>1, 'filter_value'=>'Knorr', 'status'=>1],
            ['id'=>3, 'filter_id'=>2, 'filter_value'=>'1 Kg', 'status'=>1],
        ];
        ProductsFiltersValue::insert($filtersValueRecords);
    }
}
