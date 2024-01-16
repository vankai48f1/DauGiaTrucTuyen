@extends('layouts.master',['headerLess'=>true])

@section('title', __('Page Not Found'))

@section('content')
    @component('components.auth')
        <h2 class="text-center text-danger font-size-50">404</h2>
        <h4 class="text-center text-danger font-size-18">{{ (isset($exception) && $exception->getMessage()) ? $exception->getMessage() : __('Not Found!')  }}</h4>
        <p class="text-center text-dark py-3">{{ __('The page you are looking for might be changed, removed or not exists. Go back and try other links') }}</p>
        <a href="{{ route('home') }}" class="btn btn-success text-white btn-block">{{ __('Go Home') }}</a>
    @endcomponent
@endsection
