@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">                 @include('currency._nav')
                <div class="card border-top-0">
                    <div
                        class="card-body bg-grey-light p-5">                         {{ Form::model($currency, ['route' => ['admin.currencies.payment-methods.update', $currency->symbol], 'id' => 'payment-methods-form', 'method' => 'PUT']) }}
                        <div class="form-group form-row">
                            <div class="col-md-5"><label for="payment_methods"
                                                         class="control-label required">{{ __('Select Payment Method') }}</label>
                            </div>
                            <div
                                class="col-md-7">                                 @if($currency->type === CURRENCY_TYPE_CRYPTO)                                     {{ Form::select('payment_methods[]', crypto_payment_methods(), old('payment_methods', $currency->payment_methods['selected_payment_methods']), ['class' => form_validation($errors, 'payment_methods'), 'id' => 'payment_methods', 'placeholder' => __('Select Payment Method')]) }}                                 @else                                     @forelse(fiat_payment_methods() as $paymentMethod => $paymentMethodName)
                                    <div
                                        class="lf-checkbox p-0 my-2">                                             {{ Form::checkbox('payment_methods[]', $paymentMethod, null, ['id' => 'paymentMethod-' . $paymentMethod, 'class' => 'lf-switch-input','@change' => $paymentMethod == PAYMENT_METHOD_BANK ? 'onSelectBankMethods' : '', in_array($paymentMethod, $currency->payment_methods['selected_payment_methods'] ?? []) ? 'checked' : '']) }}
                                        <label for="paymentMethod-{{ $paymentMethod }}"
                                               class="lf-switch-label lf-switch-label-on">                                                 {{ $paymentMethodName }}                                             </label>
                                    </div>                                     @empty                                         {{ __('No payment method is available.') }}                                     @endforelse
                                <span class="invalid-feedback"
                                      data-name="payment_methods[]">{{ $errors->first('payment_methods') }}</span>                                 @endif
                            </div>
                        </div>
                        <div v-if="showBanks">
                            <div
                                class="form-group form-row">                                 @if(!$bankAccounts->isEmpty())
                                    <div class="col-md-5"><label for="banks"
                                                                 class="control-label">{{ __('Select Bank(s)') }}</label>
                                    </div>
                                    <div
                                        class="col-md-7">                                     @foreach($bankAccounts as $bankAccountId => $bankAccountName)
                                            <div
                                                class="lf-checkbox p-0 my-2">                                                 {{ Form::checkbox('banks[]', $bankAccountId, null, [                                                     'id' => 'bank-' . $bankAccountId,                                                     'class' => 'lf-switch-input',                                                      in_array($bankAccountId, isset($currency->payment_methods['selected_banks']) ?                                                         $currency->payment_methods['selected_banks'] : []) ?                                                             'checked' : ''                                                 ]) }}
                                                <label for="bank-{{ $bankAccountId }}"
                                                       class="lf-switch-label lf-switch-label-on">                                                     {{ $bankAccountName }}                                                 </label>
                                            </div>                                         @endforeach
                                    </div>                                 @else                                     <p
                                        class="text-danger">{{ __('No Bank Account is available.') }}                                         @if(has_permission('system-banks.create'))
                                            <a href="{{ route('system-banks.create') }}">{{ __('Add system bank account') }}</a>                                         @endif
                                    </p>                                 @endif <span class="invalid-feedback"
                                                                                      data-name="banks[]">{{ $errors->first('banks') }}</span>
                            </div>
                        </div>
                        <div
                            class="form-group">                             {{ Form::submit( __('Update'), ['class'=>'btn btn-info btn-block form-submission-button'] ) }}                         </div> {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    @include('currency._style')
@endsection

@section('script')
    <script src="{{ asset('plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script>
        "use strict";

        new Vue({
            el: '#app',
            data: {showBanks: "{{  (old('banks.0', ($currency->type === CURRENCY_TYPE_FIAT && isset($currency->payment_methods['selected_banks']))) ? true : false )}}"},
            methods: {
                onSelectBankMethods: function (event) {
                    this.showBanks = event.target.checked;
                }
            }
        });
    </script>
@endsection

