<?php

namespace App\Models\User;

use App\Models\Core\User;
use App\Override\Eloquent\LaraframeModel as Model;

class KnowYourCustomer extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'identification_type',
        'verification_type',
        'front_image',
        'back_image',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
