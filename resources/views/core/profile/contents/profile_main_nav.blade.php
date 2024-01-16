<div class="custom-profile-nav">
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link px-5 py-2 {{is_current_route(['user-profile.index','user-profile-won-auction.index'], 'active')}}" href="{{route('user-profile.index')}}">{{__('Profile')}}</a>
        </li>

        @if(auth()->user()->seller && auth()->user()->id == auth()->user()->seller->user_id)
            <li class="nav-item">
                <a class="nav-link px-5 py-2 {{is_current_route(['seller.store.index', 'seller.store.edit'], 'active')}}" href="{{route('seller.store.index')}}">{{__('Store')}}</a>
            </li>

            @else
            <li class="nav-item">
                <a class="nav-link px-5 py-2 {{is_current_route('seller.store.create', 'active')}}" href="{{route('seller.store.create')}}">{{__('Become a Seller')}}</a>
            </li>
        @endif

    </ul>
</div>
