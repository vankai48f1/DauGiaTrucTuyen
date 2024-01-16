@extends('layouts.master',['headerLess'=>true])
@section('title', __('Register'))
@section('content')

    <div class="lf-no-header-inner">
        <div class="mx-lg-4">
            <div class="text-center mb-3">
                <a href="{{route('home')}}" class="lf-logo{{!empty(settings('logo_inversed_secondary')) ? ' lf-logo-inversed' : ''}}">
                    <img src="{{ company_logo() }}" class="img-fluid" alt="">
                </a>
            </div>
            <h4 class="text-center mb-4">{{ __('Create Your Account') }}</h4>
            <form class="laraframe-form" action="{{ route('register.store') }}" method="post" id="registerForm">
                @csrf
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="{{ form_validation($errors, 'first_name') }}"
                           name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('First Name') }}">
                    <span class="invalid-feedback"
                          data-name="first_name">{{ $errors->first('first_name') }}</span>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text"
                           class="{{ form_validation($errors, 'last_name') }}"
                           name="last_name" value="{{ old('last_name') }}"
                           placeholder="Last Name">
                    <span class="invalid-feedback"
                          data-name="last_name">{{ $errors->first('last_name') }}</span>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text"
                           class="{{ form_validation($errors, 'username') }}"
                           name="username" value="{{ old('username') }}"
                           placeholder="Username">
                    <span class="invalid-feedback"
                          data-name="username">{{ $errors->first('username') }}</span>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                    </div>
                    <input type="text"
                           class="{{ form_validation($errors, 'email') }}"
                           name="email" value="{{ old('email') }}"
                           placeholder="{{ __('Email') }}">
                    <span class="invalid-feedback"
                          data-name="email">{{ $errors->first('email') }}</span>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                    </div>
                    <input type="password"
                           class="{{ form_validation($errors, 'password') }}"
                           name="password"
                           placeholder="{{ __('Password') }}">
                    <span class="invalid-feedback"
                          data-name="password">{{ $errors->first('password') }}</span>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                    </div>
                    <input type="password"
                           class="{{ form_validation($errors, 'password_confirmation') }}"
                           name="password_confirmation"
                           placeholder="{{ __('Confirm Password') }}">
                    <span class="invalid-feedback"
                          data-name="password_confirmation">{{ $errors->first('password_confirmation') }}</span>
                </div>

                @if( env('APP_ENV') != 'local' && settings('display_google_captcha') )
                    <div class="input-group mb-2">
                        <div>
                            {{ view_html(NoCaptcha::display()) }}
                        </div>
                        <span class="invalid-feedback">{{ $errors->first('g-recaptcha-response') }}</span>
                    </div>
                @endif

                <div class="checkbox mb-2">
                    <div class="lf-checkbox">
                    <input id="rememberMe" type="checkbox" name="check_agreement"> <label
                        for="rememberMe">{{  __('Accept our terms and conditions.') }}</label>
                    </div>
                    <span class="invalid-feedback"
                          data-name="check_agreement">{{ $errors->first('check_agreement') }}</span>
                </div>

                <div class="form-group">
                    <button type="submit"
                            class="btn btn-block btn-success form-submission-button">{{ __('Register') }}</button>
                </div>
            </form>
            <div class="text-center pt-2">
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </div>
            @if(settings('require_email_verification'))
                <div class="text-center pt-1">
                    <a href="{{ route('forget-password.index') }}">{{ __('Forgot Password?') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection


@section('script')
    @if( env('APP_ENV') == 'production' && settings('display_google_captcha') )
        {{ view_html(NoCaptcha::renderJs()) }}
    @endif
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('#registerForm').cValidate({
                rules : {
                    'first_name':'required|alphaSpace',
                    'last_name':'required|alphaSpace',
                    'username':'required|escapeInput|alphaDash',
                    'email':'required|escapeInput|email',
                    'password' : 'required',
                    'password_confirmation' : 'required|same:password',
                    'check_agreement' : 'required',
                }
            });
        })(jQuery);
    </script>
@endsection
