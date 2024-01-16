<?php

namespace App\Console\Commands;

use App\Jobs\AuctionWinningProcessJob;
use App\Models\User\Auction;
use Illuminate\Console\Command;

class CheckAuctionCompletion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check completed auctions to select winner.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $auctions = Auction::getTodayCompletion();

        if (!$auctions->isEmpty()) {
            foreach ($auctions as $auction) {
                AuctionWinningProcessJob::dispatchNow($auction);
            }
        }
    }
}
