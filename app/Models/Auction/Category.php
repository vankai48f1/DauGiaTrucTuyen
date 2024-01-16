<?php

namespace App\Models\Auction;

use App\Models\User\Auction;
use App\Override\Eloquent\LaraframeModel as Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->slug = Str::slug($model->name);
        });
        static::updating(function ($model){
            $model->slug = Str::slug($model->name);
        });
    }

    public  function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function getPopularCategory($limit)
    {
        return $this->withCount('auctions')
            ->orderBy('auctions_count', 'desc')
            ->limit($limit)
            ->get();
    }

}
