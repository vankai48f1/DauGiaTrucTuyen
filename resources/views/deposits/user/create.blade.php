@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 my-5 p-y-100">
                @component('components.card')
                    @slot('header')
                        <h3 class="font-weight-bold d-inline color-666">{{$title}}</h3>
                    @endslot
                    @if( $wallet->currency->deposit_status != ACTIVE)
                        <div class="text-center my-5">
                            {{ __('Deposit is currently disabled for this currency.') }}
                        </div>
                    @elseif(
                        !isset($wallet->currency->payment_methods['selected_payment_methods']) ||
                        count($wallet->currency->payment_methods['selected_payment_methods']) < 1
                    )
                        <div class="text-center my-5">
                            {{ __('No payment method is available to deposit for this currency.') }}
                        </div>
                    @else
                        {{ Form::open(['route' => ['wallets.deposits.store', $wallet->currency_symbol], 'id' => 'deposit-form']) }}
                        <div class="form-group">
                            <label class="font-weight-lighter"
                                   for="payment_method">{{ __('Select Deposit Method') }} :</label>
                            {{ Form::select('payment_method', $paymentMethods, null, [
                                'class' => 'custom-select my-1 mr-sm-2',
                                'id' => 'payment_method',
                                'placeholder' => __('Select payment method'),
                                '@change' => 'changePaymentMethod'
                            ]) }}
                            <span class="invalid-feedback">{{ $errors->first('payment_method') }}</span>
                        </div>

                        <div v-if="showBank">
                            {{--bank_account_id--}}
                            <div class="form-group">
                                <label for="bank_account_id"
                                       class="control-label required">{{ __('Select a Bank') }}</label>
                                <div>
                                    @forelse($bankAccounts as $bankAccountId => $bankAccountName)
                                        <div class="lf-radio">
                                            {{ Form::radio('bank_account_id', $bankAccountId, null, ['id' => 'bank-' . $bankAccountId,
                                            'class' => 'form-check-input']) }}
                                            <label class="form-check-label" for="bank-{{ $bankAccountId }}">
                                                {{ $bankAccountName }}
                                            </label>
                                        </div>
                                    @empty
                                        <div class="font-weight-bold">
                                            {{ __('No Bank Account is available.') }}
                                            <a href="{{ route('bank-accounts.create') }}">{{ __('Please add bank.') }}</a>
                                        </div>
                                    @endforelse

                                    <span class="invalid-feedback"
                                          data-name="bank_account_id">{{ $errors->first('bank_account_id') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-lighter" for="wallet">{{ __('Total Amount') }}
                                :</label>
                            {{ Form::text('amount', null, ['class'=> 'form-control', 'id' => 'amount','data-cval-name' => 'The amount field','data-cval-rules' => 'required|decimal']) }}
                            <span class="invalid-feedback">{{ $errors->first('amount') }}</span>

                            <span
                                class="help-block small color-999">{{ view_html( __('Minimum deposit amount is :amount :currency', ['amount' => '<span class="font-weight-bold">' . number_format($wallet->currency->min_deposit, 2, '.', '') . '</span>', 'currency' => $wallet->currency_symbol]) ) }}</span>
                        </div>

                        {{--deposit_policy--}}
                        <div class="form-group">
                            <label class="control-label"></label>
                            <div class="d-flex">
                                <div class="lf-checkbox">
                                    {{ Form::checkbox('deposit_policy', 1, false, ['id' => 'policy']) }}
                                    <label for="policy"> {{ __("Accept deposit's policy.") }}</label>
                                </div>
                                <a class="ml-2 text-info"
                                   target="_blank"
                                   href="/deposit-policy"><small>{{ __("Deposit's policy page") }}</small></a>
                            </div>
                            <span class="invalid-feedback"
                                  data-name="deposit_policy">{{ $errors->first('deposit_policy') }}</span>
                        </div>

                        <button type="submit"
                                class="btn btn-info btn-block form-submission-button">{{__('Deposit')}}</button>
                        {{ Form::close() }}
                    @endif
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>

    <script type="text/javascript">
        (function ($) {
            "use strict";

            $('#deposit-form').cValidate({
                rules: {
                    'api': 'required',
                    'bank_account_id': 'requiredIf:payment_method,{{PAYMENT_METHOD_BANK}}',
                    'amount': 'required|numeric|between:' + "{{ number_format($wallet->currency->min_deposit, 2, '.', '') }}" + ',99999999999.99999999|decimalScale:11,8',
                    'deposit_policy': 'required'
                }
            });
        }) (jQuery);

        new Vue({
            el: '#app',
            data: {
                showBank: "{{ old('api') === PAYMENT_METHOD_BANK ? true : false }}",
            },
            methods: {
                changePaymentMethod(event) {
                    this.showBank = event.target.value == "{{ PAYMENT_METHOD_BANK }}" ? true : false;
                }
            }
        });
    </script>
@endsection
