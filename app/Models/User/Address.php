<?php

namespace App\Models\User;

use App\Models\Core\Country;
use App\Models\Core\State;
use App\Override\Eloquent\LaraframeModel as Model;

class Address extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'post_code',
        'city',
        'country_id',
        'state_id',
        'delivery_instruction',
        'ownerable_type',
        'ownerable_id',
        'is_verified',
        'is_default',
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function knowYourCustomer()
    {
        return $this->hasOne(KnowYourCustomer::class);
    }

    public function ownerable()
    {
        return $this->morphTo();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
