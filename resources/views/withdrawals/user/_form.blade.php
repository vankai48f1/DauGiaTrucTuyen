@if($wallet->currency->withdrawal_status != ACTIVE)
    <div class="text-center">
        <h4 class="py-5 mt-0 font-weight-bold strong">
            {{ __('Withdrawal is currently disabled for this currency.') }}
        </h4>
    </div>
@elseif(
    !isset($wallet->currency->payment_methods['selected_payment_methods']) ||
    count($wallet->currency->payment_methods['selected_payment_methods']) < 1
)
    <div class="text-center">
        <h4 class="py-5 mt-0 font-weight-bold strong">
            {{ __('No payment method is available to withdraw for this currency.') }}
        </h4>
    </div>
@else

    {!! Form::open(['route'=>['wallets.withdrawals.store', $wallet->currency_symbol], 'method' => 'post', 'class'=>'form-horizontal validator dark-text-color', 'id' => 'withdrawalForm']) !!}
    <div class="form-group {{ $errors->has('payment_method') ? 'has-error' : '' }}">
        <label for="payment_method"
               class="control-label required">{{ __('Withdrawal with') }}</label>
        <div>
            {{ Form::select('payment_method', $paymentMethods, null, ['class' => form_validation($errors, 'address custom-select my-1 mr-sm-2'), 'id' => 'payment_method', 'placeholder' => __('Select payment method'), '@change' => 'changePaymentMethod']) }}

            <span class="invalid-feedback" data-name="payment_method">{{ $errors->first('payment_method') }}</span>
        </div>
    </div>
    <div v-if="showBank">
        {{--bank_account_id--}}
        <div class="form-group {{ $errors->has('bank_account_id') ? 'has-error' : '' }}">
            <label for="bank_account_id"
                   class="control-label required">{{ __('Select a Bank') }}</label>
            <div>
                @forelse($bankAccounts as $bankAccountId => $bankAccountName)
                    <div class="lf-radio">
                        {{ Form::radio('bank_account_id', $bankAccountId, old('bank_account_id', null), ['id' => 'bank-' . $bankAccountId, 'class' => 'form-check-input']) }}

                        <label class="form-check-label"
                               for="bank-{{ $bankAccountId }}">{{ $bankAccountName }}</label>
                    </div>
                @empty
                    <div class="text-warning">
                        {{ __('No Bank Account is available.') }} <a
                            href="{{ route('bank-accounts.create') }}" class="text-info">{{ __('Please add bank.') }}</a>
                    </div>
                @endforelse

                <span class="invalid-feedback" data-name="bank_account_id">{{ $errors->first('bank_account_id') }}</span>
            </div>
        </div>
    </div>

    <div v-if="showPaypal">
        {{--address--}}
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            <label for="address"
                   class="control-label required">{{ __('Receiver Email') }}</label>
            <div>
                {{ Form::email('address',  old('address', null), ['class'=> form_validation($errors, 'address'), 'id' =>'address', 'placeholder' => __('Enter Email')]) }}
                <span class="invalid-feedback" data-name="address">{{ $errors->first('address') }}</span>
                <span class="help-block small color-999">{{__('The email address of the paypal receiver.') }}</span>
            </div>
        </div>
    </div>

    {{--amount--}}
    <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
        <label for="amount"
               class="control-label required">{{ __('Amount') }}</label>
        <div>
            {{ Form::text('amount',  old('amount', null), ['class'=> form_validation($errors, 'amount'), 'id' =>'amount', 'placeholder' => __('ex: 20.99')]) }}
            <span class="invalid-feedback" data-name="amount">{{ $errors->first('amount') }}</span>
            <span class="help-block small color-999">{{ view_html( __('Minimum withdrawal amount is :amount :currency', ['amount' => '<span class="font-weight-bold">' . number_format($wallet->currency->min_withdrawal, 2, '.', '') . '</span>', 'currency' => $wallet->currency_symbol]) ) }}</span>
        </div>
    </div>

    {{--withdrawal_policy--}}
    <div class="form-group {{ $errors->has('withdrawal_policy') ? 'has-error' : '' }}">
        <div class="d-flex mt-4">
            <div class="lf-checkbox">
                {{ Form::checkbox('withdrawal_policy', 1, false, ['id' => 'policy']) }}
                <label for="policy">{{ __("Accept withdrawal's policy.") }}</label>
            </div>
            <a class="ml-2 text-info" target="_blank" href="/withdrawal-policy-page"><small>{{ __("Withdrawal's policy page") }}</small></a>
        </div>
        <span class="invalid-feedback" data-name="withdrawal_policy">{{ $errors->first('withdrawal_policy') }}</span>
    </div>

    {{--submit button--}}
    <div class="form-group">
        {{ Form::submit(__('Withdraw Balance'),['class'=>'btn btn-info form-submission-button']) }}
    </div>
    {!! Form::close() !!}
@endif
