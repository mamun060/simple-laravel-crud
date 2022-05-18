<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Exception;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceCategories = ServiceCategory::orderByDesc('id')->get();
        return view('service_category.serviceCatList', compact('serviceCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service_category.serviceCatAdd');
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
                    'service_cat_name'          => $request->category_name,
                    'service_cat_description'   => $request->category_description,
                    'category_image'            => $photo_name,
                    'is_active'                 => $request->isActive
                ]);
    
                $category = ServiceCategory::create($data);
                if(!$category)
                    throw new Exception("Unable to create Service Category Information!", 403);
    
                    return redirect(route('service'));
    
           } catch (\Throwable $th) {
               //throw $th;
           }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        //
    }
}
