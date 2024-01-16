<?php

namespace App\Console;

use App\Jobs\AutomaticAuctionMoneyRelease;
use App\Jobs\CheckAuctionCompletion;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        //
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('auction:completed')
            ->dailyAt('00:01')
            ->runInBackground();

        if (!settings('seller_money_release',false, true)) {
            $schedule->command('auction:release-money')
                ->dailyAt('00:01')
                ->runInBackground();
        }
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
