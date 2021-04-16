<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    //Proses Import File
    protected $fillable =[
        'judul',
        'penulis',
        'tahun',
        'penerbit'
    ];

    public static function getDataBooks()
    {
        $books = Book::all();
        $books_filter = []; //Disimpan dalam bentuk Array
        $no = 1;
        for($i=0; $i < $books->count(); $i++){
            $books->filter[$i]['no'] = $no++;
            $books->filter[$i]['judul'] = $books[$i]->judul;
            $books->filter[$i]['penulis'] = $books[$i]->penulis;
            $books->filter[$i]['tahun'] = $books[$i]->tahun;
            $books->filter[$i]['penerbit'] = $books[$i]->penerbit;
        }

        return $books_filter;
    }
}
