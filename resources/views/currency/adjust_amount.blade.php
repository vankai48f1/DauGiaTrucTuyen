@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @component('components.form_box')
                    @slot('title', __('Give :coin Amount', ['coin' => $wallet->currency_symbol]))
                    {{ Form::open(['route' => ['admin.users.wallets.adjust-amount.store', $wallet->user_id, $wallet->id], 'method' => 'post', 'class'=>'form-horizontal validator', 'id' => 'adjustAmountForm']) }}
                    {{--primary_balance--}}
                    <div class="form-group">
                        <label for="amount"
                               class="control-label required"><strong>{{  __('Current Balance'). ' : ' }}</strong>{{ $wallet->balance }} {{ $wallet->currency_symbol }}
                        </label>
                        {{ Form::text('amount',  null , ['class'=> form_validation($errors, 'amount'), 'id' => 'amount',
                        'placeholder' => __('Adjust Amount')]) }}
                        <span class="invalid-feedback" data-name="amount">{{ $errors->first('amount') }}</span>
                    </div>
                    <!-- type -->
                    <div class="form-group">
                        <div class="lf-switch">
                            {{ Form::radio('type', TRANSACTION_TYPE_BALANCE_INCREMENT,  ACTIVE,
                            ['id' => 'type-active', 'class' => 'lf-switch-input']) }}
                            <label for="type-active" class="lf-switch-label lf-switch-label-on">
                                <i class="fa fa-plus"></i> {{ __('Increment') }}
                            </label>

                            {{ Form::radio('type', TRANSACTION_TYPE_BALANCE_DECREMENT,  INACTIVE, ['id' => 'type-inactive',
                            'class' => 'lf-switch-input']) }}
                            <label for="type-inactive" class="lf-switch-label lf-switch-label-off">
                                <i class="fa fa-minus"></i> {{ __('Decrement') }}
                            </label>
                        </div>
                        <span class="invalid-feedback" data-name="type">{{ $errors->first('type') }}</span>
                    </div>

                    {{--submit button--}}
                    <div class="form-group">
                        {{ Form::submit(__('Adjust Amount'), ['class'=>'btn btn-info form-submission-button']) }}
                    </div>
                    {{ Form::close() }}
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('#adjustAmountForm').cValidate({
                rules : {
                    'amount' : 'required|numeric|between:0.00000001,99999999999.99999999'
                }
            });
        }) (jQuery);
    </script>
@endsection
