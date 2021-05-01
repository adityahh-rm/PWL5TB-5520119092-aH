<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\facades\Storage;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class CategoryController extends Controller
{
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

    public function update_category(Request $req)
    {
        $category = Category::find($req->get('id')); //Menyesuaikan dengan id yang dikirim

        $category->name = $req->get('name');
        $category->description = $req->get('description');
        $category->save();

        $notification = array (
            'message' => 'Category Updated Succesfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.categories')->with($notification);
    }

    public function delete_category(Request $req)
    {
        $category = Category::find($req->get('id'));

        $category->delete();

        $notification = array(
            'message' => 'Deleting Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.categories')->with($notification);
    }  

}
