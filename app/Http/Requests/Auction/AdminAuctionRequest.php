<?php

namespace App\Http\Requests\Auction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAuctionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->assigned_role === USER_ROLE_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('auctions')->ignore($this->route()->parameter('auction'))
            ],
            'auction_type' => [
                'required',
                'integer',
                Rule::in(array_keys(auction_type()))
            ],
            'currency_symbol' => [
                'required',
                Rule::exists('currencies', 'symbol')
                    ->where('is_active', ACTIVE),
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
            'ending_date' => [
                'required',
                'date',
            ],
            'bid_initial_price' => [
                'required',
                'numeric',
                'between:0.01,99999999999.99',
            ],
            'bid_increment_dif' => [
                'required',
                'integer',
                Rule::requiredIf(function () {
                    return $this->auction_type == AUCTION_TYPE_HIGHEST_BIDDER;
                }),
            ],
            'product_description' => [
                'required',
                'min:3',
                'max:5000',
            ],
            'terms_description' => [
                'required',
                'min:3',
                'max:5000',
            ],
            'images' => [
                'array',
                'max:10',
            ],
            'images.*' => [
                'image',
                'mimes:jpeg,png',
                'max:2048',
            ],
            'is_shippable' => [
                'required',
                'integer',
                Rule::in(array_keys(active_status())),
            ],
            'shipping_description' => 'min:3|max:5000',
            'shipping_type' => [
                'required',
                'integer',
                Rule::in(array_keys(shipping_type())),
            ],
            'is_multiple_bid_allowed' => [
                'required',
                'integer',
                Rule::in(array_keys(active_status())),
            ],
            'meta_description' => 'max:255',
            'meta_keywords' => 'array',
            'meta_keywords.*' => 'required',
        ];

        if ($this->route()->parameter('auction')->status != AUCTION_STATUS_DRAFT) {
            unset(
                $rules['currency_symbol'],
                $rules['starting_date'],
                $rules['bid_initial_price'],
                $rules['auction_type'],
            );
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => __('Title'),
            'category_id' => __('Category'),
            'bid_initial_price' => __('Initial Price'),
            'bid_increment_dif' => __('Bid Increment Difference'),
        ];
    }
}
