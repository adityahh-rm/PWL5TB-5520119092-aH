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

    //function untuk submit-BUKU
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

            $book->cover = $filename; //menyimpan nama file pada kolom cover
        }

        $book->save(); //menyimpan semua value

        $notification = array(
            'message' => 'Data Buku Berhasil Ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification); //Hanya sekali proses saja
    }

    // Function untuk mengambil ID pada setiap x yang ada
    public function getDataBuku($id)
    {
        $buku = Book::find($id); //Berdasarkan primary key
        //Data dari model Book

        return response()->json($buku);
    }

    // function untuk update-BUKU
    public function update_book(Request $req)
    {
        $book = Book::find($req->get('id')); //Menyesuaikan dengan id yang dikirim

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if($req->hasFile('cover')){
            $extension = $req->file('cover')->extension();

            $filename = 'cover_buku'.time().'.'.$extension;

            $req->file('cover')->storeAs(
                'public/cover_buku', $filename
            );

            Storage::delete('public/cover_buku'.$req->get('old_cover')); //Menghapus cover sebelumnya

            $book->cover = $filename;
        }

        $book->save();

        $notification = array (
            'message' => 'X Data Has been Change',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }

    // function untuk menghapus Data
    public function delete_book(Request $req)
    {
        $book = Book::find($req->get('id'));

        Storage::delete('public/cover_buku'.$req->get('old_cover'));

        $book->delete();

        $notification = array(
            'message' => 'Deleting Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }
}
