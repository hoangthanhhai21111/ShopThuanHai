<?php

use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\ShopController;
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
Route::get('/shop',function (){
    return view('front-end.layouts.master');
});
//danh mục
Route::prefix('categories')->group(function () {
    Route::get('/trash', [CategoryController::class, 'trashedItems'])->name('categories.trash');
    Route::put('/force_destroy/{id}', [CategoryController::class, 'force_destroy'])->name('categories.force_destroy');
    Route::put('/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::get('categories/showStatus/{id}', [CategoryController::class, 'showStatus'])->name('categories.showStatus');
    Route::get('categories/hideStatus/{id}', [CategoryController::class,'hideStatus'])->name('categories.hideStatus');
});
Route::resource('categories',CategoryController::class);


//sản phẩm
Route::prefix('products')->group(function () {
    Route::get('/trash', [ProductController::class, 'trashedItems'])->name('products.trash');
    Route::put('/force_destroy/{id}', [ProductController::class, 'force_destroy'])->name('products.force_destroy');
    Route::put('/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
    Route::get('products/showStatus/{id}', [ProductController::class, 'showStatus'])->name('products.showStatus');
    Route::get('products/hideStatus/{id}', [ProductController::class,'hideStatus'])->name('products.hideStatus');
});
Route::resource('products',ProductController::class);

//nhãn hiệu:
Route::prefix('brands')->group(function () {
    Route::get('/trash', [BrandController::class, 'trashedItems'])->name('brands.trash');
    Route::put('/force_destroy/{id}', [BrandController::class, 'force_destroy'])->name('brands.force_destroy');
    Route::put('/restore/{id}', [BrandController::class, 'restore'])->name('brands.restore');
    Route::get('brands/showStatus/{id}', [BrandController::class, 'showStatus'])->name('brands.showStatus');
    Route::get('brands/hideStatus/{id}', [BrandController::class,'hideStatus'])->name('brands.hideStatus');
});
Route::resource('brands',BrandController::class);   

//khách hàng:
Route::prefix('customers')->group(function () {
    Route::get('/trash', [CustomerController::class, 'trashedItems'])->name('customers.trash');
    Route::put('/force_destroy/{id}', [CustomerController::class, 'force_destroy'])->name('customers.force_destroy');
    Route::put('/restore/{id}', [CustomerController::class, 'restore'])->name('customers.restore');
});
Route::resource('customers',CustomerController::class);

//đặt hàng:
Route::prefix('orders')->group(function () {
    Route::get('/trash', [OrderController::class, 'trashedItems'])->name('orders.trash');
    Route::put('/force_destroy/{id}', [OrderController::class, 'force_destroy'])->name('orders.force_destroy');
    Route::put('/restore/{id}', [OrderController::class, 'restore'])->name('orders.restore');
});
Route::resource('orders',OrderController::class);

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
//shop
// Route::get('shop', function (){
//     return view('front-end.homes.index');
// });
Route::get('cart', function (){
    return view('front-end.homes.cart');
});
Route::get('checkout', function (){
    return view('front-end.homes.checkout');
});
