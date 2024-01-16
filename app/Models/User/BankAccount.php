<?php

namespace App\Models\User;

use App\Models\Core\Country;
use App\Override\Eloquent\LaraframeModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class BankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'reference_number',
        'bank_name',
        'iban',
        'swift',
        'account_holder',
        'bank_address',
        'account_holder_address',
        'is_verified',
        'is_active',
        'country_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function getBankAccountNameAttribute(): string
    {
        return $this->bank_name . ' - ' . $this->iban;
    }

    public function deposits()
    {
        return $this->hasMany(WalletTransaction::class, 'bank_account_id', 'id')
            ->where('txn_type', TRANSACTION_TYPE_DEPOSIT);
    }

    public function withdrawals()
    {
        return $this->hasMany(WalletTransaction::class, 'bank_account_id', 'id')
            ->where('txn_type', TRANSACTION_TYPE_WITHDRAWAL);
    }

    public function scopeWithDepositCount($query)
    {
        return $query->addSelect([
            'deposit_count' => WalletTransaction::select(DB::raw('COUNT(*)'))
                ->whereColumn('bank_accounts.id', 'bank_account_id')
                ->where('txn_type', TRANSACTION_TYPE_DEPOSIT)
        ]);
    }
}
