<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\facades\Storage;

use App\Models\Book;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('home', compact('user'));
    }

    // function untuk konten-BUKU
    public function books()
    {
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user', 'books'));
    }

    public function submit_book(Request $req)
    {
        $book = new Book; //objek dari Book

        //Field menjadi function -- data diambil dari inputan
        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if($req->hasFile('cover')) //Apakah akan menyertakan cover??
        {
            $extension = $req->file('cover')->extension(); //Menyimpan ekstensi dari file cover

            $filename = 'cover_buku_'.time().'.'.$extension; //Nama filenya

            $req->file('cover')->storeAs( 
                //Menyimpan file kedalam direktori
                'public/cover_buku', $filename
            ); //storage/app/public/cover_buku

            Storage::delete('public/cover_buku/'.$req->get('old_cover'));

            $book->cover = $filename; //menyimpan nama file pada kolom cover
        }

        $book->save(); //menyimpan semua value

        $notification = array(
            'message' => 'Data Buku Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification); //Hanya sekali proses saja
    }

    public function getDataBuku($id)
    {
        $buku = Book::find($id); //Berdasarkan primary key
        //Data dari model Book

        return response()->json($buku);
    }
}
