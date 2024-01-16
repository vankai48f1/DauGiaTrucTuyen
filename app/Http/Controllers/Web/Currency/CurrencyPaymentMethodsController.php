<?php

namespace App\Http\Controllers\Web\Currency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyPaymentMethodsRequest;
use App\Models\Auction\Currency;
use App\Models\User\BankAccount;

class CurrencyPaymentMethodsController extends Controller
{
    public function edit(Currency $currency)
    {
        $data['title'] = __('Payment Method Options');
        $data['currency'] = $currency;
        $data['bankAccounts'] = BankAccount::whereNull('user_id')->pluck('bank_name', 'id');

        return view('currency.payment_methods.edit', $data);
    }

    public function update(CurrencyPaymentMethodsRequest $request, Currency $currency)
    {
        $paymentMethods['selected_payment_methods'] = $request->get('payment_methods', []);

        if (
            $currency->type === CURRENCY_TYPE_FIAT &&
            in_array(PAYMENT_METHOD_BANK, $paymentMethods['selected_payment_methods'])
        ) {
            $paymentMethods['selected_banks'] = $request->get('banks', []);
        }

        if ($currency->update(['payment_methods' => $paymentMethods])) {
            return redirect()
                ->route('admin.currencies.payment-methods.edit', $currency->symbol)
                ->with(RESPONSE_TYPE_SUCCESS, __("The currency's payment methods has been updated successfully."));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __("Failed to update the currency's payment methods! Please try again."));
    }
}
