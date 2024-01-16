<?php

namespace App\Http\Controllers\Web\Deposit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deposit\BankReceiptRequest;
use App\Http\Requests\Deposit\DepositRequest;
use App\Models\User\BankAccount;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Api\PaypalAPI;
use App\Services\Core\FileUploadService;
use App\Services\Wallet\WalletTransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserDepositController extends Controller
{
    public $service;

    public function __construct(WalletTransactionService $walletTransactionService)
    {
        $this->service = $walletTransactionService;
    }

    public function index(Wallet $wallet): View
    {
        $data['dataTable'] = $this->service->walletTransaction($wallet, TRANSACTION_TYPE_DEPOSIT);
        $data['user'] = Auth::user();
        $data['title'] = 'Deposit History';
        return view('deposits.user.index', $data);
    }

    public function create(Wallet $wallet): View
    {
        $data['title'] = 'Deposit';
        $data['wallet'] = $wallet->load('currency');
        $paymentMethodKeys = isset($wallet->currency->payment_methods['selected_payment_methods']) && !empty($wallet->currency->payment_methods['selected_payment_methods']) ? $wallet->currency->payment_methods['selected_payment_methods'] : [];
        $data['paymentMethods'] = Arr::only(fiat_payment_methods(), $paymentMethodKeys);

        $data['bankAccounts'] = BankAccount::where('user_id', Auth::id())
            ->where('is_active', ACTIVE)
            ->pluck('bank_name', 'id');

        return view('deposits.user.create', $data);
    }

    public function store(DepositRequest $request, Wallet $wallet): RedirectResponse
    {
        if ($wallet->currency->deposit_status == INACTIVE || !isset($wallet->currency->payment_methods['selected_payment_methods'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with(RESPONSE_TYPE_ERROR, __("The deposit is currently disabled."));
        }

        $systemFee = calculate_deposit_system_fee(
            $request->get('amount'),
            $wallet->currency->deposit_fee,
            $wallet->currency->deposit_fee_type
        );

        if ($request->payment_method == PAYMENT_METHOD_PAYPAL) {
            $paypalApi = new PaypalAPI();
            $referenceID = auth()->id() . '_' . Str::uuid()->toString();
            $payload = [
                'amount' => $request->amount,
                'currency' => $wallet->currency_symbol,
                'return_url' => route('paypal.return-url'),
                'cancel_url' => route('paypal.cancel-url'),
                'reference_id' => $referenceID,
            ];

            $response = $paypalApi->createOrder($payload);

            if ($response[RESPONSE_STATUS_KEY]) {
                $parameters['payment_txn_id'] = $response[RESPONSE_DATA_KEY]['id'];

                $link = Arr::first($response[RESPONSE_DATA_KEY]['links'], function ($link) {
                    return $link['rel'] === 'approve';
                });

                if (!empty($link)) {
                    return redirect()->away($link['href']);
                }
            }

            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to create the deposit.'));
        }

        $parameters = $request->only('payment_method', 'amount', 'bank_account_id');
        $parameters['user_id'] = auth()->id();
        $parameters['wallet_id'] = $wallet->id;
        $parameters['status'] = PAYMENT_STATUS_PENDING;
        $parameters['txn_type'] = TRANSACTION_TYPE_DEPOSIT;
        $parameters['ref_id'] = Str::uuid()->toString();
        $parameters['currency_symbol'] = $wallet->currency_symbol;
        $parameters['system_fee'] = $systemFee;

        if ($request->payment_method == PAYMENT_METHOD_BANK) {
            $parameters['payment_txn_id'] = $parameters['ref_id'];
        }

        if ($walletTransaction = WalletTransaction::create($parameters)) {
            return redirect()->route('wallets.deposits.show', [
                'wallet' => $walletTransaction->currency_symbol,
                'deposit' => $walletTransaction->id
            ])
                ->with(RESPONSE_TYPE_SUCCESS, __('The deposit has been created successfully.'));
        }


        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to create the deposit. Please try again.'));
    }

    public function show(Wallet $wallet, WalletTransaction $walletTransaction): View
    {
        $data['title'] = 'Deposit Detail';
        $data['deposit'] = $walletTransaction;
        $data['wallet'] = $wallet;

        if ($data['deposit']->status == PAYMENT_STATUS_PENDING && $data['deposit']->payment_method == PAYMENT_METHOD_BANK) {
            $systemBankIds = isset($wallet->currency->payment_methods['selected_banks']) && !empty($wallet->currency->payment_methods['selected_banks']) ? $wallet->currency->payment_methods['selected_banks'] : [];
            $data['systemBanks'] = BankAccount::whereIn('id', $systemBankIds)->where('is_active', ACTIVE)->with('country')->get();
        }

        return view('deposits.user.show', $data);
    }

    public function update(BankReceiptRequest $request, Wallet $wallet, WalletTransaction $deposit): RedirectResponse
    {
        $wallet->load('currency');
        $systemBank = $request->get('system_bank_id');
        $systemSupportedBanks = isset($wallet->currency->payment_methods['selected_banks']) && !empty($wallet->currency->payment_methods['selected_banks']) ? $wallet->currency->payment_methods['selected_banks'] : [];

        if (!in_array($systemBank, $systemSupportedBanks)) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __("Invalid system bank."));
        }

        if ($request->hasFile('receipt')) {
            $filePath = 'public/' . config('commonconfig.path_deposit_receipt');
            $receipt = app(FileUploadService::class)->upload($request->file('receipt'), $filePath, $deposit->id);
        }

        $params = ['system_bank_account_id' => $systemBank, 'receipt' => $receipt, 'status' => PAYMENT_STATUS_REVIEWING];

        if ($deposit->update($params)) {
            return redirect()->route('wallets.deposits.show', ['wallet' => $wallet->currency_symbol, 'deposit' => $deposit->id])->with(RESPONSE_TYPE_SUCCESS, __('Receipt has been uploaded successfully.'));
        }
        return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __("Failed to upload receipt."));
    }
}
