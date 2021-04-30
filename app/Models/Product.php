<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static function getDataProducts()
    {
        $products = Product::all();
        $products_filter = []; //Disimpan dalam bentuk Array
        $no=1;

        for($i=0; $i<$products->count(); $i++){
            $products_filter[$i]['no'] = $no++;
            $products_filter[$i]['name'] = $products[$i]->name;
            $products_filter[$i]['qty'] = $products[$i]->qty;
            $products_filter[$i]['brands_id'] = $products[$i]->brands_id;
            $products_filter[$i]['categories_id'] = $products[$i]->categories_id;
            $products_filter[$i]['photo'] = $products[$i]->photo;
        }

        return $products_filter;
    }
}
