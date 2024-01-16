@extends('layouts.master',['headerLess'=>true])
@section('title', __('Production Activation'))
@section('content')
    @component('components.auth')
        <h2 class="text-center text-danger mb-2">{{  __('Production Activation!')  }}</h2>
        <p class="text-center text-dark font-size-16">{{ __('Product is expired or inactive. Please active it.') }}</p>
        {{ Form::open(['route' => 'product-activation']) }}
        <div class="form-group">
            {{ Form::text('purchase_code', null, ['class' => form_validation($errors, 'purchase_code'), 'placeholder' => __('Purchase Code')]) }}
            <span class="invalid-feedback">{{ $errors->first('purchase_code') }}</span>
        </div>
        <div class="form-group">
            {{ Form::submit(__('Activate'),['class' => 'btn btn-secondary btn-block']) }}
        </div>
        {{ Form::close() }}
    @endcomponent
@endsection
