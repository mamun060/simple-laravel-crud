@extends('layouts.master')

@section('title', 'Post View')

@section('content')
    <div class="container">
        <button class="btn btn-success m-2"><a class="text-white decoration-none" href="{{ route('post.post_list')}}">Back</a></button>
     
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <tbody>
                        <tr class="borderd bg-danger text-white">
                            <th colspan="2">
                                <h4>
                                    Post Information
                                </h4>
                            </th>
                        </tr>

                        <tr>
                            <th>Post Title</th>
                            <td>{{ $post->title }}</td>
                        </tr>

                        <tr>
                            <th>Post Thumbnail</th>
                            <td><img style="width: 150px;" src="{{ URL::to( 'blogImg') . '/' . $post->thumbnail }}" alt=""></td>
                        </tr>

                        <tr>
                            <th>Post Description</th>
                            <td>{!! $post->description ?? 'N/A' !!}</td>
                        </tr>

                        <tr>
                            <th>Post Status</th>
                            <td class="text-left">
                                {!! $post->is_active ? '<span class="badge badge-success">Active </span>' : '<span class="badge badge-danger">In-Active </span>' !!}
                            </td>
                        </tr>
                  
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection