@extends('layouts.master')

@section('content')

<div id="content">


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Blank Page</h1>

    </div>
    <!-- /.container-fluid -->

</div>
@endsection


@push('css')
    <style>
        .summary-container .card{
            position: relative;
            transform-style: preserve-3d;
        }

        .summary-container .card::before{
            position: absolute;
            content: '';
            width: 0;
            height: 0;
            bottom: -13px;
            left: -4px;
            border-left: 15px solid transparent;
            border-bottom: 0px solid transparent;
            border-top:15px solid #c0bbbb;
            transform: translateZ(-1px);
        }
    </style>
@endpush
