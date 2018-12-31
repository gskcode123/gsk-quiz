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
                        <h2>{{__('Search Result')}}</h2>
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
                            <ul>
                                @if(isset($questions))
                                    @foreach($questions as $item)
                                        <li><a href="{{ route('questionEdit', $item->id) }}">{{$item->title}}</a></li>
                                    @endforeach
                                @else
                                    <li>{{__('Not Found')}}</li>
                                @endif

                            </ul>
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