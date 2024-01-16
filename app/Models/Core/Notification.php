<?php

namespace App\Models\Core;

use App\Override\Eloquent\LaraframeModel as Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = ['user_id', 'message', 'link', 'read_at'];

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead()
    {
        return $this->update(['read_at' => Carbon::now()]);
    }

    public function markAsUnread()
    {
        return $this->update(['read_at' => null]);
    }
}
