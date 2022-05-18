<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderByDesc('id')->get();
        return view('post.postList', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        $subcategories = SubCategory::where('is_active', 1)->get();
        return view('post.addPost', compact('categories','subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());

            if( $request->hasFile('thumbnail')) {
                $image      = $request->file('thumbnail');
                $thumbnail_name = md5(time().rand()).'.'. $image->getClientOriginalExtension() ;
                $image->move( public_path('blogImg/'), $thumbnail_name) ;
            } else {
                $thumbnail_name = "" ;
            }

            // dd($request->hasFile('thumbnail'));

            $category = Category::select('category_name')
                        ->find($request->category_id);

            $subcategory = SubCategory::select('subcategory_name')
                        ->find( $request->subcategory_id);

            // dd($category_name, $subcategory_name);

            $data = [
                'category_id'           => $request->category_id,
                'subcategory_id'        => $request->subcategory_id,
                'category_name'         => $category->category_name ?? null,
                'subcategory_name'      => $subcategory->subcategory_name ?? null,
                'title'                 => $request->title,
                'slug'                  => Str::slug($request->title),
                'thumbnail'             => $thumbnail_name,
                'description'           => $request->description,
                'is_active'             => $request->is_active,
                'is_archive'            => $request->is_publish,
                // 'created_by'            => null,
                // 'created_name'          => null,
                // 'updated_by'            => null,
                // 'updated_name'          => null
            ];

            $post = Post::create($data);
            if(!$post)
                throw new Exception("Unable to create Post Information!", 403);

            return redirect(route('post.post_list'));

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.viewpost', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::where('is_active', 1)->get();
        $subcategories = SubCategory::where('is_active', 1)->get();

        return view('post.editpost', compact('post','categories','subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        try {
            // dd($request->all());

            if( $request->hasFile('new_thumbnail')) {
                $image          = $request->file('new_thumbnail');
                $thumbnail_name = md5(time().rand()).'.'. $image->getClientOriginalExtension() ;
                $image->move( public_path('blogImg/'), $thumbnail_name) ;
            } else {
                $thumbnail_name = $post ? $post->thumbnail : null ;
            }

            $category = Category::select('category_name')
                        ->find($request->category_id);

            $subcategory = SubCategory::select('subcategory_name')
                        ->find( $request->subcategory_id);

            $data = [
                'category_id'           => $request->category_id,
                'subcategory_id'        => $request->subcategory_id,
                'category_name'         => $category->category_name ?? null,
                'subcategory_name'      => $subcategory->subcategory_name ?? null,
                'title'                 => $request->title,
                'slug'                  => Str::slug($request->title),
                'thumbnail'             => $thumbnail_name,
                'description'           => $request->description,
                'is_active'             => $request->is_active,
                'is_archive'            => $request->is_publish,
                // 'created_by'            => null,
                // 'created_name'          => null,
                // 'updated_by'            => null,
                // 'updated_name'          => null
            ];

            $post = $post->update($data);
            if(!$post)
                throw new Exception("Unable to update Post Information!", 403);

            return redirect(route('post.post_list'));

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $deleted = $post->delete();
            if(!$deleted)
                throw new Exception("Unable to delete post!", 403);

                return redirect(route('post.post_list'));
        } catch (\Throwable $th) {
           
        }
    }
}
