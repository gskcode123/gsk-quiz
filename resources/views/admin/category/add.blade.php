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
                    <h2>@if(isset($question)) {{__('Edit Category')}} @else {{__('Add Category')}} @endif</h2>
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
                        <div class="col-lg-6 offset-lg-3">
                            {{ Form::open(['route' => 'qsCategorySave', 'files' => 'true']) }}
                                <div class="form-group">
                                    <label>{{__('Title')}}</label>
                                    <input type="text" name="name" @if(isset($category)) value="{{$category->name}}" @else value="{{old('name')}}" @endif class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Description')}}</label>
                                    <textarea name="description" id="" rows="6" class="form-control">@if(isset($category)){{$category->description}}@else{{old('description')}}@endif</textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Question limit')}}</label>
                                    <input type="text" @if(isset($category)) value="{{$category->max_limit}}" @else value="{{old('max_limit')}}" @endif name="max_limit" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Quize limit')}}</label>
                                    <input type="text" @if(isset($category)) value="{{$category->qs_limit}}" @else value="{{old('qs_limit')}}" @endif name="qs_limit" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Time limit')}}</label>
                                    <input type="text" @if(isset($category)) value="{{$category->time_limit}}" @else value="{{old('time_limit')}}" @endif name="time_limit" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Serial')}}</label>
                                    <input type="text" @if(isset($category)) value="{{$category->serial}}" @else value="{{old('serial')}}" @endif name="serial" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Activation Status')}}</label>
                                    <div class="qz-question-category">
                                        <select name="status" class="form-control">
                                            @foreach(active_statuses() as $key => $value)
                                                <option @if(isset($category) && ($category->status == $key)) selected
                                                        @elseif((old('status') != null) && (old('status') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Thumbnail image')}}</label>
                                    <input type="file" name="image" class="d-block">
                                    @if(isset($category))
                                        <img width="50" @if(isset($category->image)) src="{{ asset(path_category_image().$category->image)}}" @endif alt="">
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        @if(isset($category))
                                            <input type="hidden" name="edit_id" value="{{$category->id}}">
                                            @endif
                                        <button type="submit" class="btn btn-primary btn-block add-category-btn">
                                            @if(isset($category)) {{__('Update')}} @else {{__('Add New')}} @endif
                                        </button>
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