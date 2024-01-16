@extends('layouts.master',['headerLess'=>true])
@section('title', __('Under Maintenance'))
@section('content')
    @component('components.auth')
        <h2 class="text-center text-warning mb-4">{{ __('Under Maintenance')  }}</h2>
        <p class="text-center text-dark">{{ __("The website is still under maintenance mode. send us an email anytime :email",['email' => settings('admin_receive_email')])}}</p>
    @endcomponent
@endsection
