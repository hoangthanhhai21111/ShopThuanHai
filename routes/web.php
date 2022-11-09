<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\GroupController;
use App\Http\Controllers\backend\LoginController;
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



Route::prefix('')->group(function (){
Route::get('/', function () {
    return view('backend.masster');
});
});

// Login
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/loginProcessing', [LoginController::class, 'loginProcessing'])->name('loginProcessing');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
Route::prefix('')->middleware(['auth', 'PreventBackHistory'])->group(function () {
Route::resource('category', CategoryController::class);
Route::resource('groups', GroupController::class);
Route::prefix('users')->group(function () {
 Route::get('trash',[UserController::class,'trash'])->name('users.trash');
 Route::put('softDelete/{id}',[UserController::class,'softDelete'])->name('users.softDelete');
 Route::put('RestoreDelete/{id}',[UserController::class,'RestoreDelete'])->name('users.RestoreDelete');
});
Route::resource('users', UserController::class);
});
