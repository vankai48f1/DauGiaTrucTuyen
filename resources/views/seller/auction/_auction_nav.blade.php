<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link text-muted {{ is_current_route('auction.show') }}"
           href="{{ route('auction.show', $auction->ref_id) }}">{{ __('Auction Detail') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-muted {{ is_current_route('auction.comments') }}"
           href="{{ route('auction.comments', $auction->ref_id) }}">{{ __('Comments') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-muted {{ is_current_route('auction.bids') }}"
           href="{{ route('auction.bids', $auction->ref_id) }}" aria-disabled="true">{{ __('Bid History') }}</a>
    </li>

    @if(
        $auction->status == AUCTION_STATUS_COMPLETED &&
        isset($winner) &&
        $winner->user_id == auth()->id()
    )
        <li class="nav-item">
            <a class="nav-link text-muted {{ is_current_route('shipping-description.create') }}"
               href="{{ route('shipping-description.create', $auction->ref_id) }}">{{ __('Shipping Description') }}</a>
        </li>
    @endif


    @if(
        $auction->status == AUCTION_STATUS_COMPLETED &&
        !is_null($auction->address_id) &&
        $auction->seller_id == optional(auth()->user()->seller)->id
    )
        <li class="nav-item">
            <a class="nav-link text-muted {{ is_current_route('seller.shipping-description.create') }}"
               href="{{ route('seller.shipping-description.create', $auction->ref_id) }}">{{ __("Winner's Shipping Description") }}</a>
        </li>
    @endif
</ul>
