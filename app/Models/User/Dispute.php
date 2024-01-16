<?php

namespace App\Models\User;

use App\Override\Eloquent\LaraframeModel as Model;
use Carbon\Carbon;

class Dispute extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'dispute_type',
        'dispute_status',
        'description',
        'images',
        'read_at',
        'ref_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setImagesAttribute($images)
    {
        $this->attributes['images'] = json_encode($images);
    }

    public function getImagesAttribute($images)
    {
        return json_decode($images ,true);
    }

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
