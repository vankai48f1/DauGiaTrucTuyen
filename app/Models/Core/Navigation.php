<?php

namespace App\Models\Core;

use App\Override\Eloquent\LaraframeModel as Model;

class Navigation extends Model
{
    protected $fillable = ['slug', 'items'];

    public function getItemsAttribute($value): array
    {
        return json_decode($value, true);
    }

    public function setItemsAttribute($value): void
    {
        $this->attributes['items'] = json_encode($value);
    }
}
