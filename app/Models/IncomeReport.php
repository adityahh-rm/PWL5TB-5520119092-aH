<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeReport extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'qty',
    ];
    
    public function product(){
        return $this->belongsTo('App\Models\Product',  'products_id');
    }

}
