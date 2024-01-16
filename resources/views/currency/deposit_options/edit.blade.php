@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('currency._nav')
                <div class="card border-top-0">
                    <div class="card-body bg-grey-light p-5">
                        {{ Form::model($currency, ['route' => ['admin.currencies.deposit-options.update', $currency->symbol], 'id' => 'deposit-options-form', 'method' => 'PUT']) }}
                        {{--deposit_fee--}}
                        <div class="form-group form-row">
                            <div class="col-md-5">
                                {{Form::label('deposit_fee', __('Deposit Fee'))}} :
                            </div>
                            <div class="input-group col-md-7">
                                {{Form::text('deposit_fee', null, ['class' => form_validation($errors, 'name'), 'id' => 'deposit_fee'] )}}
                                <span class="input-group-append">
                                    {{ Form::select('deposit_fee_type', fee_types(),  null, ['class'=>'form-control no-select', 'id' => 'deposit_fee_type']) }}
                                </span>
                            </div>
                            <span class="invalid-feedback">{{ $errors->first('min_deposit') }}</span>
                            <span class="invalid-feedback"
                                  data-name="deposit_fee_type">{{ $errors->first('deposit_fee') }}</span>
                        </div>
                        <div class="form-group form-row">
                            <div class="col-md-5">
                                {{Form::label('min_deposit', __('Minimum Deposit Amount'))}} :
                            </div>
                            <div class="col-md-7">
                                {{Form::text('min_deposit', null, ['class' => form_validation($errors, 'name'), 'id' => 'min_deposit'] )}}
                                <span class="invalid-feedback">{{ $errors->first('min_deposit') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <div class="col-md-5">
                                {{Form::label('deposit_status', __('Deposit Status'))}} :
                            </div>
                            <div class="col-md-7">
                                <div class="lf-switch">
                                    {{ Form::radio('deposit_status', ACTIVE, true , ['id' => 'deposit_status-active', 'class' => 'lf-switch-input']) }}
                                    <label for="deposit_status-active"
                                           class="lf-switch-label">{{ __('Active') }}</label>

                                    {{ Form::radio('deposit_status', INACTIVE, false, ['id' => 'deposit_status-inactive', 'class' => 'lf-switch-input']) }}
                                    <label for="deposit_status-inactive"
                                           class="lf-switch-label">{{ __('Inactive') }}</label>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('deposit_status') }}</span>
                            </div>
                        </div>

                        {{ Form::submit( __('Update'), ['class'=>'btn btn-info btn-block form-submission-button'] ) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet"
          href="{{ asset('public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    @include('currency._style')
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script src="{{ asset('public/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            let minDepositNumericRule = "{{ $currency->type === CURRENCY_TYPE_CRYPTO ? '0.00000001,99999999999.99999999' : '0.01,99999999999.99' }}";

            $('#deposit-options-form').cValidate({
                rules: {
                    min_deposit: 'required|numeric|between:' + minDepositNumericRule + '|escapeInput',
                    deposit_status: 'required|in:{{ array_to_string(active_status()) }}',
                }
            });
        }) (jQuery);
    </script>
@endsection
