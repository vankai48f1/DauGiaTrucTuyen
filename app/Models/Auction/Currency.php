<?php

namespace App\Models\Auction;

use App\Models\User\Auction;
use App\Models\User\Wallet;
use App\Override\Eloquent\LaraframeModel as Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'logo',
        'type',
        'is_active',
        'deposit_status',
        'min_deposit',
        'withdrawal_status',
        'min_withdrawal',
        'payment_methods',
        'deposit_fee',
        'deposit_fee_type',
        'withdrawal_fee',
        'withdrawal_fee_type',
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function getPaymentMethodsAttribute($value): array
    {
        return !is_null($value) ? json_decode($value, true) : [];
    }
}
