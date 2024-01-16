<?php

namespace App\Models\Core;

use App\Override\Eloquent\LaraframeModel as Model;

class UserProfile extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name', 'address', 'phone'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
