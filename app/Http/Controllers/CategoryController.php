<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderByDesc('id')->get();
        return view('category.categorylist', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.addcategory');
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
        //    dd($request->all());

            if( $request->hasFile( 'category_image')) {
                $image      = $request->file( 'category_image');
                $photo_name = md5(time().rand()).'.'. $image->getClientOriginalExtension() ;
                $image->move( public_path('category/'), $photo_name) ;
            } else {
                $photo_name = "" ;
            }

            $data = ([
                'category_name'         => $request->category_name,
                'category_description'  => $request->category_description,
                'category_image'        => $photo_name,
                'is_active'             => $request->isActive
            ]);

            $category = Category::create($data);
            if(!$category)
                throw new Exception("Unable to create Category Information!", 403);

                return redirect(route('category.category_list'));

       } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage())->withInput();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.editcategory', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try {
            //    dd($request->all());
    
                if( $request->hasFile( 'category_image')) {
                    $image      = $request->file( 'category_image');
                    $photo_name = md5(time().rand()).'.'. $image->getClientOriginalExtension() ;
                    $image->move( public_path('category/'), $photo_name) ;
                } else {
                    $photo_name = $category ? $category->category_image : null ;
                }
    
                $data = ([
                    'category_name'         => $request->category_name,
                    'category_description'  => $request->category_description,
                    'category_image'        => $photo_name,
                    'is_active'             => $request->isActive
                ]);
    
                $category = $category->update($data);
                if(!$category)
                    throw new Exception("Unable to update Category Information!", 403);
    
                    return redirect(route('category.category_list'));
    
           } catch (\Throwable $th) {
               //throw $th;
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $deleted = $category->delete();
            if(!$deleted)
                throw new Exception("Unable to delete category!", 403);

                return redirect(route('category.category_list'));
        } catch (\Throwable $th) {
           
        }
    }


}
