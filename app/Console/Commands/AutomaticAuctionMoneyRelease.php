<?php

namespace App\Console\Commands;

use App\Jobs\AuctionMoneyRelease;
use App\Models\User\Auction;
use Illuminate\Console\Command;

class AutomaticAuctionMoneyRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:release-money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic money release command.';

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
        $auctions = Auction::getUnreleased();

        if (!$auctions->isEmpty()) {
            foreach ($auctions as $auction) {
                AuctionMoneyRelease::dispatchNow($auction->id);
            }
        }
    }
}
