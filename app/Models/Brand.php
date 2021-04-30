<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public static function getDataBrand()
    {
        $brands = Brand::all();
        $brands_filter = [];
        $no=1;

        for($i=0; $i<$brands->count(); $i++){
            $brands_filter[$i]['no'] = $no++;
            $brands_filter[$i]['name'] = $brands[$i]->name;
            $brands_filter[$i]['description'] = $brands[$i]->description;
        }

        return $brands_filter;
    }
}
