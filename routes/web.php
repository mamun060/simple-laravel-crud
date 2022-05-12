<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
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
    return view('dashboard');
});


Route::group(['prefix' => 'categories', 'as' => 'category.'],function () {
    Route::get('/category',         [CategoryController::class, 'index'])->name('category_list');
    Route::get('/add-category',     [CategoryController::class, 'create'])->name('add_category');
    Route::post('/category-store',  [CategoryController::class, 'store'])->name('category_store');
    Route::get('/{category}',       [CategoryController::class, 'destroy'])->name('destroy_category');
});

Route::group(['prefix' => 'subcategories', 'as' => 'subcategory.'], function(){
    Route::get('/sub-category',         [SubCategoryController::class, 'index'])->name('sub_category');
    Route::get('/add-sub-category',     [SubCategoryController::class, 'create'])->name('add_sub_category');
    Route::post('/store-sub-category',  [SubCategoryController::class, 'store'])->name('store_sub_category');
    Route::get('/{subCategory}',        [SubCategoryController::class, 'destroy'])->name('destroy_sub_category');
});


Route::group(['prefix' => 'blogs', 'as' => 'blog.'], function(){
    Route::get('/blog-list', [BlogController::class, 'index'])->name('blog_list');
});