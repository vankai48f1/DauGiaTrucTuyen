@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-100 p-t-50">
        <div class="container">
            @include('user.profile.personal_info.title_nav')
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    @include('user.profile.personal_info.avatar')
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        @include('user.profile.personal_info.profile_nav')
                        @component('components.card',['type' => 'info', 'class'=> 'border-top-0'])
                            {{ Form::open(['route'=>['profile.update'],'class'=>'form-horizontal edit-profile-form','method'=>'put']) }}
                            <input type="hidden" value="{{base_key()}}" name="base_key">
                            {{--first name--}}
                            <div class="form-group">
                                <label for="{{ fake_field('first_name') }}" class="control-label required">{{ __('First Name') }}</label>
                                {{ Form::text(fake_field('first_name'), old('first_name', $user->profile->first_name), ['class'=> form_validation($errors, 'first_name'), 'id' => fake_field('first_name'),'data-cval-name' => 'The first name field','data-cval-rules' => 'required|escapeInput|alphaSpace']) }}
                                <span class="invalid-feedback cval-error" data-cval-error="{{ fake_field('first_name') }}">{{ $errors->first('first_name') }}</span>
                            </div>
                            {{--last name--}}
                            <div class="form-group">
                                <label for="{{ fake_field('last_name') }}" class="control-label required">{{ __('Last Name') }}</label>
                                {{ Form::text(fake_field('last_name'), old('last_name', $user->profile->last_name), ['class'=>form_validation($errors, 'last_name'), 'id' => fake_field('last_name'),'data-cval-name' => 'The last name field','data-cval-rules' => 'required|escapeInput|alphaSpace']) }}
                                <span class="invalid-feedback cval-error"
                                      data-cval-error="{{ fake_field('last_name') }}">{{ $errors->first('last_name') }}</span>
                            </div>
                            {{--email--}}
                            <div class="form-group">
                                <label class="control-label required">{{ __('Email') }}</label>
                                <p class="form-control form-control-sm">{{ $user->email }}</p>
                            </div>
                            {{--username--}}
                            <div class="form-group">
                                <label class="control-label required">{{ __('Username') }}</label>
                                <p class="form-control form-control-sm">{{ $user->username }}</p>
                            </div>
                            {{--address--}}
                            <div class="form-group">
                                <label for="{{ fake_field('address') }}" class="control-label">{{ __('Address') }}</label>
                                {{ Form::textarea(fake_field('address'),  old('address', $user->profile->address), ['class'=>form_validation($errors, 'address'), 'id' => fake_field('address'), 'rows'=>2,'data-cval-name' => 'The address name field','data-cval-rules' => 'escapeInput']) }}
                                <span class="invalid-feedback cval-error"
                                      data-cval-error="{{ fake_field('address') }}">{{ $errors->first('address') }}</span>
                            </div>
                            {{--submit button--}}
                            <div class="form-group">
                                {{ Form::submit(__('Update'),['class'=>'btn mr-2 bg-info fz-14 custom-btn border-0']) }}
                                <a class="btn fz-14 custom-btn border-0" href="{{route('user-manage-profile.index')}}">{{__('Cancel')}}</a>

                            </div>
                            {{ Form::close() }}
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/vendor/cvalidator/cvalidator.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('.edit-profile-form').cValidate();
        })(jQuery);
    </script>
@endsection
