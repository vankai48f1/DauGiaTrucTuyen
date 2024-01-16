<?php

namespace App\Models\User;

use App\Models\Core\User;
use App\Override\Eloquent\LaraframeModel as Model;
use Illuminate\Support\Facades\DB;

class Bid extends Model
{
    protected $fillable = [
        'user_id',
        'auction_id',
        'currency_symbol',
        'amount',
        'is_winner',
        'system_fee'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function scopeGetHighestBids($query)
    {
        return $query
            ->select('user_id', DB::raw('max(amount) as amount'))
            ->groupBy('user_id')
            ->get();
    }

    public function scopeFindUniqueBidWinner($query)
    {
        $winnerBid =  $query->select('amount', DB::raw('count(*) as total'))
            ->groupBy('amount')
            ->orderBy('total')
            ->orderBy('amount')
            ->first();

        if($winnerBid){
            return Bid::where('auction_id',$query->getBindings()[0])->where('amount', $winnerBid->amount)->orderBy('id')->first();
        }
        return  false;
    }

}
