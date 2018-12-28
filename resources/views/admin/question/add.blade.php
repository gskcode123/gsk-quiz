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
                    <h2>@if(isset($question)) {{__('Edit Question')}} @else {{__('Add Question')}} @endif</h2>
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
                            {{ Form::open(['route' => 'questionSave', 'files' => 'true']) }}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{__('Question')}} <span class="text-danger">*</span></label>
                                            <input type="text" name="title" @if(isset($question)) value="{{ $question->title }}" @else value="{{ old('title') }}" @endif class="form-control" placeholder="Question">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Category')}} <span class="text-danger">*</span></label>
                                            <div class="qz-question-category">
                                                @if(isset($categories[0]))
                                                    <select name="category_id" class="form-control">
                                                        <option value="">{{__('Select Category')}}</option>
                                                        @foreach($categories as $category)
                                                            <option @if(isset($question) && ($question->category_id == $category->id)) selected
                                                                    @elseif((old('category_id') != null) && (old('category_id') == $category->id)) @endif value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Question Type')}} <span class="text-danger">*</span></label>
                                            <div class="qz-question-category">
                                                <select class="form-control" name="type">
                                                    <option value="">{{__('Select Type')}}</option>
                                                    @foreach(question_type() as $key => $value)
                                                        <option @if(isset($question) && ($question->type == $key)) selected
                                                            @elseif((old('type') != null) && (old('type') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Point')}} <span class="text-danger">*</span></label>
                                            <input type="text" @if(isset($question)) value="{{ $question->point }}" @else value="{{ old('point') }}" @endif name ="point" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Time Limit')}}</label>
                                            <input type="text" @if(isset($question)) value="{{ $question->time_limit }}" @else value="{{ old('time_limit') }}" @endif name="time_limit" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Thumbnail image')}} ({{__('If Necessary')}})</label>
                                            <input type="file" name="image" class="d-block">
                                            @if(isset($question))
                                            <img width="50" @if(isset($question->image)) src="{{ asset(path_question_image().$question->image)}}" @endif alt="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{__('Activation Status')}}</label>
                                            <div class="qz-question-category">
                                                <select name="status" class="form-control">
                                                    @foreach(active_statuses() as $key => $value)
                                                        <option @if(isset($question) && ($question->status == $key)) selected
                                                                @elseif((old('status') != null) && (old('status') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="col-lg-6">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label>{{__('Answer')}}</label>--}}
                                            {{--<input type="text" name="answer" class="form-control" placeholder="">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row" id="dynamic_field">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{__('Options')}}<span class="text-danger"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>{{__('Answer Type')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 offset-lg-1">
                                                <label for=""></label>
                                                <button type="button" class="btn btn-primary btn-block" name="add" id="add">{{__('Add More')}}</button>
                                            </div>
                                            @if(isset($qsOptions))
                                                @php ($sl = 1)
                                                @foreach($qsOptions as $opt)
                                                    <div class="col-lg-6" id="optTitle{{$sl}}">
                                                        <div class="form-group">
                                                            <input type="text" name="options[]" value="{{ $opt->option_title }}" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3" id="optAns{{$sl}}">
                                                        <div class="form-group">
                                                            <div class="qz-question-category">
                                                                <select name="ans_type[]" class="form-control" >
                                                                    <option @if($opt->is_answer == 0) selected @endif value="0">{{__('Wrong')}}</option>
                                                                    <option @if($opt->is_answer == 1) selected @endif value="1">{{__('Right')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <div class="form-group">
                                                            <button type="button" name="remove" id="{{ $sl }}" class="btn btn-danger btn_remove2">X</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" name="options[]" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <div class="qz-question-category">
                                                            <select name="ans_type[]" class="form-control" >
                                                                <option value="0">{{__('Wrong')}}</option>
                                                                <option value="1">{{__('Right')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        @if(isset($question))
                                            <input type="hidden" name="edit_id" value="{{$question->id}}">
                                        @endif
                                        <button type="submit" class="btn btn-primary btn-block add-category-btn mt-4">
                                            @if(isset($question)) {{__('Update')}} @else {{__('Add New')}} @endif
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
    <script type="text/javascript">
        console.log(1);
        $(document).ready(function(){
            var i=1;

            $('#add').click(function () {
                // alert(1);
                i++;
                $('#dynamic_field').append(
                    '<div class="col-lg-6 dynamic-added" id="row'+i+'" >' +
                        '<div class="form-group">' +
                            '<input type="text" name="options[]" placeholder="" class="form-control name_list" />' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-lg-3 dynamic-added" id="rows'+i+'" >' +
                        '<div class="form-group">' +
                            '<div class="qz-question-category">' +
                            '<select name="ans_type[]" class="form-control">' +
                                '<option value="0"> Wrong </option>' +
                                '<option value="1"> Right </option>' +
                            '</select>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-lg-1">' +
                        '<div class="form-group">' +
                            '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>' +
                        '</div>' +
                    '</div>'
                    );
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
                $('#rows'+button_id+'').remove();
            });

            $(document).on('click', '.btn_remove2', function(){
                var button_id = $(this).attr("id");
                $('#optTitle'+button_id+'').remove();
                $('#optAns'+button_id+'').remove();
            });

        });
    </script>
@endsection