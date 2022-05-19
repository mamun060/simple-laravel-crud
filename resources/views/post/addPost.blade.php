@extends('layouts.master')

@section('title', 'add post')

@section('content')
    <div>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="container">
            <h2>Add Post Information</h2>
            <form action="{{route('post.store_post')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="category">Parent Category</label>
                        <select name="category_id" id="category" class="form-control" >
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
                        <input name="title" type="text" class="form-control" value="{{ old('title')}}" id="title">
                    </div>
                    <div class="col-md-6">
                        <label for="thumbnail">Post Thumbnail</label>
                        <input name="thumbnail" id="thumbnail" type="file" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="description">Post Content</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="">Post Status</label>
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

                    <div class="col-md-12 mt-2">
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

                    <div class="col-md-12 mt-2 mb-2">
                        <div>
                            <label for="tags">Tags</label>
                                <select name="tags[]" id="tags_select" class="form-control" name="state" multiple>
                                   
                                </select>
                        </div>
                        <span class="v-msg"></span>
                    </div>

                    <div class="col-md-12">
                        <input class="btn btn-success" type="submit" value="Submit">
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('assets/backend/css/currency/currency.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/backend/libs/summernote/summernote.css')}}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/backend/libs/summernote/summernote.js') }}"></script>
    <script>
        $('#description').summernote()

        $(document).ready(function() {
            $('#tags_select').select2({
                tags: true
            });
        });
    </script>
@endpush