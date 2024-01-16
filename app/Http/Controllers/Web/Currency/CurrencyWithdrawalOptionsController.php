<?php

namespace App\Http\Controllers\Web\Currency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyWithdrawalOptionsRequest;
use App\Models\Auction\Currency;

class CurrencyWithdrawalOptionsController extends Controller
{
    public function edit(Currency $currency)
    {
        $data['title'] = __('Withdrawal Options');
        $data['currency'] = $currency;

        return view('currency.withdrawal_options.edit', $data);
    }

    public function update(CurrencyWithdrawalOptionsRequest $request, Currency $currency)
    {
        if ($currency->update($request->validated())) {
            return redirect()
                ->route('admin.currencies.withdrawal-options.edit', $currency->symbol)
                ->with(RESPONSE_TYPE_SUCCESS, __("The currency's withdrawal options has been updated successfully."));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __("Failed to update the currency's withdrawal options! Please try again."));
    }
}
