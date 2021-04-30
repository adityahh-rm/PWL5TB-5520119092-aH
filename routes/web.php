<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('profile', function(){})->middleware('auth');

//Halaman Admin
Route::get('admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home')->middleware('is_admin');

//Halaman Books
Route::get('admin/books', [App\Http\Controllers\AdminController::class, 'books'])->name('admin.books')->middleware('is_admin');

//Admin - Pengelolaan Buku
Route::post('admin/books', [App\Http\Controllers\AdminController::class, 'submit_book'])->name('admin.book.submit')->middleware('is_admin');

// Menampilkan halaman + proses yg melibatkan data (Modifikasi Data)
Route::patch('admin/books/update', [App\Http\Controllers\AdminController::class, 'update_book'])->name('admin.book.update')->middleware('is_admin');
// Ajax akan mengakses fungsi getDataBuku. Data berhasil maka dapat terInput pada id.
Route::get('admin/ajaxadmin/dataBuku/{id}', [App\Http\Controllers\AdminController::class, 'getDataBuku']);

Route::delete('admin/books/delete', [App\Http\Controllers\AdminController::class, 'delete_book'])->name('admin.book.delete')->middleware('is_admin');

// Mencetak PDF
Route::get('admin/print_books', [App\Http\Controllers\AdminController::class, 'print_books'])->name('admin.print.books')->middleware('is_admin');
// Mencetak Excel
Route::get('admin/books/export', [App\Http\Controllers\AdminController::class, 'export'])->name('admin.book.export')->middleware('is_admin');
//Import 
Route::post('admin/books/import', [App\Http\Controllers\AdminController::class, 'import'])->name('admin.book.import')->middleware('is_admin');

//PRODUCTS
Route::middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('products', [App\Http\Controllers\AdminController::class, 'products'])->name('admin.products');
    Route::post('products', [App\Http\Controllers\AdminController::class, 'submit_product'])->name('admin.product.submit');
    Route::patch('products/update', [App\Http\Controllers\AdminController::class, 'update_product'])->name('admin.product.update');
    Route::delete('products/delete', [App\Http\Controllers\AdminController::class, 'delete_product'])->name('admin.product.delete');
});
Route::get('admin/ajaxadmin/dataProduct/{id}', [App\Http\Controllers\AdminController::class, 'getDataProduct']);

//CATEGORY
Route::middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
    Route::post('categories', [App\Http\Controllers\AdminController::class, 'submit_category'])->name('admin.category.submit');
    Route::patch('categories/update', [App\Http\Controllers\AdminController::class, 'update_category'])->name('admin.category.update');
    Route::delete('categories/delete', [App\Http\Controllers\AdminController::class, 'delete_category'])->name('admin.category.delete');
});
Route::get('admin/ajaxadmin/dataCategory/{id}', [App\Http\Controllers\AdminController::class, 'getDataCategory']);

//BRANDS
Route::middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('brands', [App\Http\Controllers\AdminController::class, 'brands'])->name('admin.brands');
    Route::post('brands', [App\Http\Controllers\AdminController::class, 'submit_brand'])->name('admin.brand.submit');
    Route::patch('brands/update', [App\Http\Controllers\AdminController::class, 'update_brand'])->name('admin.brand.update');
    Route::delete('brands/delete', [App\Http\Controllers\AdminController::class, 'delete_brand'])->name('admin.brand.delete');
});
Route::get('admin/ajaxadmin/dataBrand/{id}', [App\Http\Controllers\AdminController::class, 'getDataBrand']);
