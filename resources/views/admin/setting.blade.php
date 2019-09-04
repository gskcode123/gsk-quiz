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
    @include('layout.message')
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
                                                    @foreach(language() as $val)
                                                        <option @if(isset($adm_setting['lang']) && $adm_setting['lang']==$val) selected @endif value="{{$val}}">{{langName($val)}}</option>
                                                    @endforeach
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
                                            <label>{{__('Coin for hints')}}</label>
                                            <input type="text" name="hints_coin" value ="@if(isset($adm_setting['hints_coin'])) {{ $adm_setting['hints_coin'] }} @endif" class="form-control number-only no-regx" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Ad Mob Coin')}}</label>
                                            <input type="text" name="admob_coin" value ="@if(isset($adm_setting['admob_coin'])) {{ $adm_setting['admob_coin'] }} @endif" class="form-control number-only no-regx" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Sign up Reward Coin')}}</label>
                                            <input type="text" name="signup_coin" value ="@if(isset($adm_setting['signup_coin'])) {{ $adm_setting['signup_coin'] }} @endif" class="form-control number-only no-regx" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('User Registration')}}</label>
                                            <div class="qz-question-category">
                                                <select name="user_registration" class="form-control">
                                                    <option @if(isset($adm_setting['user_registration']) && $adm_setting['user_registration']== 1) selected @endif value="1">{{__('Enable')}}</option>
                                                    <option @if(isset($adm_setting['user_registration']) && $adm_setting['user_registration']== 2) selected @endif value="2">{{__('Disable')}}</option>
                                                </select>
                                            </div>
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
                                            <img @if(isset($adm_setting['logo']) && (!empty($adm_setting['logo']))) src ="{{ asset(path_image().$adm_setting['logo']) }}"
                                                 @endif width="100" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Login logo')}}</label>
                                            <input type="file" name="login_logo" class="d-block">
                                            <img @if(isset($adm_setting['login_logo']) && (!empty($adm_setting['login_logo']))) src ="{{ asset(path_image().$adm_setting['login_logo']) }}"
                                                 @endif width="100" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Fevicon')}}</label>
                                            <input type="file" name="favicon" class="d-block">
                                            <img @if(isset($adm_setting['favicon']) && (!empty($adm_setting['favicon']))) src ="{{ asset(path_image().$adm_setting['favicon']) }}"
                                                 @endif width="100" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{__('Privacy and Policy')}}</label>
                                            <textarea id="btEditor" name="privacy_policy">@if(isset($adm_setting['privacy_policy'])){{$adm_setting['privacy_policy']}}@else{{old('privacy_policy')}}@endif</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{__('Terms and Conditions')}}</label>
                                            <textarea id="btEditor2" name="terms_conditions">@if(isset($adm_setting['terms_conditions'])) {{$adm_setting['terms_conditions']}} @else {{old('terms_conditions')}} @endif</textarea>
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