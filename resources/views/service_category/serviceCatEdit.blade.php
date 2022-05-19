@extends('layouts.master')

@section('title', 'Edit Service Category')

@section('content')
<div class="container">
    <h2 class="text-dark">Edit Service Category Information</h2>
    <form action="{{ route('serviceCategory.service_cat_update', $serviceCategory->id )}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
                <div class="col-md-6">
                    <label for="name">Category Name</label>
                    <input id="name"  name="category_name" type="text" class="form-control" value="{{ $serviceCategory->service_cat_name }}">
                </div>
                <div class="col-md-6">
                    <label for="name">Category Description</label>
                    <input id="name"  name="category_description" type="text" class="form-control" value="{{ $serviceCategory->service_cat_description }}" >
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="">Category Thumbnail</label>
                    <input name="category_image" type="file" value="{{ $serviceCategory->category_image }}">
                </div>
                <div class="col-md-12">
                    <label for="">Category Status</label>
                     <div class="d-flex">
                         <div class="mr-2">
                            <label for="active">Active</label>
                            <input type="radio" {{ $serviceCategory->is_active ? 'checked' : '' }} name="isActive" id="active" value="1">
                         </div>
                         <div>
                            <label for="inactive">Inactive</label>
                            <input type="radio" {{ $serviceCategory->is_active ? '' : 'checked' }} name="isActive" id="inactive" value="0">
                         </div>
                     </div>
                </div>
                <div class="col-md-12">
                    <input class="btn btn-success" type="submit" value="Submit">
                </div>
        </div>
    </form>
</div>
@endsection
