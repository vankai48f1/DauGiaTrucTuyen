@extends('layouts.master')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('currency._nav')
                <div class="card border-top-0">
                    <div class="card-body bg-grey-light p-5">
                        {{ Form::model($currency, ['route' => ['admin.currencies.withdrawal-options.update', $currency->symbol], 'id' => 'withdrawal-options-form', 'method' => 'PUT']) }}
                        {{--withdrawal_fee--}}
                        <div class="form-group form-row">
                            <div class="col-md-5">
                                {{Form::label('withdrawal_fee', __('Withdrawal Fee'))}} :
                            </div>
                            <div class="input-group col-md-7">
                                {{Form::text('withdrawal_fee', null, ['class' => form_validation($errors, 'name'), 'id' => 'withdrawal_fee'] )}}
                                <span class="input-group-append">
                                    {{ Form::select('withdrawal_fee_type', fee_types(),  null, ['class'=>'form-control no-select', 'id' => 'withdrawal_fee_type']) }}
                                </span>
                            </div>
                            <span class="invalid-feedback">{{ $errors->first('withdrawal_fee') }}</span>
                            <span class="invalid-feedback" data-name="withdrawal_fee_type">{{ $errors->first('withdrawal_fee') }}</span>
                        </div>
                        <div class="form-group form-row">
                            <div class="col-md-5">
                                {{Form::label('min_withdrawal', __('Minimum Withdrawal Amount'))}} :
                            </div>
                            <div class="col-md-7">
                                {{Form::text('min_withdrawal', null, ['class' => form_validation($errors, 'name'), 'id' => 'min_withdrawal'] )}}
                                <span class="invalid-feedback">{{ $errors->first('min_withdrawal') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <div class="col-md-5">
                                {{Form::label('withdrawal_status', __('Withdrawal Status'))}} :
                            </div>
                            <div class="col-md-7">
                                <div class="lf-switch">
                                    {{ Form::radio('withdrawal_status', ACTIVE, true , ['id' => 'withdrawal_status-active', 'class' => 'lf-switch-input']) }}
                                    <label for="withdrawal_status-active" class="lf-switch-label">{{ __('Active') }}</label>

                                    {{ Form::radio('withdrawal_status', INACTIVE, false, ['id' => 'withdrawal_status-inactive', 'class' => 'lf-switch-input']) }}
                                    <label for="withdrawal_status-inactive" class="lf-switch-label">{{ __('Inactive') }}</label>
                                </div>
                                <span class="invalid-feedback">{{ $errors->first('withdrawal_status') }}</span>
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
    <link rel="stylesheet" href="{{ asset('public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
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

            $('#withdrawal-options-form').cValidate({
                rules: {
                    min_withdrawal: 'required|numeric|between:'+ minDepositNumericRule +'|escapeInput',
                    withdrawal_status: 'required|in:{{ array_to_string(active_status()) }}',
                }
            });
        })(jQuery);
    </script>
@endsection
