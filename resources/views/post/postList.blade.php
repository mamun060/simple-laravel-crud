@extends('layouts.master')

@section('title', 'Blog List Page')

@section('content')
<div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><a href="/" class="text-decoration-none">Post List</a> </h6>
            <button class="btn btn-sm btn-info" id="add"><i class="fa fa-plus"> <a class="text-white text-decoration-none" href="{{route('post.add_post')}}">Add Post</a></i></button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Parent Category</th>
                            <th>Sub Category</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Thumbnail</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($posts)
                            @foreach ($posts as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->category->category_name ?? 'N/A' }}</td>
                                    <td>{{ $item->subcategory->subcategory_name ?? 'N/A' }}</td>
                                    <td>{{ $item->title ?? 'N/A' }}</td>
                                    <td>{{ $item->description ?? 'N/A' }}</td>
                                    <td><img style="width: 50px;" src="{{ URL::to( 'blogImg') . '/' . $item->thumbnail }}" alt=""></td>
                                    <td class="text-center">
                                        {!! $item->is_active ? '<span class="badge badge-success">Active </span>' : '<span class="badge badge-danger">In-Active </span>' !!}
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="javascript:void(0)" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                        {{-- <a href="javascript:void(0)" class="fa fa-edit mx-2 text-warning text-decoration-none"></a> --}}
                                        <a href="{{ route('post.destroy_post', $item->id)}}" onclick="alert('Are you sure!')"  class="fa fa-trash text-danger text-decoration-none"></a>
                                        {{-- <a href="{{ route('subcategory.destroy_sub_category', $item->id )}}" onClick="alert('Are you sure!')" class="fa fa-trash text-danger text-decoration-none"></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@endsection


@push('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/currency/currency.css')}}" rel="stylesheet">
@endpush

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/backend/libs/demo/datatables-demo.js') }}"></script>
@endpush
