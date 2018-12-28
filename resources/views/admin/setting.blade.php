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
                        <h2>{{__('Setting')}}</h2>
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
        <div class="card add-category">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::open(['route' => 'saveSettings', 'files' => 'true']) }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('App Title')}}</label>
                                            <input type="text" name="app_title" value ="@if(isset($adm_setting['app_title'])) {{ $adm_setting['app_title'] }} @endif" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Language')}}</label>
                                            <div class="qz-question-category">
                                                <select name="lang" class="form-control">
                                                    <option>English</option>
                                                    <option>Spanish</option>
                                                    <option>Japanees</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Company name')}}</label>
                                            <input type="text" name="company_name" value ="@if(isset($adm_setting['company_name'])) {{ $adm_setting['company_name'] }} @endif" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Primary Email')}}</label>
                                            <input type="text" name="primary_email" value ="@if(isset($adm_setting['primary_email'])) {{ $adm_setting['primary_email'] }} @endif" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Copyright Text')}}</label>
                                            <input type="text" name="copyright_text" value ="@if(isset($adm_setting['copyright_text'])) {{ $adm_setting['copyright_text'] }} @endif" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Company logo')}}</label>
                                            <input type="file" name="logo" class="d-block">
                                            <img @if(isset($adm_setting['logo'])) src ="{{ asset(path_image().$adm_setting['logo']) }}"
                                                 @endif width="100" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Fevicon')}}</label>
                                            <input type="file" name="favicon" class="d-block">
                                            <img @if(isset($adm_setting['favicon'])) src ="{{ asset(path_image().$adm_setting['favicon']) }}"
                                                 @endif width="100" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-primary btn-block add-category-btn mt-4">{{__('Save Change')}}</button>
                                    </div>
                                </div>
                            {{ Form::close() }}
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