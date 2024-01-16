@extends('layouts.master', ['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <!-- ::::::::::::::::::::::START PAGE HEAD ::::::::::::::::::::::::: -->
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    {{ Form::open(['route'=>['dispute.store'],'class'=>'form-horizontal', 'id' => 'cvalidate', 'files' => true]) }}

                    <div class="card">
                        <div class="card-header py-4">
                            <h3 class="font-weight-bold d-inline color-666">{{$title}}</h3>
                            <span
                                class="text-muted ml-2">{{empty($disputeType) ? '' : dispute_type($disputeType)}}</span>
                        </div>
                        <div class="card-body py-5">
                            <div class="row justify-content-center">
                                <div class="col-sm-10">
                                    @if(empty($disputeType) || empty($refId))
                                        {{-- Start: select button --}}
                                        <div class="form-group row">
                                            {{Form::label('dispute_type', __('Select Report Type'),['class' => 'col-sm-3 col-form-label font-weight-lighter color-666'])}}
                                            <div class="col-sm-9">
                                                {{ Form::select('dispute_type', dispute_type(), null, ['class' => 'custom-select my-1 mr-sm-2', 'id' => 'dispute_type']) }}
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="{{'dispute_type'}}" value="{{$disputeType}}">
                                    @endif

                                    @if(empty($disputeType) || empty($refId))
                                        {{-- Start: ref id--}}
                                        <div class="form-group row">
                                            {{Form::label('ref_id', __('Reference ID'),['class' => 'col-sm-3 col-form-label font-weight-lighter color-666'])}}
                                            <div class="col-sm-9">
                                                {{ Form::text('ref_id', null, ['class'=> 'form-control', 'id' => 'ref_id'])}}
                                                <span class="invalid-feedback">{{ $errors->first('ref_id') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="{{'ref_id'}}" value="{{$refId}}">
                                    @endif

                                    {{-- Start: Title--}}
                                    <div class="form-group row">
                                        {{Form::label('title', __('The Title field'),['class' => 'col-sm-3 col-form-label font-weight-lighter color-666'])}}
                                        <div class="col-sm-9">
                                            {{ Form::text('title', null, ['class'=> 'form-control', 'id' => 'title']) }}
                                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>

                                    {{-- Start: description --}}
                                    <div class="form-group row mt-4 mb-0">
                                        {{Form::label('description', __('Description'),['class' => 'col-sm-3 col-form-label font-weight-lighter color-666'])}}
                                        <div class="col-sm-9">
                                            {{ Form::textarea('description', null, ['class'=> form_validation($errors, 'description'), 'id' => 'description', 'rows'=>('3')]) }}
                                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>

                                    <!-- Start: dispute image -->
                                    <div class="form-group form-row mt-4">
                                        {{Form::label('content', __('Image'),['class' => 'col-sm-3 col-form-label font-weight-lighter color-666'])}}
                                        <div class="col-sm-9">
                                            <div id="preview-multi-img">
                                                <div class="row" id="TextBoxContainer">
                                                </div>
                                                <button id="btnAdd" type="button" class="btn color-666 bg-custom-gray"
                                                        data-toggle="tooltip">{{__('Add Image')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End: dispute image -->

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <button value="Submit Design" type="submit"
                                    class="btn btn-info float-right form-submission-button my-2"
                                    id="two">{{__('Submit Report')}}</button>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <!-- ::::::::::::::::::::::::END PAGE HEAD ::::::::::::::::::::::::: -->
@endsection

@section('script')
    <!-- for button loader -->
    <script src="{{ asset('public/vendor/moment.js/moment.min.js') }}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>

    <script>
        (function ($) {
            'use strict';

            function GetDynamicTextBox() {
                return '<div class="col-lg-4 mb-3">' +
                    '<div class="fileinput fileinput-new" data-provides="fileinput">' +
                    '<div class="fileinput fileinput-new" data-provides="fileinput">' +
                    '<div class="fileinput-new img-thumbnail mb-3">' +
                    '<img class="img" src="{{know_your_customer_images('preview.png')}}"  alt="">' +
                    '</div>' +
                    '<div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>' +
                    '<div>' +
                    '<span class="btn btn-sm btn-outline-success btn-file mr-2" >' +
                    '<span class="fileinput-new">Select</span>' +
                    '<span class="fileinput-exists">Change</span>' +
                    '{{ Form::file('images[]', [old('images'),'class'=>'multi-input', 'id' => 'images'])}}' +
                    '</span>' +
                    '<a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">Remove</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<td><button type="button" class="btn btn-danger remove"><i class="fa fa-minus"></i></button></td>' +
                    '</div>'
            }

            var count = 0

            $(document).on("click", "#btnAdd", function () {
                if (count < 2) {
                    $("#TextBoxContainer").append(GetDynamicTextBox());
                    count++

                    if (count == 2) {
                        $(this).remove()
                    }
                }

            });

            $("body").on("click", ".remove", function () {
                $(this).closest("div").remove();
                count--
                if (count == 1) {
                    $('#preview-multi-img').append('<button id="btnAdd" type="button" class="btn btn-info">{{__('Add Image')}}</button>')
                }
            });

            $('#cvalidate').cValidate({
                rules: {
                    'title': 'required|min:3|max:150',
                    'dispute_type': 'required',
                    'ref_id': 'required',
                    'description': 'required|min:10|max:500',
                    'images': 'required',
                }
            });
        })(jQuery);
    </script>
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
    <style>
        .form-control::placeholder {
            color: #999696 !important;
            opacity: 1;
        }

        .form-control {
            padding: 0.575rem .85rem !important;
            font-size: 14px !important;
            color: #868686 !important;
            background-color: #ececec !important;
            border: 1px solid #ececec !important;
        }

        .fileinput .img-thumbnail {
            position: relative;
        }

        .btn.btn-danger.remove {
            position: absolute;
            left: 25px;
            border-radius: 40px;
            top: 10px;
        }

    </style>
@endsection
