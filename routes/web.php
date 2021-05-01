<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Models\Category;

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

Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');
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

//INCOME REPORT
Route::middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('print_incomes', [App\Http\Controllers\IncomeReportController::class, 'print_incomes'])->name('admin.print.incomes');
    Route::get('income_reports', [App\Http\Controllers\IncomeReportController::class, 'income_reports'])->name('admin.income');
});

//PRODUCTS
Route::middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('products', [App\Http\Controllers\ProductController::class, 'products'])->name('admin.products');
    Route::post('products', [App\Http\Controllers\ProductController::class, 'submit_product'])->name('admin.product.submit');
    Route::patch('products/update', [App\Http\Controllers\ProductController::class, 'update_product'])->name('admin.product.update');
    Route::delete('products/delete', [App\Http\Controllers\ProductController::class, 'delete_product'])->name('admin.product.delete');
    Route::get('print_products', [App\Http\Controllers\ProductController::class, 'print_products'])->name('admin.print.products');
    Route::get('products/export', [App\Http\Controllers\ProductController::class, 'export'])->name('admin.product.export');
});
Route::get('admin/ajaxadmin/dataProduct/{id}', [App\Http\Controllers\ProductController::class, 'getDataProduct']);

//CATEGORY
Route::middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('categories', [App\Http\Controllers\CategoryController::class, 'categories'])->name('admin.categories');
    Route::post('categories', [App\Http\Controllers\CategoryController::class, 'submit_category'])->name('admin.category.submit');
    Route::patch('categories/update', [App\Http\Controllers\CategoryController::class, 'update_category'])->name('admin.category.update');
    Route::delete('categories/delete', [App\Http\Controllers\CategoryController::class, 'delete_category'])->name('admin.category.delete');
});
Route::get('admin/ajaxadmin/dataCategory/{id}', [App\Http\Controllers\CategoryController::class, 'getDataCategory']);

//BRANDS
Route::middleware('is_admin')->prefix('admin')->group(function(){
    Route::get('brands', [App\Http\Controllers\BrandController::class, 'brands'])->name('admin.brands');
    Route::post('brands', [App\Http\Controllers\BrandController::class, 'submit_brand'])->name('admin.brand.submit');
    Route::patch('brands/update', [App\Http\Controllers\BrandController::class, 'update_brand'])->name('admin.brand.update');
    Route::delete('brands/delete', [App\Http\Controllers\BrandController::class, 'delete_brand'])->name('admin.brand.delete');
});
Route::get('admin/ajaxadmin/dataBrand/{id}', [App\Http\Controllers\BrandController::class, 'getDataBrand']);