<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\facades\Storage;

use App\Models\Book;
use PDF;

use App\Exports\BooksExport;
use App\Exports\BooksImport;
use App\Imports\BooksImport as ImportsBooksImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

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

        if($req->hasFile('cover')) //Apakah punya cover??
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

            $filename = 'cover_buku_'.time().'.'.$extension;

            $req->file('cover')->storeAs(
                'public/cover_buku', $filename
            );

            Storage::delete('public/cover_buku/'.$req->get('old_cover')); //Menghapus cover sebelumnya

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

    public function print_books()
    {
        $books = Book::all();

        $pdf = PDF::loadview('print_books', ['books' => $books]);

        return $pdf->download('data_buku.pdf');
    }

    //Export Buku
    public function export()
    {
        //class Excel -- function download
        return Excel::download(new BooksExport, 'books.xlsx');
                            // Memanggil file Export, nama file unduhan
    }

    //Import Buku
    public function import(Request $req)
    {
        Excel::import(new ImportsBooksImport, $req->file('file'));

        $notification = array(
            'message' => 'Import Data Berhasil Dilakukan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }

/** =================================================================== **/
    //PRODUCTs
    public function products()
    {
        $user = Auth::user();
        $products = Product::all();
            return view('product', compact('user', 'products'));
    }

    public function submit_product(Request $req)
    {
        $product = new Product; //objek dari Book

        //Field menjadi function -- data diambil dari inputan
        $product->name = $req->get('name');
        $product->qty = $req->get('stock');
        $product->categories_id = $req->get('category');

        if($req->hasFile('photo'))
        {
            $extension = $req->file('photo')->extension();

            $filename = 'product_imag'.time().'.'.$extension;

            $req->file('photo')->storeAs( 
                'public/product_img', $filename
            ); 

            $product->photo = $filename; 
        }

        $product->save(); 

        $notification = array(
            'message' => 'Product Added Succesfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.products')->with($notification);
    }
    // Function untuk mengambil ID pada setiap x yang ada
    public function detDataProduct($id)
    {
        $product = Product::find($id); //Berdasarkan primary key
        //Data dari model Book
        return response()->json($product);
    }

    // function untuk update-BUKU
    public function update_product(Request $req)
    {
        $product = Product::find($req->get('id')); //Menyesuaikan dengan id yang dikirim

        $product->name = $req->get('name');
        $product->qty = $req->get('qty');
        $product->categories_id = $req->get('categories_id');
        $product->brands_id = $req->get('brands_id');

        if($req->hasFile('photo')){
            $extension = $req->file('photo')->extension();

            $filename = 'product_img_'.time().'.'.$extension;

            $req->file('photo')->storeAs(
                'public/product_img', $filename
            );

            Storage::delete('public/product_img/'.$req->get('old_photo'));

            $product->photo = $filename;
        }

        $product->save();

        $notification = array (
            'message' => 'Product Updated Succesfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.products')->with($notification);
    }

    // function untuk menghapus Data
    public function delete_product(Request $req)
    {
        $product = Product::find($req->get('id'));

        Storage::delete('public/product_img'.$req->get('old_photo'));

        $product->delete();

        $notification = array(
            'message' => 'Deleting Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.products')->with($notification);
    }    
    
    /** =================================================================== **/
    //CATEGORY
    public function categories()
    {
        $user = Auth::user();
        $categories = Category::all();
            return view('category', compact('user', 'categories'));
    }

    public function submit_category(Request $req)
    {
        $category = new Category;

        $category->name = $req->get('name');
        $category->description = $req->get('description');

        $category->save(); 
        $notification = array(
            'message' => 'Category Added Succesfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.categories')->with($notification);
    }
    
    public function getDataCategory($id)
    {
        $category = Category::find($id); 

        return response()->json($category);
    }

    /** =================================================================== **/
    //BRAND
    public function brands()
    {
        $user = Auth::user();
        $brands = Brand::all();
            return view('brand', compact('user', 'brands'));
    }

    public function submit_brand(Request $req)
    {
        $brand = new Brand;

        $brand->name = $req->get('name');
        $brand->description = $req->get('description');

        $brand->save(); 
        $notification = array(
            'message' => 'Brand Added Succesfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.brands')->with($notification);
    }
    
    public function getDataBrand($id)
    {
        $brand = Brand::find($id); 

        return response()->json($brand);
    }
}
