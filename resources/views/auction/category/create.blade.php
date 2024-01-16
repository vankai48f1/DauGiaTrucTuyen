@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="lf-bg-grey-light card-body p-5">
                    {{ Form::open(['route' => 'admin.categories.store', 'id' => 'categoryForm']) }}
                    @include('auction.category.__form', ['buttonText' => __('Create')])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>

    <script>
        (function($) {
            "use strict";

            $('#categoryForm').cValidate({
                rules: {
                    'name': 'required|escapeInput'
                }
            });
        })(jQuery);
    </script>
@endsection
