<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = SubCategory::orderByDesc('id')->get();
        return view('category.subcategory', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('category.addSubCategory', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            try {
                // dd($request->all());
                // dd($request->hasFile('category_image'));

                 if( $request->hasFile('category_image')) {
                     $image         = $request->file('category_image');
                     $photo_name    = md5(time().rand()).'.'. $image->getClientOriginalExtension() ;
                     $image->move( public_path('category/'), $photo_name) ;
                 } else {
                     $photo_name = "" ;
                 }
     
                 $data = ([
                     'category_id'              => $request->category_id,
                     'subcategory_name'         => $request->category_name,
                     'subcategory_description'  => $request->category_description,
                     'subcategory_image'        => $photo_name,
                     'is_active'                => $request->isActive
                 ]);
     
                 $about = SubCategory::create($data);
                 if(!$about)
                     throw new Exception("Unable to create Sub Category Information!", 403);
     
                 return redirect(route('subcategory.sub_category'));
     
            } catch (\Throwable $th) {
                //throw $th;
            }
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        try {
            $deleted = $subCategory->delete();
            if(!$deleted)
                throw new Exception("Unable to delete category!", 403);

                return redirect(route('subcategory.sub_category'));
        } catch (\Throwable $th) {
           
        }
    }

}
