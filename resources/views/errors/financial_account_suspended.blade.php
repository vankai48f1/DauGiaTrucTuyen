@extends('layouts.master',['headerLess'=>true])
@section('title', __('Financial Suspension'))
@section('content')
    @component('components.auth')
        <h2 class="text-center text-danger mb-4">{{ __('Financially Suspended!')  }}</h2>
        <p class="text-center text-dark pb-3">{{ __('Please contact administrator to get back your financial access.') }}</p>
        @guest
            <a href="{{ route('home') }}" class="btn btn-success btn-block">{{ __('Go Home') }}</a>
        @endguest
        @auth
            <a href="{{ route('profile.index') }}" class="btn btn-success btn-block">{{ __('Go Profile') }}</a>
        @endauth
    @endcomponent
@endsection
