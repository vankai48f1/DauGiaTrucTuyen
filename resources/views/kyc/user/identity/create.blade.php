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

                            {{ Form::open(['route'=>['kyc.identity.store'],'class'=>'form-horizontal edit-profile-form','files' => true]) }}
                            @method('post')

                            <div class="row justify-content-center">

                                <div class="col-md-12 my-3">
                                    <div id="identification">

                                        <div class="form-group boot-select mb-5">
                                            {{Form::label('identification_type'), __('Identification With :')}}
                                            {{ Form::select('identification_type', identification_type_with_id(), null, ['class'=> 'custom-select', 'id' => 'identification_type', 'v-on:change'=> "onChange(".'$event'.")",'placeholder' => __('Choose a method') ]) }}

                                        </div>

                                        <div id="id-form-section">

                                            <div v-if="nextSelect == {{IDENTIFICATION_TYPE_WITH_ID_NID}} || nextSelect == {{IDENTIFICATION_TYPE_WITH_ID_DRIVING_LICENSE}}">
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
                                                                        {{ Form::file('front_image', [old('front_image'),'class'=>'multi-input', 'id' => 'front_image'])}}
                                                                    </span>
                                                                            <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h4 class="font-weight-bold border-bottom pb-3">Front Image</h4>
                                                                <p class="text-muted mt-4">{{__('Take an image of your id card from the front side and submit it here. Which you will not be able to edit or change once you upload it till admin review')}}</p>
                                                                <p class="mt-3 mb-0 color-333"> {{__('- Maximum Image Size :')}} <span class="font-weight-bold">{{__('5MB')}}</span></p>
                                                                <p class="mt-1 color-333">{{__('- Maximum Image Dimension :')}} <span class="font-weight-bold">{{__('1600x1200')}}</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End: front image --}}

                                                    {{-- Start: back image --}}
                                                    <div class="col-md-12 mt-4">
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
                                                                        <span class="fileinput-new">{{__('Select')}}</span>
                                                                        <span class="fileinput-exists">{{__('Change')}}</span>
                                                                        {{ Form::file('back_image', [old('back_image'),'class'=>'multi-input', 'id' => 'back_image'])}}
                                                                    </span>
                                                                            <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">{{__('Remove')}}</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h4 class="font-weight-bold border-bottom pb-3">{{__('Back Image')}}</h4>
                                                                <p class="text-muted mt-4">{{__('Take an image of your id card from the back side and upload it here. Which you will not be able to edit or change once you submit it till admin review')}}</p>
                                                                <p class="mt-3 mb-0 color-333"> {{__('- Maximum Image Size :')}} <span class="font-weight-bold">{{__('5MB')}}</span></p>
                                                                <p class="mt-1 color-333">{{__('- Maximum Image Dimension :')}} <span class="font-weight-bold">{{__('1600x1200')}}</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End: back image --}}

                                                </div>
                                            </div>

                                            <div v-else-if="nextSelect == {{IDENTIFICATION_TYPE_WITH_ID_PASSPORT}} ">

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
                                                                        <span class="fileinput-new">{{__('Select')}}</span>
                                                                        <span class="fileinput-exists">{{__('Change')}}</span>
                                                                        {{ Form::file('front_image', [null,'class'=>'multi-input', 'id' => 'front_image'])}}
                                                                    </span>
                                                                            <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h4 class="font-weight-bold border-bottom pb-3">{{__('Front Image')}}</h4>
                                                                <p class="text-muted mt-4">{{__('Take an image of your id card from the front side and upload it here. Which you will not be able to edit or change once you upload it till admin review')}}</p>
                                                                <p class="mt-3 mb-0 color-333"> {{__('- Maximum Image Size :')}} <span class="font-weight-bold">{{__('5MB')}}</span></p>
                                                                <p class="mt-1 color-333">{{__('- Maximum Image Dimension :')}} <span class="font-weight-bold">{{__('1600x1200')}}</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End: front image --}}

                                                </div>

                                            </div>

                                            <div class="mt-5">
                                                <div v-if="nextSelect != ''" class="d-inline-block float-right ml-3">
                                                    <div class="form-group">
                                                        {{ Form::submit(__('Submit'),['class'=>'btn text-center bg-info fz-14 d-inline-block lf-custom-btn border-0']) }}
                                                    </div>
                                                </div>
                                            </div>
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
        #id-form-section {display: none;}
        .fileinput-new{width: 200px; height: 180px;}
        .fileinput-preview{max-width: 200px; max-height: 180px;}
    </style>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        new Vue({
            el: '#identification',
            data: {
                nextSelect: '',
            },

            methods: {
                onChange: function (event) {
                    this.nextSelect = event.target.value;
                }
            },
            mounted() {
                $('#id-form-section').css('display', 'block');
            }
        });

        (function ($) {
            "use strict";

            $('.edit-profile-form').cValidate();
        }) (jQuery);
    </script>
@endsection
