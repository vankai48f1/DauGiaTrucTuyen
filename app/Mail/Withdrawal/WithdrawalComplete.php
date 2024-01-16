<?php

namespace App\Mail\Withdrawal;

use App\Models\User\WalletTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalComplete extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $withdrawal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WalletTransaction $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.withdrawals.complete')
            ->subject("Withdrawal Confirmation");
    }
}
