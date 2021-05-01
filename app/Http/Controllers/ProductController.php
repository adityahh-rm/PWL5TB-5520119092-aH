<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\facades\Storage;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

use PDF;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
       /** =================================================================== **/
    //PRODUCTs
    public function products()
    {
        $user = Auth::user();
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
            return view('product', compact('user', 'products', 'categories', 'brands'));
    }

    public function submit_product(Request $req)
    {
        $product = new Product; 

        $product->name = $req->get('name');
        $product->categories_id = $req->get('categories_id');
        $product->brands_id = $req->get('brands_id');
        $product->qty = $req->get('qty');

        if($req->hasFile('photo')){
            $extension = $req->file('photo')->extension();

            $filename = 'product_img_'.time().'.'.$extension;

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
    public function getDataProduct($id)
    {
        $product = Product::find($id); //Berdasarkan primary key
        //Data dari model Book
        return response()->json($product);
    }

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
    
    public function print_products()
    {
        $products = Product::all();

        $pdf = PDF::loadview('print_products', ['products' => $products]);

        return $pdf->download('data_product.pdf');
    }

    //Export Buku
    public function export()
    {
        //class Excel -- function download
        return Excel::download(new ProductsExport, 'products.xlsx');
                            // Memanggil file Export, nama file unduhan
    }

}
