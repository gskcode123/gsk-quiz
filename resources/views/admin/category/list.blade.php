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
                        <h2>{{__('Category')}}</h2>
                        <div class="d-flex align-items-center">
                            <a href="{{route('qsCategoryCreate')}}" class="btn btn-primary px-3">{{__('Add New')}}</a>
                            <span class="sidebarToggler ml-4">
                                <i class="fa fa-bars d-lg-none d-block"></i>
                            </span>
                        </div>
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
                            <!-- <div class="table-responsive"> -->
                            <table id="category-table" class="table category-table table-bordered  text-center mb-0">
                                <thead>
                                <tr>
                                    <th class="all">{{__('SL.')}}</th>
                                    <th class="teblet">{{__('Title')}}</th>
                                    <th class="desktop">{{__('Questions')}}</th>
                                    <th class="desktop">{{__('Priority')}}</th>
                                    <th class="desktop">{{__('Added On')}}</th>
                                    <th class="teblet">{{__('Status')}}</th>
                                    <th class="all">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($categories))
                                    @php ($sl = 1)
                                    @foreach($categories as $item)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ count_question($item->id) }}</td>
                                    <td>{{ $item->serial }}</td>
                                    <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                    <td><span class="">{{ statusType($item->status) }}</span></td>
                                    <td>
                                        <ul class="d-flex justify-content-center">
                                            <a href="{{ route('qsCategoryEdit', $item->id) }}"><li class="qz-edit"><span class="flaticon-pencil"></span></li></a>
                                            <a href="{{ route('qsCategoryDelete', $item->id) }}" onclick="return confirm('Are you sure to delete this ?');"><li class="ml-2 qz-close"><span class="flaticon-error"></span></li></a>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                            <!-- </div> -->
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