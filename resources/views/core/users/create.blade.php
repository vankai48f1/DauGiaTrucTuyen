@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="offset-2 col-md-8">
                <div class="card-body lf-bg-grey-light">
                    {{ Form::open(['route'=>'admin.users.store', 'id' => 'userCreateForm']) }}
                    @include('core.users._create_form')
                    {{ Form::close() }}
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

            $('#userCreateForm').cValidate({
                rules : {
                    'first_name' : 'required|escapeInput|alphaSpace',
                    'last_name' : 'required|escapeInput|alphaSpace',
                    'email' : 'required|escapeInput|email',
                    'username' : 'required|escapeInput',
                    'address' : 'escapeInput',
                    'assigned_role' : 'required|in:{{ array_to_string($roles) }}',
                    'is_email_verified' : 'required|in:{{ array_to_string(email_status()) }}',
                    'is_active' : 'required|in:{{ array_to_string(account_status()) }}',
                    'is_financial_active' : 'required|in:{{ array_to_string(financial_status()) }}',
                    'is_accessible_under_maintenance' : 'required|in:{{ array_to_string(maintenance_accessible_status()) }}',
                }
            });
        }) (jQuery);
    </script>
@endsection
