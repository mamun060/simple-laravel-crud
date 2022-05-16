@extends('layouts.master')

@section('title', 'Comment List')

@section('content')
<div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><a href="/" class="text-decoration-none">Comment List</a> </h6>
            <button class="btn btn-sm btn-info" id="add"><i class="fa fa-plus"> <a class="text-white text-decoration-none" href="{{route('comment.add_comment')}}">Add Comment</a></i></button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($comments)
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $comment->name ?? 'N/A' }}</td>
                                    <td>{{ $comment->email ?? 'N/A' }}</td>
                                    <td>{{ $comment->comment ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        {!! $comment->is_active ? '<span class="badge badge-success">Active </span>' : '<span class="badge badge-danger">In-Active </span>' !!}
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="javascript:void(0)" class="fa fa-eye text-info text-decoration-none"></a> --}}
                                        <a href="{{ route('comment.edit_commit', $comment->id )}}" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                        <a href="{{ route('comment.destroy_comment', $comment->id )}}" onclick="alert('Are you sure!')"  class="fa fa-trash text-danger text-decoration-none"></a>
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