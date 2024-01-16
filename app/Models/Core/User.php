<?php

namespace App\Models\Core;

use App\Models\User\Address;
use App\Models\User\Bid;
use App\Models\User\Comment;
use App\Models\User\Dispute;
use App\Models\User\KnowYourCustomer;
use App\Models\User\Seller;
use App\Models\User\Transaction;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Override\Eloquent\LaraframeModel as Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\{Auth\Access\Authorizable as AuthorizableContract,
    Auth\Authenticatable as AuthenticatableContract,
    Auth\CanResetPassword as CanResetPasswordContract
};
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['assigned_role', 'username', 'password', 'email', 'is_address_verified', 'is_id_verified', 'remember_me', 'avatar', 'is_email_verified', 'is_financial_active', 'is_accessible_under_maintenance', 'is_super_admin', 'status', 'created_by'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'assigned_role');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    //auction relations

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'ownerable');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class);
    }

    public function knowYourCustomers()
    {
        return $this->hasMany(KnowYourCustomer::class);
    }

    public function identity()
    {
        return $this->hasOne(KnowYourCustomer::class)
            ->where('verification_type', VERIFICATION_TYPE_ID);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

}
