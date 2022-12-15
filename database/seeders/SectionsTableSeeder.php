<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecords = [
            ['id'=>1,'name'=>'Goods','status'=>1],
            ['id'=>2,'name'=>'Health & Beauty','status'=>1],
            ['id'=>3,'name'=>'Supplies','status'=>1],
            ['id'=>4,'name'=>'Drinks','status'=>1],
        ];
        Section::insert($sectionRecords);
    }
}
