@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        {{ Form::model($role, ['route'=>['roles.update',[$role->slug, $type]], 'method'=>'PUT','id' => 'roleForm']) }}
        @include('core.roles._form',['buttonText'=>__('Update')])
        {{ Form::close() }}
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/js/role_manager.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('#roleForm').cValidate({
                rules : {
                    'name' : 'required|escapeInput'
                }
            });
        }) (jQuery);
    </script>
@endsection
