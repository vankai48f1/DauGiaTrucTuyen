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
                        @component('components.card',['type' => 'info', 'class'=> 'border-top-0 pt-3 px-3'])
                            {{ Form::model($store, ['route' => 'seller.store.update', 'id' => 'store-form', 'files' => true, 'method' => 'put']) }}
                            <div class="mb-0 row">
                                <div class="col-lg-6 mb-4">
                                    <div class="form-group mb-0">
                                        {{Form::label('name', __('Store Name'))}}
                                        {{Form::text('name', null, ['class' => form_validation($errors, 'name'), 'placeholder' => 'Name', ] )}}
                                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <div class="form-group mb-0">
                                        {{Form::label('phone_number', __('Contact Number'))}}
                                        {{Form::text('phone_number', null, ['class' => form_validation($errors, 'phone_number'), 'placeholder' => 'Phone Number' ] )}}
                                        <span class="invalid-feedback">{{ $errors->first('phone_number') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                {{Form::label('email', __('Email Address'))}}
                                {{Form::text('email', null, ['class' => form_validation($errors, 'email'),'placeholder' => 'Email Address'] )}}
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            </div>

                            <div class="form-group mb-4">
                                {{Form::label('description', __('Description'))}}
                                {{Form::textarea('description', null, ['class' => form_validation($errors, 'description'), 'rows' => '3', 'placeholder' => 'Description about the Store' ] )}}
                                <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new img-thumbnail mb-3">
                                                <img class="img h-100" src="{{get_seller_profile_image($store->image)}}" alt="">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>
                                            <div>
                                                        <span class="btn btn-sm btn-outline-success btn-file">
                                                            <span class="fileinput-new">{{__('Select')}}</span>
                                                            <span class="fileinput-exists">{{__('Change')}}</span>

                                                            {{ Form::file('image', [old('image'),'class'=>'multi-input', 'id' => 'image'])}}
                                                        </span>
                                                <a href="#" class="btn btn-sm btn-outline-danger fileinput-exists"
                                                   data-dismiss="fileinput">{{__('Remove')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="font-weight-bold border-bottom color-666 pb-3">{{__('Store Image')}}</h4>
                                    <p class="text-muted mt-4">{{__('Upload a picture here which will be displayed in you store as your store profile image. Anyone will be able to see this image')}}</p>
                                    <p class="mt-3 mb-0 color-333"> {{__('- Maximum Image Size :')}} <span
                                            class="font-weight-bold">{{__('2MB')}}</span></p>
                                    <p class="mt-1 color-333">{{__('- Maximum Image Dimension :')}} <span
                                            class="font-weight-bold">{{__('320x300')}}</span></p>
                                    <span class="invalid-feedback">{{ $errors->first('image') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::submit('Submit',['class'=>'btn btn-info btn-sm px-4 mt-2 float-right']) }}
                            </div>

                            {{ Form::close() }}
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        (function ($) {
            "use strict";

            $('#store-form').cValidate({
                rules: {
                    name: 'required|max:255',
                    phone_number: 'required|max:255',
                    email: 'required|email|max:255',
                    image: 'image|max:2048',
                }
            });
        })(jQuery);
    </script>
@endsection
