<?php

use App\Http\Controllers\Backend\CategoryController;
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


Route::prefix('categories')->group(function () {
    Route::get('/trash', [CategoryController::class, 'trashedItems'])->name('categories.trash');
    Route::put('/force_destroy/{id}', [CategoryController::class, 'force_destroy'])->name('categories.force_destroy');
    Route::put('/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
});
Route::resource('categories',CategoryController::class);
