<?php

namespace App\Http\Controllers\Web\Currency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyDepositOptionsRequest;
use App\Models\Auction\Currency;

class CurrencyDepositOptionsController extends Controller
{
    public function edit(Currency $currency)
    {
        $data['title'] = __('Deposit Options');
        $data['currency'] = $currency;

        return view('currency.deposit_options.edit', $data);
    }

    public function update(CurrencyDepositOptionsRequest $request, Currency $currency)
    {
        if ($currency->update($request->validated())) {
            return redirect()
                ->route('admin.currencies.deposit-options.edit', $currency->symbol)
                ->with(RESPONSE_TYPE_SUCCESS, __("The currency's deposit options has been updated successfully."));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __("Failed to update the currency's deposit options! Please try again."));
    }
}
