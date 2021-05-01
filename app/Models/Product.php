<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'qty',
        'categories_id',
        'brands_id',
        'photo'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category',  'categories_id');
    }
    
    public function brand(){
        return $this->belongsTo('App\Models\Brand',  'brands_id');
    }

    public static function getDataProducts()
    {
        $products = Product::all();
        $products_filter = [];
        $no=1;

        for($i=0; $i<$products->count(); $i++){
            $products_filter[$i]['no'] = $no++;
            $products_filter[$i]['name'] = $products[$i]->name;
            $products_filter[$i]['qty'] = $products[$i]->qty;
            $products_filter[$i]['categories_id'] = $products[$i]->categories_id;
            $products_filter[$i]['brands_id'] = $products[$i]->brands_id;
            $products_filter[$i]['photo'] = $products[$i]->photo;
        }

        return $products_filter;
    }
}
