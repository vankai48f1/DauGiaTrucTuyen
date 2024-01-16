@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('content')

    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @include('seller.admin._form')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        (function ($) {
            "use strict";

            $('#store-form').cValidate({
                rules: {
                    'name' : 'required|max:255',
                    'email' : 'required|email|max:255',
                    'phone_number' : 'required|max:255',
                    'image' : 'image|max:2048',
                    'is_active' : 'required|in:' . {{ array_to_string(seller_account_status())  }},
                }
            });
        })(jQuery);
    </script>
@endsection
