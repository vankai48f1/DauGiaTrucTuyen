<?php

namespace App\Models\User;

use App\Models\Auction\Currency;
use App\Models\Core\User;
use App\Override\Eloquent\LaraframeModel as Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'txn_type',
        'payment_method',
        'wallet_id',
        'currency_symbol',
        'amount',
        'status',
        'address',
        'payment_txn_id',
        'ref_id',
        'network_fee',
        'system_fee',
        'bank_account_id',
        'receipt'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_symbol', 'symbol');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
