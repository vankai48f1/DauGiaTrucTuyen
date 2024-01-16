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
                                        {{ Form::model($user->profile, ['route'=>['profile.update'],'class'=>'form-horizontal','method'=>'put', 'id' => 'profileForm']) }}
                                        {{--first name--}}
                                        <div class="form-group row">
                                            <label for="first_name"
                                                   class="col-md-4 control-label required">{{ __('First Name') }}</label>
                                            <div class="col-md-8">
                                                {{ Form::text('first_name', null, ['class'=> form_validation($errors, 'first_name'), 'id' => 'first_name']) }}
                                                <span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
                                            </div>
                                        </div>
                                        {{--last name--}}
                                        <div class="form-group row">
                                            <label for="last_name"
                                                   class="col-md-4 control-label required">{{ __('Last Name') }}</label>
                                            <div class="col-md-8">
                                                {{ Form::text('last_name',null, ['class'=>form_validation($errors, 'last_name'), 'id' => 'last_name']) }}
                                                <span class="invalid-feedback">{{ $errors->first('last_name') }}</span>
                                            </div>
                                        </div>
                                        {{--email--}}
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label required">{{ __('Email') }}</label>
                                            <div class="col-md-8">
                                                <p class="form-control">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        {{--username--}}
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label required">{{ __('Username') }}</label>
                                            <div class="col-md-8">
                                                <p class="form-control">{{ $user->username }}</p>
                                            </div>
                                        </div>
                                        {{--address--}}
                                        <div class="form-group row">
                                            <label for="address"
                                                   class="col-md-4 control-label">{{ __('Address') }}</label>
                                            <div class="col-md-8">
                                                {{ Form::textarea('address',  null, ['class'=>form_validation($errors, 'address'), 'id' => 'address', 'rows'=>2]) }}
                                                <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                                            </div>
                                        </div>
                                        {{--submit button--}}
                                        <div class="form-group row">
                                            <div class="offset-md-4 col-md-8">
                                                {{ Form::submit(__('Update'),['class'=>'btn btn-info btn-sm btn-sm-block form-submission-button']) }}
                                                {{ Form::button('<i class="fa fa-undo"></i>',['class'=>'btn btn-danger btn-sm btn-sm-block reset-button']) }}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                            @slot('footer')
                                <a href="{{ route('profile.index') }}" class="btn text-center btn-danger fz-14 d-inline-block border-0">{{ __('Go Back') }}</a>
                            @endslot
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('#profileForm').cValidate({
                rules : {
                    'first_name': 'required|escapeInput|alphaSpace',
                    'last_name' : 'required|escapeInput|alphaSpace',
                    'address' : 'escapeInput'
                }
            });
        }) (jQuery);
    </script>
@endsection
