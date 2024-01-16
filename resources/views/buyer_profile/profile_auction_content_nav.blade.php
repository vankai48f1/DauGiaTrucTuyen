<ul class="nav nav-tabs mt-3" id="profileTab">
    <li class="nav-item">
        <a class="nav-link text-muted {{is_current_route('buyer-attended-auction.index', 'active border-bottom-white')}}" href="{{route('buyer-attended-auction.index')}}">{{__('My All Auctions')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-muted {{is_current_route('buyer-winning-auction.index', 'active')}}" href="{{route('buyer-winning-auction.index')}}">{{__('Won Auctions')}}</a>
    </li>
</ul>
