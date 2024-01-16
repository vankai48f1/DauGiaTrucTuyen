<?php

namespace App\Models\User;

use App\Models\Core\User;
use App\Override\Eloquent\LaraframeModel as Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'auction_id',
        'content',
        'comment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function childComments()
    {
        return $this->hasMany(Comment::class, 'comment_id', 'id');
    }
}
