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
                                        {{ Form::open(['route'=>['profile.update-password'],'class'=>'form-horizontal','method'=>'put', 'id' => 'passwordChangeForm']) }}
                                        {{--password--}}
                                        <div class="form-group row">
                                            <label for="password"
                                                   class="col-md-4 control-label required">{{ __('Current Password') }}</label>
                                            <div class="col-md-8">
                                                {{ Form::password('password', ['class'=>form_validation($errors, 'password'), 'placeholder' => __('Enter current password'), 'id' => 'password']) }}
                                                <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                            </div>
                                        </div>
                                        {{--new password--}}
                                        <div class="form-group row">
                                            <label for="new_password"
                                                   class="col-md-4 control-label required">{{ __('New Password') }}</label>
                                            <div class="col-md-8">
                                                {{ Form::password('new_password', ['class'=>form_validation($errors, 'new_password'), 'placeholder' => __('Enter new password'), 'id' => 'new_password']) }}
                                                <span class="invalid-feedback">{{ $errors->first('new_password') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="new_password_confirmation"
                                                   class="col-md-4 control-label required">{{ __('Confirm New Password') }}</label>
                                            <div class="col-md-8">
                                                {{ Form::password('new_password_confirmation', ['class'=>form_validation($errors, 'new_password_confirmation'), 'placeholder' => __('Confirm new password'), 'id' => 'new_password_confirmation']) }}
                                                <span class="invalid-feedback">{{ $errors->first('new_password_confirmation') }}</span>
                                            </div>
                                        </div>
                                        {{--submit button--}}
                                        <div class="form-group row">
                                            <div class="offset-md-4 col-md-8">
                                                {{ Form::submit(__('Update Password'),['class'=>'btn btn-info btn-sm btn-left btn-sm-block form-submission-button']) }}
                                            </div>
                                        </div>
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

@section('script')
<script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
<script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
<script>


    (function ($) {
        "use strict";

        $('#passwordChangeForm').cValidate({
            rules : {
                'password' : 'required',
                'new_password' : 'required|escapeInput',
                'new_password_confirmation' : 'required|escapeInput|same:new_password'
            }
        });
    }) (jQuery);
</script>
@endsection
