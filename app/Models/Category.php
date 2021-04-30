<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public static function getDataCategory()
    {
        $categories = Category::all();
        $categories_filter = []; //Disimpan dalam bentuk Array
        $no=1;

        for($i=0; $i<$categories->count(); $i++){
            $categories_filter[$i]['no'] = $no++;
            $categories_filter[$i]['name'] = $categories[$i]->name;
            $categories_filter[$i]['description'] = $categories[$i]->description;
        }

        return $categories_filter;
    }
}
