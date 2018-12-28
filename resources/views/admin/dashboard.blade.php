@extends('layout.master')
@section('title','Admin | Dashboard')
{{--@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection--}}

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
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{__('Dashboard')}}</h2>
                        <span class="sidebarToggler">
                            <i class="fa fa-bars d-lg-none d-block"></i>
                        </span>
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
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-6 text-center">
                                    <div class="qz-status-bar qz-status-bar1">
                                        <h4 class="qz-blance">{{$totalQuestion}}</h4>
                                        <h5 class="qz-total-qustions">{{__('Total Qustions')}}</h5>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <div class="qz-status-bar qz-status-bar2">
                                        <h4 class="qz-blance">{{ $totalCategory }}</h4>
                                        <h5 class="qz-total-qustions">{{__('Total Categories')}}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="qz-sec-title">
                                        <h5>{{__('Recently added category')}}</h5>
                                    </div>
                                    <div class="table-responsive category-table">
                                        <table class="table category-table text-center rounded">
                                            <thead>
                                            <tr>
                                                <th>{{__('SL.')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Question')}}</th>
                                                <th>{{__('Added On')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($categories))
                                                @php ($sl = 1)
                                                @foreach($categories as $item)
                                                    <tr>
                                                        <td>{{$sl++}}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{ count_question($item->id) }}</td>
                                                        <td>{{ date('d M y', strtotime($item->created_at)) }}</td>
                                                        <td><span class="text-success">{{ statusType($item->status) }}</span></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr class="qz-table-footer">
                                                <td colspan="2"><a href="{{ route('qsCategoryCreate') }}"><button class="btn btn-primary px-3">{{__('Add New')}}</button></a></td>
                                                <td></td>
                                                <td colspan="2"><h5><a href="{{ route('qsCategoryList') }}">{{__('See All Categories')}}</a></h5></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="qz-laderboard-area">
                                <div class="qz-laderboard-title">
                                    <h4>{{__('Laderboard')}}</h4>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{__('People')}}</th>
                                        <th>{{__('Score')}}</th>
                                        <th>{{__('Rank')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($leaders))
                                        @php ($sl = 1)
                                        @foreach($leaders as $item)
                                            <tr>
                                                <td>
                                                    <div class="people">
                                                        <img @if(isset($item)) src="{{ asset(pathUserImage().$item->image)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid mr-2">
                                                        {{ $item->name }}
                                                    </div>
                                                </td>
                                                <td>4320</td>
                                                <td class="text-center"><span class="text-success">1</span></td>
                                            </tr>
                                        @endforeach
                                   @endif
                                    </tbody>
                                </table>
                                <div class="qz-laderboard-footer">
                                    <a href="{{ route('leaderBoard') }}">{{__('See More')}}</a>
                                </div>
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