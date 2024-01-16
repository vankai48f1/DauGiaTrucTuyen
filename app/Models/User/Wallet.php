<?php

namespace App\Models\User;

use App\Models\Auction\Currency;
use App\Models\Core\User;
use App\Override\Eloquent\LaraframeModel as Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'currency_symbol',
        'balance',
        'on_order',
        'is_system',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_symbol', 'symbol');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkMissingWallets()
    {
        $date = now();
        $walletAttributes = [];
        $missingCurrencies = Currency::active()
            ->whereNotIn('symbol', auth()->user()->wallets->pluck('currency_symbol')->toArray())
            ->pluck('symbol');

        foreach ($missingCurrencies as $currencySymbol) {
            $walletAttributes[] = [
                'user_id' => auth()->id(),
                'currency_symbol' => $currencySymbol,
                'is_system' => INACTIVE,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        if (!empty($walletAttributes)) {
            $this->insert($walletAttributes);
        }
    }
}
