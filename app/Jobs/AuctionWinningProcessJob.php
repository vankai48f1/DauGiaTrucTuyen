<?php

namespace App\Jobs;

use App\Models\User\Auction;
use App\Services\User\WinnerSelectionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AuctionWinningProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function handle()
    {
        app(WinnerSelectionService::class)->winnerSelector($this->auction);
    }
}
