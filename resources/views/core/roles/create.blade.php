@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route'=>['roles.store'], 'id' => 'roleForm']) }}
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            {{ Form::text('name',null,['class'=> form_validation($errors, 'name'), 'id' => 'name']) }}
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            {{ Form::submit(__('Create'),['class'=>'btn btn-info btn-block form-submission-button']) }}
                        </div>
                        {{ Form::close() }}
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

            $('#roleForm').cValidate({
                rules: {
                    'name': 'required|escapeInput'
                }
            });
        })(jQuery);
    </script>
@endsection
