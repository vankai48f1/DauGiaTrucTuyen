<?php

namespace App\Jobs\Deposit;

use App\Services\Api\PaypalAPI;
use App\Services\Transaction\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CapturePaypalOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $paypalApi = new PaypalAPI();
        $response = $paypalApi->captureOrder($this->id);

        if ( $response[RESPONSE_STATUS_KEY] && $response[RESPONSE_DATA_KEY]['status'] === 'COMPLETED' ) {
            $data = [
                'payment_txn_id' => $response[RESPONSE_DATA_KEY]['id'],
                'net_amount' => $response[RESPONSE_DATA_KEY]['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'],
                'network_fee' => $response[RESPONSE_DATA_KEY]['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'],
            ];

            app(PaymentService::class)->completePaypalOrder($data);
        }
    }
}
