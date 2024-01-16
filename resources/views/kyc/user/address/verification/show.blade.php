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
                        <div class="p-4 bg-white border lf-toggle-border-color">
                            <div class="text-center">
                                <h3>{{ __('Selected Address') }}</h3>
                            </div>
                            @include('kyc.user.address._address_table', ['address' => $verification->address])
                            <hr>
                            @if($verification->front_image)
                                <h3 class="text-center mt-4 mb-0">{{__('Submitted Document')}}</h3>
                                <span class="text-center d-block fz-14 color-999">({{identification_type_with_address($verification->identification_type)}})</span>
                                <div class="d-flex">
                                    <img class="img-fluid mx-auto mt-3 front-img"
                                         src="{{know_your_customer_images($verification->front_image)}}">
                                </div>
                            @endif
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
            'use strict';

            $('#create-address-verification').cValidate({
                rules: {
                    'name': 'required|max:55',
                }
            });
        }) (jQuery);
    </script>
@endsection
