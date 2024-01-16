<ul class="nav nav-tabs justify-content-end mt-3" id="profileTab" role="tablist">

    <li class="nav-item">
        <a class="nav-item text-muted nav-link {{ request()->get('auction_status') ? '' : 'active' }}" href="{{route($routeName)}}" >{{__('All Auctions')}}</a>
    </li>

    @php $status = auction_status() @endphp
    @foreach($status as $key=>$val)
        <li class="nav-item">
            <a class="nav-item text-muted nav-link {{ request()->get('auction_status') == $key ? 'active' : '' }} " href="{{route($routeName,[ 'auction_status' => $key])}}">{{$val}}</a>
        </li>
    @endforeach

</ul>
