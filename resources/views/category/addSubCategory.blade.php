@extends('layouts.master')

@section('title', 'Add Sub Category page')

@section('content')
<div class="container">
    <h2 class="text-dark">Add Sub Category Information</h2>
    <form action="{{ route('subcategory.store_sub_category')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <select name="category_id" id="" class="form-control text-dark">
                    @isset($categories)
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"> {{ $category->category_name }} </option>
                        @endforeach
                    @endisset
               
                {{-- <option value="0">1</option>
                <option value="0">1</option>
                <option value="0">1</option>
                <option value="0">1</option> --}}
                </select>
            </div>
                <div class="col-md-6">
                    <label for="name">Category Name</label>
                    <input id="name"  name="category_name" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="name">Category Description</label>
                    <input id="name"  name="category_description" type="text" class="form-control">
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <label for="category_image">Category Thumbnail</label>
                    <input name="category_image" id="category_image" type="file">
                </div>
                <div class="col-md-12">
                    <label for="">Category Status</label>
                     <div class="d-flex">
                         <div class="mr-2">
                            <label for="active">Active</label>
                            <input type="radio" name="isActive" id="active" value="1" checked>
                         </div>
                         <div>
                            <label for="inactive">Inactive</label>
                            <input type="radio" name="isActive" id="inactive" value="0">
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
