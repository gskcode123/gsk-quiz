@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection

@section('left-sidebar')
    @include('layout.include.sidebar')
@endsection

@section('header')
    @include('layout.include.header')
@endsection

@section('main-body')
    @include('layout.message')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h2>{{__('Question')}}</h2>
                        <a href="{{ route('questionCreate') }}" class="btn btn-primary px-3">{{__('Add New')}}</a>
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
                                        <th>{{__('Sl.')}}</th>
                                        <th>{{__('Category')}}</th>
                                        <th>{{__('Question')}}</th>
                                        <th>{{__('Answer')}}</th>
                                        <th>{{__('Point')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($items))
                                        @php ($sl = 1)
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td>{{ $item->qsCategory->name }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ answers($item->id) }}</td>
                                                <td>{{ $item->point }}</td>
                                                <td><span class="">{{ statusType($item->status) }}</span></td>
                                                <td>
                                                    <ul class="d-flex justify-content-center">
                                                        <a href="{{ route('questionEdit', $item->id) }}"><li class="qz-edit"><span class="flaticon-pencil"></span></li></a>
                                                        <a href="{{ route('questionDelete', $item->id) }}" onclick="return confirm('Are you sure to delete this ?');"><li class="ml-2 qz-close"><span class="flaticon-error"></span></li></a>
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