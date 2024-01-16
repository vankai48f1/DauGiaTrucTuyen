<?php

namespace App\Models\Core;

use App\Override\Eloquent\LaraframeModel as Model;
use Illuminate\Support\Str;

class Medium extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name','path','mime_type','disk','file_name','order'];
}
