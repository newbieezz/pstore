<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function categories(){
        //every section has one to many categories together with the subcategories
        return $this->hasMany('App\Models\Category','section_id')->where(['parent_id'=>0,'status'=>1])
        ->with('subcategories');
    }

    //static function to use on the front/index header
    public static function sections(){                  //convert into array of data-toArray()
        $getSections= Section::with('categories')->where('status','1')->get()->toArray(); //show only avtive sections
       
        return $getSections;
    }
}
