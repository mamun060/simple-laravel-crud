@extends('layouts.master')

@section('title', 'add post')

@section('content')
    <div>
        <div class="container">
            <h2>Edit Post Informaiton</h2>
            <form action="{{route('post.update_post', $post->id )}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                        <input name="title" type="text" class="form-control" id="title" value="{{ $post->title }}">
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        {{-- <div class="form-group mr-2">
                            <img style="width: 50px;" src="{{ URL::to( 'blogImg') . '/' . $post->thumbnail }}" alt="">
                        </div> --}}

                        <div>
                            <label for="thumbnail">Post Thumbnail</label>
                            <input name="new_thumbnail" id="thumbnail" type="file" class="form-control" value="{{ $post->thumbnail }}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="description">Post Content</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ $post->description }}</textarea>
                    </div>

                    <div class="col-md-2 mt-2">
                        <label for="">Post Status</label>
                         <div class="d-flex">
                             <div class="mr-2">
                                <label for="active">Active</label>
                                <input type="radio" {{ $post->is_active ? 'checked' : '' }} name="is_active" id="active" value="1">
                             </div>
                             <div>
                                <label for="inactive">Inactive</label>
                                <input type="radio" {{ $post->is_active ? '' : 'checked' }} name="is_active" id="inactive" value="0">
                             </div>
                         </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="">Post Publish</label>
                         <div class="d-flex">
                             <div class="mr-2">
                                <label for="active">Yes:</label>
                                <input type="radio" name="is_publish" id="active" value="1" checked>
                             </div>
                             <div class="ml-2">
                                <label for="inactive">NO:</label>
                                <input class="ml-1" type="radio" name="is_publish" id="inactive" value="0">
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