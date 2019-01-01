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
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{__('User Profile')}}</h2>
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
        <div class="card qz-profile-area">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-5">
                            <div class="qz-profile-card text-center">
                                <div class="qz-edit-icon">
                                    <a href="#">
                                        <img src="{{ asset('assets/images/edit.png') }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <div class="qz-profile-user-avater">
                                    <img @if(isset($user->photo)) src="{{ asset(pathUserImage().$user->photo)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid">
                                </div>
                                <div class="qz-user-info">
                                    <h4>{{ $user->name }}</h4>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="qz-user-status-card qz-user-status-card-bg1">
                                        <h4>{{ calculate_ranking($user->id) }}</h4>
                                        <h6>{{__('Average Rank')}}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="qz-user-status-card qz-user-status-card-bg2">
                                        <h4>{{ calculate_score($user->id) }}</h4>
                                        <h6>{{__('Total earn Point')}}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="qz-user-status-card qz-user-status-card-bg3">
                                        <h4>20</h4>
                                        <h6>{{__('Challenge played')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7">
                            <ul class="user-details-info">
                                <li>
                                    <div class="row ">
                                        <div class="col-md-4">{{__('Name')}}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$user->name}}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-4">{{__('Phone')}}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$user->phone}}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-4">{{__('Country')}}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$user->country}}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-4">{{__('City')}}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$user->city}}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-4">{{__('State')}}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$user->state}}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-4">{{__('Zip')}}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$user->zip}}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-4">{{__('Full Address')}}</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-7">{{$user->address}}</div>
                                    </div>
                                </li>
                            </ul>
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