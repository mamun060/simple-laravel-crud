@extends('layouts.master')

@section('title', 'Edit Commnet')

@section('content')
    <div>
        <div class="container">
            <form action="{{ route('comment.update_comment', $comment->id )}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="row">
                    <div class="col-md-12">
                        <label for="post_id">Select Post</label>
                        <select name="post_id" id="post_id" class="form-control"  >
                            @isset($posts)
                                @foreach ($posts as $post)
                                    <option value="{{ $post->id }}">{{ $post->title }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ $comment->name }}" placeholder="Your Name">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ $comment->email }}" placeholder="Your Email">
                    </div>

                    <div class="col-md-12">
                        <label for="comment">Comment</label>
                        <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"> {{$comment->comment }} 
                        </textarea>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="">Status</label>
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