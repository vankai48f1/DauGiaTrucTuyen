@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="lf-bg-grey-light card-body p-5">
                    {{ Form::open(['route' => 'admin.currencies.store', 'id' => 'currency-form', 'files' => true]) }}
                    @include('currency._form', ['buttonText' => __('Create')])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script src="{{ asset('public/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('#currency-form').cValidate({
                rules: {
                    name: 'required|escapeInput',
                    symbol: 'required|escapeInput',
                    type: 'required|in:{{ array_to_string(currency_types()) }}',
                    logo: 'image',
                    is_active: 'required|in:{{ array_to_string(active_status()) }}',
                }
            });
        }) (jQuery);
    </script>
@endsection
