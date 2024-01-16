<?php

namespace App\Models\User;

use App\Models\Auction\Category;
use App\Models\Auction\Currency;
use App\Override\Eloquent\LaraframeModel as Model;
use Carbon\Carbon;

class Auction extends Model
{
    protected $fillable = [
        'title',
        'ref_id',
        'seller_id',
        'address_id',
        'auction_type',
        'category_id',
        'currency_symbol',
        'starting_date',
        'ending_date',
        'delivery_date',
        'bid_initial_price',
        'bid_increment_dif',
        'product_description',
        'images',
        'is_shippable',
        'shipping_type',
        'shipping_description',
        'terms_description',
        'status',
        'product_claim_status',
        'is_multiple_bid_allowed',
        'system_fee',
        'meta_keywords',
        'meta_description'
    ];

    protected $casts = [
        'starting_date' => 'datetime',
        'ending_date' => "datetime",
    ];

    public function getWinner()
    {
        return $this->hasOne(Bid::class)->where('is_winner', ACTIVE);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('comment_id', '=', null);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function winnerBid()
    {
        return $this->hasOne(Bid::class)->where('is_winner', ACTIVE);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_symbol', 'symbol');
    }

    public function setImagesAttribute($images)
    {
        $this->attributes['images'] = json_encode($images);
    }

    public function getImagesAttribute($images)
    {
        return !empty(json_decode($images ,true)) ? json_decode($images ,true) : [];
    }

    public function getRecentAuction($limit)
    {
        return $this->where(['status' => AUCTION_STATUS_RUNNING])
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();
    }

    public function getPopularAuction($limit)
    {
        return $this->withCount('bids')
            ->where(['status' => AUCTION_STATUS_RUNNING])
            ->orderBy('bids_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function highestBidderAuction($limit)
    {
        return $this->where(['auction_type' => AUCTION_TYPE_HIGHEST_BIDDER, 'status' => AUCTION_STATUS_RUNNING])
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();
    }

    public function blindBidderAuction($limit)
    {
        return $this->where(['auction_type' => AUCTION_TYPE_BLIND_BIDDER, 'status' => AUCTION_STATUS_RUNNING])
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();
    }

    public function uniqueBidderAuction($limit)
    {
        return $this->where(['auction_type' => AUCTION_TYPE_UNIQUE_BIDDER, 'status' => AUCTION_STATUS_RUNNING])
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();
    }

    public function vickeryBidderAuction($limit)
    {
        return $this->where(['auction_type' => AUCTION_TYPE_VICKREY_BIDDER, 'status' => AUCTION_STATUS_RUNNING])
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();
    }

    public function lowestPriceAuction($limit)
    {
        return $this->where(['status' => AUCTION_STATUS_RUNNING])
            ->orderBy('bid_initial_price', 'asc' )
            ->take($limit)
            ->get();
    }

    public function highestPriceAuction($limit)
    {
        return $this->where(['status' => AUCTION_STATUS_RUNNING])
            ->orderBy('bid_initial_price', 'desc' )
            ->take($limit)
            ->get();
    }

    public static function getTodayCompletion()
    {
        $currentDate = Carbon::now()->subDay();
        return self::where('status', AUCTION_STATUS_RUNNING)
            ->whereDate('ending_date', '>=', $currentDate)
            ->whereDate('ending_date', '<=', $currentDate)
            ->get();
    }

    public function getUnreleased()
    {
        $disputeTime = settings('dispute_time', true);
        $currentDate = Carbon::now()->subDays($disputeTime);
        return $this->where('status', AUCTION_STATUS_COMPLETED)
            ->where('product_claim_status', AUCTION_PRODUCT_CLAIM_STATUS_ON_SHIPPING)
            ->whereDate('ending_date', '>=', $currentDate)
            ->whereDate('ending_date', '<=', $currentDate)
            ->get();
    }

    public function setMetaKeywordsAttribute($value){
        return $this->attributes['meta_keywords'] = json_encode($value);
    }

    public function getMetaKeywordsAttribute($value){
        return json_decode($value, true);
    }
}
