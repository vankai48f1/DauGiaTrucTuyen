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
                    <h5 class="float-left">{{ view_html(__('Status Details of :user', ['user' => '<strong>' . $user->profile->full_name . '</strong>'])) }}</h5>
                    <div class="float-right">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-info btn-sm back-button"><i class="fa fa-reply"></i></a>
                    </div>
                </div>
                <div class="p-3 border border-top-0">
                    <div class="my-3">
                        @if($user->id == Auth::user()->id)
                            <div class="text-center"><h4>{{__('You cannot change your own status.')}}</h4></div>
                        @elseif($user->is_super_admin)
                            <div class="text-center"><h4>{{__("You cannot change primary user's status.")}}</h4></div>
                        @else
                            {{ Form::model($user,['route'=>['admin.users.update.status',$user->id], 'method'=>'put', 'id' => 'statusForm']) }}
                            @include('core.users._edit_status_form')
                            {{ Form::close() }}
                        @endif
                    </div>
                    <div class="bg-light text-muted mb-3 clearfix py-3 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="btn btn-sm btn-info btn-sm-block">{{ __('View Information') }}</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="btn btn-sm btn-warning btn-sm-block">{{ __('Edit Information') }}</a>
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

            $('#statusForm').cValidate({
                rules : {
                    'is_email_verified' : 'required|in:{{ array_to_string(email_status()) }}',
                    'is_active' : 'required|in:{{ array_to_string(account_status()) }}',
                    'is_financial_active' : 'required|in:{{array_to_string(financial_status())}}',
                    'is_accessible_under_maintenance' : 'required|in:{{ array_to_string(maintenance_accessible_status()) }}',
                }
            });
        }) (jQuery);
    </script>
@endsection
