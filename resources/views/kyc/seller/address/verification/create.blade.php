@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-100 p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    @include('seller.stores.manage_store.avatar')
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        @include('seller.stores.manage_store.store_nav')
                        <div class="p-4 bg-white border lf-toggle-border-color clearfix">
                            <div class="text-center">
                                <h4>{{ __('Selected Address') }}</h4>
                                <p>
                                    <a href="{{ route('kyc.seller.addresses.index') }}" class="small">{{ __('Change Address') }}</a>
                                </p>
                            </div>
                            @include('kyc.user.address._address_table')
                            <hr>
                            {{ Form::open(['route'=> ['kyc.seller.addresses.verification.store', 'address' => $address->id], 'id'=> 'create-address-verification', 'files' => true ]) }}

                                <div id="identification">

                                    <div class="form-group">
                                        {{ Form::label('identification_type', __('Verification With')) }}
                                        {{ Form::select('identification_type', identification_type_with_address(), null, ['class'=> 'custom-select', 'id' => 'identification_type', 'v-on:change'=> "onChange(".'$event'.")",'placeholder' => __('Choose a method') ]) }}
                                        <span class="invalid-feedback">{{ $errors->first('identification_type') }}</span>
                                    </div>

                                    <div>

                                        <div v-if="nextSelect == {{IDENTIFICATION_TYPE_WITH_ADDRESS_BANK_STATEMENT}} || nextSelect == {{IDENTIFICATION_TYPE_WITH_ADDRESS_UTILITY_BILL}} ">

                                            <div class="row">

                                                {{-- Start: front image --}}
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new img-thumbnail mb-3">
                                                                        <img class="img" src="{{know_your_customer_images('preview.png')}}"  alt="">
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>
                                                                    <div>
                                                                            <span class="btn btn-sm btn-outline-success btn-file">
                                                                                <span class="fileinput-new">Select</span>
                                                                                <span class="fileinput-exists">Change</span>
                                                                                {{ Form::file('front_image', ['front_image','class'=>'multi-input', 'id' => 'front_image'])}}
                                                                            </span>
                                                                        <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">{{__('Remove')}}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4 class="font-weight-bold border-bottom pb-3">{{__('Upload Image')}}</h4>
                                                            <p class="text-muted mt-4">{{__('Take an image of your id card from the front side and upload it here. Which you will not be able to edit or change once you upload it till admin review')}}</p>
                                                            <p class="mt-3 mb-0 color-333"> {{__('- Maximum Image Size :')}} <span class="font-weight-bold">{{__('5MB')}}</span></p>
                                                            <p class="mt-1 color-333">{{__('- Maximum Image Dimension :')}} <span class="font-weight-bold">{{__('1600x1200')}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- End: front image --}}

                                            </div>

                                        </div>

                                    </div>

                                    <div class="mt-5">
                                        <div v-if="nextSelect != ''" class="d-inline-block float-right ml-3">
                                            <div class="form-group">
                                                {{ Form::submit(__('Submit'),['class'=>'btn text-center bg-info fz-14 d-inline-block btn-info border-0']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
    <style>
        .fileinput-new{width: 200px; height: 180px;}
        .fileinput-preview {max-width: 200px; max-height: 180px;}
    </style>
@endsection

@section('script')
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#identification',
            data: {
                nextSelect: '',
            },

            methods: {
                onChange: function (event) {
                    this.nextSelect = event.target.value;
                }
            },
        })

        (function ($) {
            "use strict";

            $('#create-address-verification').cValidate({
                rules: {
                    'name': 'required|max:55',
                }
            });
        }) (jQuery);
    </script>
@endsection
