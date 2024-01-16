@extends('layouts.master',['headerLess'=>true])
@section('title', __('Unverified Account'))
@section('content')
    @component('components.auth')
        <h2 class="text-center text-warning mb-4">{{ __('Email Unverified!')  }}</h2>
        <p class="text-center text-dark pb-3">{{ __('Please verify your email address to explore permitted access paths in full.') }}</p>
        @guest
            <a href="{{ route('home') }}" class="btn btn-success btn-block">{{ __('Go Home') }}</a>
        @endguest
        @auth
            <a href="{{ route('profile.index') }}" class="btn btn-success btn-block">{{ __('Go Profile') }}</a>
        @endauth

        <a href="{{route('verification.form')}}"
           class="btn btn-success btn-block">{{ __('Resend verification link') }}</a>
    @endcomponent
@endsection
