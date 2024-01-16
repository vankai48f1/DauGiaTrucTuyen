<?php

namespace App\Console\Commands;

use App\Models\Core\User;
use App\Models\Core\UserProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding users';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        factory(User::class, 100000)->create([
            'password' => Hash::make('123456'),
        ])->each(function ($user) {
            $user->profile()->save(factory(UserProfile::class)->make());
        });
    }
}
