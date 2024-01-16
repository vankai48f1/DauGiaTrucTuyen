<?php

namespace App\Jobs;

use App\Models\Core\Notification;
use App\Services\Logger\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class Withdrawal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $withdrawal;
    private $apiPath = 'App\\Services\\Api\\';

    public function __construct($withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function handle()
    {
        try {
            $actualAmount = ($this->withdrawal->amount - $this->withdrawal->system_fee);
            $paymentApiClass = $this->apiPath . payment_method_api($this->withdrawal->payment_method);
            $paymentApi = new $paymentApiClass();
            $payload = [
                'receiver' => $this->withdrawal->address,
                'amount' => $actualAmount
            ];
            $paymentApiResponse = $paymentApi->payout($payload);

            if ($paymentApiResponse[RESPONSE_STATUS_KEY]) {
                $this->withdrawal->update(['payment_txn_id' => $paymentApiResponse[RESPONSE_DATA_KEY]['batch_header']['payout_batch_id']]);
            } else {
                $this->withdrawal->update(['status' => PAYMENT_STATUS_FAILED]);
                $this->withdrawal->wallet()->increment('balance', $this->withdrawal->amount);

                $notification = [
                    'user_id' => auth()->id(),
                    'message' => __('Your withdrawal request of :currency :amount to :address has been failed. The amount has been reversed to your balance.', [
                        'currency' => $this->withdrawal->currency_symbol,
                        'amount' => $this->withdrawal->amount,
                    ]),
                    'link' => route('wallets.withdrawals.show', [
                        'wallet' => $this->withdrawal->currency_symbol,
                        'withdrawal' => $this->withdrawal->id
                    ])
                ];

                Notification::create($notification);
            }
        }
        catch (Exception $exception) {
            Logger::error($exception, '[FAILED][Withdrawal][handle]');
        }
    }
}
