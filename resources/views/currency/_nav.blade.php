<div class="currency-tab-nav border border-bottom-0">
    <a class="nav-link border-left-0 {{ is_current_route('admin.currencies.edit','active') }}"
       href="{{ route('admin.currencies.edit', $currency->symbol) }}">{{ __('Details') }}</a>
    <a class="nav-link {{ is_current_route('admin.currencies.payment-methods.edit','active') }}"
       href="{{ route('admin.currencies.payment-methods.edit', ['currency' => $currency->symbol]) }}">{{ __('Payment Method') }}</a>
    <a class="nav-link {{ is_current_route('admin.currencies.deposit-options.edit','active') }}"
       href="{{ route('admin.currencies.deposit-options.edit', ['currency' => $currency->symbol]) }}">{{ __('Deposit Options') }}</a>
    <a class="nav-link {{ is_current_route('admin.currencies.withdrawal-options.edit','active') }}"
       href="{{ route('admin.currencies.withdrawal-options.edit', ['currency' => $currency->symbol]) }}">{{ __('Withdrawal Options') }}</a>
</div>
