@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('content')
    <div class="container py-5" id="app">
        <div class="row justify-content-center">
            <div class="col-md-6 my-5">
                @component('components.card')
                    @slot('header')
                        <h3 class="font-weight-bold d-inline color-666">{{$title}} <span class="text-success small float-right">{{ __('CURRENT BALANCE : :amount :currency', ['amount' => $wallet->balance, 'currency' => $wallet->currency_symbol]) }}</span></h3>
                    @endslot
                    @include('withdrawals.user._form')
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
    <script>
        var rules = {
            'amount' : 'required|numeric|min:{{$wallet->currency->min_withdrawal}}',
            'withdrawal_policy' : 'required',
            'payment_method' : 'required',
        };
        (function ($) {
            "use strict";

            var form =$('#withdrawalForm').cValidate({
                rules : rules
            });
        })(jQuery);
    </script>
    @if(isset($wallet->currency->payment_methods['selected_payment_methods']))
    <script>
        "use strict";
        new Vue({
            el: '#app',
            data: {
                showBank: "{{ old('payment_method') == PAYMENT_METHOD_BANK ? true : false }}",
                showPaypal: "{{ old('payment_method') == PAYMENT_METHOD_PAYPAL ? true : false }}",
            },
            methods: {
                changePaymentMethod(event) {
                    if (event.target.value === "{{ PAYMENT_METHOD_BANK }}"){
                        this.showBank = true;
                        rules['bank_account_id'] = 'required';
                    }
                    else {
                        this.showBank = false;
                    }
                    this.showPaypal = (event.target.value === "{{ PAYMENT_METHOD_PAYPAL }}");
                }
            }
        });
    </script>
    @endif
@endsection

