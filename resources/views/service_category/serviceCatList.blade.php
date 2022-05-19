@extends('layouts.master')

@section('title','Service Category')

@section('content')
    <div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><a href="/" class="text-decoration-none">Service Categories</a> </h6>
                <button class="btn btn-sm btn-info" id="add"><i class="fa fa-plus"> <a class="text-white decoration-none" href="{{ route('serviceCategory.service_cat_create')}}">Add Category</a></i></button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Category Image</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($serviceCategories)
                                @foreach ($serviceCategories as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->service_cat_name   ?? 'N/A' }}</td>
                                        <td>{{ $item->service_cat_description ?? 'N/A'}}</td>
                                        <td><img style="width: 50px;" src="{{ URL::to( 'ServiceCategory') . '/' . $item->category_image }}" alt=""></td>
                                        <td class="text-center">
                                            {!! $item->is_active ? '<span class="badge badge-success">Active </span>' : '<span class="badge badge-danger">In-Active </span>' !!}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{  route('serviceCategory.service_cat_edit', $item->id ) }}" class="fa fa-edit mx-2 text-warning text-decoration-none"></a>
                                            <a href="{{ route('serviceCategory.service_cat_destroy', $item->id )}}" onClick="alert('Are you sure!')" class="fa fa-trash text-danger text-decoration-none"></a>
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
