<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

//Tidak lagi menggunakan Collection karena Data dikirim menjadi Array

class ProductsExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array():array
    {
        return Product::getDataProducts();
    }

    public function headings():array
    {
        return [
            'No',
            'Name',
            'Category',
            'Merk',
            'Quantity',
            'Photo'
        ];
    }
}
