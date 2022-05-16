@extends('layouts.master')

@section('title', 'add post')

@section('content')
    <div>
        <div class="container">
            <form action="{{route('post.store_post')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="category">Parent Category</label>
                        <select name="category_id" id="category" class="form-control">
                            @isset($categories)
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="subcategory">Sub Category</label>
                        <select name="subcategory_id" id="subcategory" class="form-control">
                            @isset($subcategories)
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="title">Post Title</label>
                        <input name="title" type="text" class="form-control" id="title">
                    </div>
                    <div class="col-md-6">
                        <label for="thumbnail">Post Thumbnail</label>
                        <input name="thumbnail" id="thumbnail" type="file" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="description">Post Content</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="">Category Status</label>
                         <div class="d-flex">
                             <div class="mr-2">
                                <label for="active">Active</label>
                                <input type="radio" name="is_active" id="active" value="1" checked>
                             </div>
                             <div>
                                <label for="inactive">Inactive</label>
                                <input type="radio" name="is_active" id="inactive" value="0">
                             </div>
                         </div>
                    </div>

                    <div class="col-md-12">
                        <input class="btn btn-success" type="submit" value="Submit">
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection