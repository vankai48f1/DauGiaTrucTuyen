@extends('layouts.master',['headerLess'=>true])
@section('title', __('Suspended Account'))
@section('content')
    @component('components.auth')
        <h2 class="text-center text-danger mb-4">{{  __('Account Suspended!')  }}</h2>
        <p class="text-center pb-3 font">{{ __('Please contact administrator to get back your account.') }}</p>
        @guest
            <a href="{{ route('home') }}" class="btn btn-success btn-block">{{ __('Go Home') }}</a>
        @endguest
        @auth
            <a href="{{ route('profile.index') }}" class="btn btn-success btn-block">{{ __('Go Profile') }}</a>
        @endauth
    @endcomponent
@endsection
