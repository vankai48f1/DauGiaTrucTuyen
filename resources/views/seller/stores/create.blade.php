@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-50 pt-5">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="card custom-border">
                        <div class="card-body py-5">
                            <div class="row justify-content-center">
                                <div class="col-lg-10">
                                    {{ Form::open(['route' => 'become-a-seller.store', 'id' => 'becomeSellerForm', 'files' => true]) }}
                                    @method('post')

                                    <div class="form-group mb-0 row">
                                        <div class="col-lg-6 mb-4">
                                            {{Form::text('name', null, ['class' => form_validation($errors, 'name'), 'placeholder' => __('Name')] )}}
                                            <span class="invalid-feedback" data-name="name">{{ $errors->first('name') }}</span>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            {{Form::text('phone_number', null, ['class' => form_validation($errors, 'phone_number'), 'placeholder' => __('Phone Number')] )}}
                                            <span class="invalid-feedback" data-name="phone_number">{{ $errors->first('phone_number') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        {{Form::text('email', null, ['class' => form_validation($errors, 'email'), 'placeholder' => __('Email')] )}}
                                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    </div>

                                    <div class="form-group mb-4">
                                        {{Form::textarea('description', null, ['class' => form_validation($errors, 'description'), 'placeholder' => __('Description'), 'rows' => '3'] )}}
                                        <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new img-thumbnail mb-3">
                                                        <img class="img" src="{{get_seller_profile_image('preview.png')}}"  alt="Image">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-sm btn-outline-success btn-file">
                                                            <span class="fileinput-new">Select</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            {{ Form::file('image', [old('image'),'class'=>'multi-input', 'id' => 'image'])}}
                                                        </span>
                                                        <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h4 class="font-weight-bold border-bottom color-666 pb-3">Store Image</h4>
                                            <p class="text-muted mt-4">{{__('Upload a picture here which will be displayed in you store as your store profile image. Anyone will be able to see this image')}}</p>
                                            <p class="mt-3 mb-0 color-333"> {{__('- Maximum Image Size :')}} <span class="font-weight-bold">{{__('2MB')}}</span></p>
                                            <p class="mt-1 color-333">{{('- Maximum Image Dimension :')}} <span class="font-weight-bold">{{__('320x300')}}</span></p>
                                            <span class="invalid-feedback">{{ $errors->first('image') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::submit('Submit',['class'=>'btn btn-info px-4 mt-2 float-right']) }}
                                        <a class="btn btn-danger d-inline-block mt-2 mr-3 px-4 float-right" href="{{route('profile.index')}}">{{__('Cancel')}}</a>
                                    </div>

                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
@endsection

@section('script')
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        (function ($) {
            "use strict";

            $('#becomeSellerForm').cValidate({
                rules : {
                    'name' : 'required|escapeInput|min:3|max:255',
                    'phone_number' : 'required|min:3|max:255'
                }
            });
        }) (jQuery);
    </script>
@endsection
