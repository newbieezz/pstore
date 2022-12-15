<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            ['id'=>1,'parent_id'=>0,'section_id'=>1,'category_name'=>'Fresh Goods','category_image'=>'','category_discount'=>0,
             'description'=>'','url'=>'freshGoods','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1,],
            ['id'=>2,'parent_id'=>0,'section_id'=>1,'category_name'=>'Frozen Goods','category_image'=>'','category_discount'=>0,
             'description'=>'','url'=>'frozenGoods','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1,],
            ['id'=>3,'parent_id'=>0,'section_id'=>1,'category_name'=>'Eggs & Dairy','category_image'=>'','category_discount'=>0,
             'description'=>'','url'=>'eggsDairy','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1,],
        ];
        Category::insert($categoryRecords);
    }
}
