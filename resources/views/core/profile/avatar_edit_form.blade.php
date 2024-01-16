@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')

    <div class="p-b-100 p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    @include('user.profile.personal_info.avatar')
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        @include('user.profile.personal_info.profile_nav')
                        @component('components.card', ['type' => 'info', 'class'=> 'border-top-0'])
                            <div class="py-4 px-3">
                                <div class="row">
                                    <div class="col-12">
                                        {{ Form::open(['route'=>['profile.avatar.update'],'files'=> true, 'id' => 'profileForm', 'method' => 'put']) }}
                                        {{--avatar--}}
                                        <div class="form-group">
                                            <label for="avatar" class="d-block control-label required">{{ __('Upload new avatar') }}</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new img-thumbnail lf-w-200px lf-h-200px">
                                                        <img src="{{ get_avatar(auth()->user()->avatar) }}" alt="">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists img-thumbnail lf-w-200px lf-h-200px"></div>
                                                    <div>
                            <span id="button-group" class="btn btn-sm btn-outline-success btn-file">
                              <span class="fileinput-new">{{ __("Select") }}</span>
                              <span class="fileinput-exists">{{ __("Change") }}</span>
                              <input type="file" name="avatar">
                            </span>
                                                        <a href="#" id="remove" class="btn btn-sm btn-outline-danger fileinput-exists"
                                                           data-dismiss="fileinput">{{ __("Remove") }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="invalid-feedback">{{ $errors->first('avatar') }}</span>
                                        </div>

                                        {{--submit button--}}
                                        {{ Form::submit(__('Upload Avatar'), ['class'=>'btn btn-info btn-sm btn-left btn-sm-block form-submission-button']) }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('public/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            var cForm = $('#profileForm').cValidate({
                rules: {
                    'avatar': 'required|image|max:2048',
                }
            });
        })(jQuery);
    </script>
@endsection
