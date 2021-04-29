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
Route::get('admin/products', [App\Http\Controllers\AdminController::class, 'products'])->name('admin.products')->middleware('is_admin');
Route::post('admin/products', [App\Http\Controllers\AdminController::class, 'submit_product'])->name('admin.product.submit')->middleware('is_admin');
Route::patch('admin/products/update', [App\Http\Controllers\AdminController::class, 'update_product'])->name('admin.product.update')->middleware('is_admin');
Route::get('admin/ajaxadmin/dataProduct/{id}', [App\Http\Controllers\AdminController::class, 'getDataProduct']);
Route::delete('admin/products/delete', [App\Http\Controllers\AdminController::class, 'delete_product'])->name('admin.product.delete')->middleware('is_admin');