@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection

@section('left-sidebar')
    @include('layout.include.sidebar')
@endsection

@section('header')
    @include('layout.include.header')
@endsection

@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h2>Question</h2>
                        <a href="{{ route('questionCreate') }}" class="btn btn-primary px-3">Add New</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->

    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="qz-question-table" class="table category-table table-bordered  text-center mb-0">
                                    <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Category</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Point</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($items))
                                        @php ($sl = 1)
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td>{{ $item->category_id }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->category_id }}</td>
                                                <td>{{ $item->point }}</td>
                                                <td><span class="">{{ statusType($item->status) }}</span></td>
                                                <td>
                                                    <ul class="d-flex justify-content-center">
                                                        <a href="{{ route('questionEdit', $item->id) }}"><li class="qz-edit"><span class="flaticon-pencil"></span></li></a>
                                                        <li class="qz-check"><span class="flaticon-check-mark"></span></li>
                                                        <li class="qz-close"><span class="flaticon-error"></span></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
@endsection