@extends('layouts.master',['headerLess'=>true])

@section('title', __('Unknown Error'))

@section('content')
    @component('components.auth')
        <h4 class="text-center text-warning font-size-50">{{ __('Be right back.') }}</h4>
    @endcomponent
@endsection
