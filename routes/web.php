<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
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
    Route::get('/category',                 [CategoryController::class, 'index'])->name('category_list');
    Route::get('/add-category',             [CategoryController::class, 'create'])->name('add_category');
    Route::post('/category-store',          [CategoryController::class, 'store'])->name('category_store');
    Route::get('/edit-category/{category}', [CategoryController::class, 'edit'])->name('category_edit');
    Route::put('/update/{category}',        [CategoryController::class, 'update'])->name('update_category');
    Route::get('/{category}',               [CategoryController::class, 'destroy'])->name('destroy_category');
});

Route::group(['prefix' => 'subcategories', 'as' => 'subcategory.'], function(){
    Route::get('/sub-category',         [SubCategoryController::class, 'index'])->name('sub_category');
    Route::get('/add-sub-category',     [SubCategoryController::class, 'create'])->name('add_sub_category');
    Route::post('/store-sub-category',  [SubCategoryController::class, 'store'])->name('store_sub_category');
    Route::get('/edit-subcategory/{subCategory}', [SubCategoryController::class, 'edit'])->name('edit_subcategory');
    Route::put('/update/{subCategory}', [SubCategoryController::class, 'update'])->name('subcategory_update');
    Route::get('/{subCategory}',        [SubCategoryController::class, 'destroy'])->name('destroy_sub_category');
});


Route::group(['prefix' => 'posts', 'as' => 'post.'], function(){
    Route::get('/post-list',        [PostController::class, 'index'])->name('post_list');
    Route::get('/add-post',         [PostController::class, 'create'])->name('add_post');
    Route::post('/store-post',      [PostController::class, 'store'])->name('store_post');
    Route::get('/{post}',           [PostController::class, 'destroy'])->name('destroy_post');
});

Route::group(['prefix' => 'comments', 'as' => 'comment.'], function(){
    Route::get('/comment-list',             [CommentController::class, 'index'])->name('comment_list');
    Route::get('/add-comment',              [CommentController::class, 'create'])->name('add_comment');
    Route::post('/store-comment',           [CommentController::class, 'store'])->name('store_comment');
    Route::get('/edit-comment/{comment}',   [CommentController::class, 'edit'])->name('edit_commit');
    Route::put('/{comment}/update',         [CommentController::class, 'update'])->name('update_comment');
    Route::get('/{comment}',                [CommentController::class, 'destroy'])->name('destroy_comment');
});