<?php

namespace App\Models\User;

use App\Override\Eloquent\LaraframeModel as Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'ref_id',
        'wallet_id',
        'model_id',
        'model',
        'amount',
        'journal_type',
        'journal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
