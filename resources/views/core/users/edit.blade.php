@extends('layouts.master')
@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                @include('core.profile.avatar')
            </div>
            <div class="col-md-9">
                <div class="border text-muted clearfix py-3 px-3">
                    <h5 class="float-left">{{ view_html(__('Basic Details of :user', ['user' => '<strong>' . $user->profile->full_name . '</strong>'])) }}</h5>
                    <div class="float-right">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-info btn-sm back-button"><i class="fa fa-reply"></i></a>
                    </div>
                </div>

                <div class="p-3 border border-top-0">
                    {{ Form::model($user->profile,['route'=>['admin.users.update',$user->id],'class'=>'user-form my-3','method'=>'put', 'id' => 'profileForm']) }}
                    @include('core.users._edit_form')
                    {{ Form::close() }}
                    <div class="bg-light text-muted mb-3 clearfix py-3 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="btn btn-sm btn-info btn-sm-block">{{ __('View Information') }}</a>
                                <a href="{{ route('admin.users.edit.status', $user->id) }}"
                                   class="btn btn-sm btn-warning btn-sm-block">{{ __('Edit Status') }}</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('admin.users.index') }}"
                                   class="btn btn-sm btn-info btn-sm-block">{{ __('View All Users') }}</a>
                            </div>
                        </div>
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
                    'assigned_role' : 'required|in:{{ array_to_string($roles) }}',
                    'first_name' : 'required|escapeInput|alphaSpace',
                    'last_name' : 'required|escapeInput|alphaSpace',
                    'address' : 'escapeText',
                }
            });
        }) (jQuery);
    </script>
@endsection
