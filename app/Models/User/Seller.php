<?php

namespace App\Models\User;

use App\Models\Core\User;
use App\Override\Eloquent\LaraframeModel as Model;

class Seller extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'ref_id',
        'description',
        'image',
        'phone_number',
        'email',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'ownerable');
    }

    public function defaultAddress()
    {
        return $this->morphOne(Address::class, 'ownerable')->where('is_default', ACTIVE);
    }
}
