<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuctionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
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
            'starting_date' => 'required|date|after_or_equal:today',
            'ending_date' => 'required|date|after:starting_date|before_or_equal:' . (Carbon::parse($this->get('starting_date'))->addDays(90)),
            'bid_initial_price' => 'required|integer',
            'bid_increment_dif' => 'required_if:auction_type,'. AUCTION_TYPE_HIGHEST_BIDDER .'|integer',
            'product_description' => 'required|min:3|max:5000',
            'terms_description' => 'required|min:3|max:5000',
            'shipping_description' => 'min:3|max:5000',
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
    }

    public function attributes()
    {
        return [
            'title' => __('About Auction'),
            'category_id' => __('Category'),
            'bid_initial_price' => __('Initial Price'),
            'bid_increment_dif' => __('Bid Increment Difference'),
            'images.*' => __('The uploaded files must be images and less then equal of 2MB.'),
        ];
    }

    public function messages()
    {
        return [
            'ending_date.before_or_equal' => __('The ending date can not be more than 90 days from starting date'),
        ];
    }
}
