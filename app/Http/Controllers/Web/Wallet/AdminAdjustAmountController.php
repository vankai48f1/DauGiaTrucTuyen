<?php

namespace App\Http\Controllers\Web\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\AdminAdjustAmountRequest;
use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminAdjustAmountController extends Controller
{
    public function create(User $user, Wallet $wallet): View
    {
        $data['title'] = __('Adjustment Wallet Amount: :wallet', ['wallet' => $wallet->currency_symbol]);
        $data['wallet'] = $wallet;

        return view('currency.adjust_amount', $data);
    }

    public function store(AdminAdjustAmountRequest $request, User $user, Wallet $wallet)
    {
        if ($wallet->user_id != $user->id) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_WARNING, __('Failed to update the wallet balance for illegal wallet info.'));
        }

        if (
            $request->type == TRANSACTION_TYPE_BALANCE_DECREMENT &&
            ($wallet->balance < $request->amount)
        ) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_WARNING, __('Failed to update the wallet balance for illegal amount.'));
        }

        try {
            DB::beginTransaction();

            if ($request->type == TRANSACTION_TYPE_BALANCE_DECREMENT) {
                $wallet->decrement('balance', $request->amount);
            } else {
                $wallet->increment('balance', $request->amount);
            }

            Notification::create([
                'user_id' => $wallet->user_id,
                'message' => __("Your :currency wallet has been :type with :amount :currency by system.", [
                    'amount' => $request->amount,
                    'currency' => $wallet->currency_symbol,
                    'type' => $request->type == TRANSACTION_TYPE_BALANCE_DECREMENT ? __('decreased') : __('increased')
                ]),
            ]);

            $txnID = Str::uuid();

            WalletTransaction::create([
                'user_id' => $user->id,
                'txn_type' => $request->type,
                'wallet_id' => $wallet->id,
                'currency_symbol' => $wallet->currency_symbol,
                'amount' => $request->amount,
                'status' => $request->amount,
                'payment_txn_id' => $txnID,
                'ref_id' => $txnID,
            ]);

            DB::commit();

            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('The wallet balance has been updated successfully.'));
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to update the wallet balance.'));
        }
    }
}
