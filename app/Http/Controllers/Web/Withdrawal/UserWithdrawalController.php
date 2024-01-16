<?php

namespace App\Http\Controllers\Web\Withdrawal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Withdrawal\WithdrawalRequest;
use App\Jobs\Withdrawal;
use App\Models\User\BankAccount;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Logger\Logger;
use App\Services\Wallet\WalletTransactionService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserWithdrawalController extends Controller
{
    public $service;

    public function __construct(WalletTransactionService $walletTransactionService)
    {
        $this->service = $walletTransactionService;
    }

    public function index(Wallet $wallet): View
    {
        $data['dataTable'] = $this->service->walletTransaction($wallet, TRANSACTION_TYPE_WITHDRAWAL);
        $data['user'] = auth()->user();
        $data['title'] = 'Withdrawal History';

        return view('withdrawals.user.index', $data);
    }

    public function create(Wallet $wallet): View
    {
        $data['title'] = __('Withdraw :symbol', ['symbol' => $wallet->currency_symbol]);
        $data['wallet'] = $wallet->load('currency');
        $paymentMethods = fiat_payment_methods() + crypto_payment_methods();

        $paymentMethodKeys = isset($wallet->currency->payment_methods['selected_payment_methods']) &&
            !empty($wallet->currency->payment_methods['selected_payment_methods']) ?
            $wallet->currency->payment_methods['selected_payment_methods'] : [];

        $data['paymentMethods'] = Arr::only($paymentMethods, $paymentMethodKeys);

        $data['bankAccounts'] = [];
        if (
            isset($data['wallet']->currency->payment_methods['selected_payment_methods']) &&
            in_array(PAYMENT_METHOD_BANK, $data['wallet']->currency->payment_methods['selected_payment_methods'])
        ) {
            $data['bankAccounts'] = BankAccount::where('user_id', Auth::id())
                ->where('is_active', ACTIVE)
                ->where('is_verified', VERIFICATION_STATUS_APPROVED)
                ->pluck('bank_name', 'id');
        }

        return view("withdrawals.user.create", $data);
    }

    public function store(WithdrawalRequest $request, Wallet $wallet): RedirectResponse
    {
        $wallet->load('currency');

        if ($wallet->currency->withdrawal_status == INACTIVE || !isset($wallet->currency->payment_methods['selected_payment_methods'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with(RESPONSE_TYPE_ERROR, __("The withdrawal is currently disabled."));
        }

        if ( $request->get('amount') > $wallet->balance ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(RESPONSE_TYPE_ERROR, __("You don't have enough balance to withdrawal!. Your current balance is :amount", [
                        'amount' => $wallet->balance,
                    ])
                );
        }
        $systemFee = calculate_withdrawal_system_fee($request->amount, $wallet->currency->withdrawal_fee, $wallet->currency->withdrawal_fee_type);

        $refId = Str::uuid();
        $params = [
            'user_id' => Auth::id(),
            'wallet_id' => $wallet->id,
            'currency_symbol' => $wallet->currency_symbol,
            'address' => $request->address,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => PAYMENT_STATUS_PENDING,
            'txn_type' => TRANSACTION_TYPE_WITHDRAWAL,
            'ref_id' => $refId,
            'network_fee' => 0,
            'system_fee' => $systemFee,
        ];

        if ($request->has('payment_method') && $request->get('payment_method') == PAYMENT_METHOD_BANK) {
            $params['bank_account_id'] = $request->get('bank_account_id');
            $params['payment_method'] = $request->get('payment_method');
            $params['status'] = PAYMENT_STATUS_REVIEWING;
            $params['payment_txn_id'] = $refId;
        }

        try {
            DB::beginTransaction();

            if (!$wallet->decrement('balance', $request->amount)) {
                throw new Exception(__('Failed to update wallet.'));
            }

            $withdrawal = WalletTransaction::create($params);

            if (empty($withdrawal)) {
                throw new Exception(__('Failed to create withdrawal.'));
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Logger::error($exception, "[FAILED][Withdrawal][store]");

            return redirect()
                ->back()
                ->withInput()
                ->with(RESPONSE_TYPE_ERROR, __("Unable to withdraw amount."));
        }

        if ($request->has('payment_method') && $request->get('payment_method') == PAYMENT_METHOD_PAYPAL) {
            Withdrawal::dispatchNow($withdrawal);
        }

        return redirect()
            ->route('wallets.withdrawals.index', ['wallet' => $wallet->currency_symbol])
            ->with(RESPONSE_TYPE_SUCCESS, __("Your withdrawal has been placed successfully."));
    }

    public function show(Wallet $wallet, WalletTransaction $withdrawal)
    {
        abort_if(Auth::id() != $withdrawal->user_id, 404);

        $wallet->load('currency');
        if (!is_null($withdrawal->bank_account_id)) {
            $withdrawal->load('user.profile', 'bankAccount.country');
        }

        $data['wallet'] = $wallet;
        $data['withdrawal'] = $withdrawal;
        $data['title'] = __("Withdrawal Details");
        return view('withdrawals.user.show', $data);
    }

    public function destroy(Wallet $wallet, WalletTransaction $withdrawal): RedirectResponse
    {
        abort_if(Auth::id() != $withdrawal->user_id, 404);
        DB::beginTransaction();
        try {
            //Change withdrawal status to FAILED
            if (!$withdrawal->update(['status' => PAYMENT_STATUS_CANCELED])) {
                throw new Exception(__("Failed to change status as canceled"));
            }

            //Increase wallet balance
            if (!$withdrawal->wallet()->increment('balance', $withdrawal->amount)) {
                throw new Exception(__("Failed to update wallet."));
            }
        } catch (Exception $exception) {
            DB::rollBack();
            Logger::error($exception, "[FAILED][WithdrawalService][cancel]");
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __("Failed to cancel withdrawal."));
        }

        DB::commit();

        return redirect()
            ->route('wallets.withdrawals.index', $withdrawal->currency_symbol)
            ->with(RESPONSE_TYPE_SUCCESS, __("Successfully withdrawal cancellation process completed."));
    }
}
