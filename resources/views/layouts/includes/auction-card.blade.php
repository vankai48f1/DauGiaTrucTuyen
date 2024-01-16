<div class="my-3  {{ isset($column)? 'col-md-' . (12 / $column) : 'col-lg-4 col-md-6' }}">
    <!-- Start: card -->
    <div class=" grid-card">
        <div class="card card-grid card-style-1">

            <!-- Start: card image area-->
            <div class="card-image-area position-relative">
                <span class="auction-badge">
                    <span
                        class="py-1 px-2 fz-14 font-weight-normal border-radius-0 badge badge-{{config('commonconfig.auction_type.' . $auction->auction_type. '.color_class')}}">{{ auction_type($auction->auction_type) }}</span>
                </span>
                <a class="fz-12 color-999 card-time d-block" href="{{route('auction.home', ['category' => $auction->category->slug])}}">{{ $auction->category->name}}</a>
                <figure>

                    <!-- Start: card image -->
                    <a href="{{route('auction.show', $auction->ref_id)}}">
                        <img class="card-img-top" src="{{auction_image(isset( $auction->images[0] ) && !empty( $auction->images[0] ) ? $auction->images[0] : '')}}" alt="preview">
                    </a>
                    <!-- End: card image -->

                </figure>
            </div>
            <!-- End: card image area-->

            <!-- Start: card body -->
            <div class="card-body">

                <!-- Start: card header -->
                <div class="d-inline-block">
                    <a class="text-truncate text-capitalize grid-title mb-0" href="{{route('auction.show', $auction->ref_id)}}">
                        {{$auction->title}}
                    </a>
                    <div class="sub-text mt-1 m-0">
                        <i class="fa fa-user-circle-o mr-1"></i>
                        <a class="color-999"
                           href="{{route('seller.store.show', $auction->seller->ref_id)}}">{{$auction->seller->name}}</a>
                    </div>
                </div>
                <!-- End: card header -->

                <!-- Start: card details -->
                <div class="short-card-wrapper mt-3">

                    <!-- Start: countdown -->
                    <div class="count-down">
                        <div class="timer">
                            <div class="lf-counter short-card d-flex justify-content-between" data-time="{{$auction->ending_date->endOfDay()->unix() - now()->unix()}}">
                                <div class="d-none"></div>
                                @if($auction->ending_date->unix() - now()->unix() >0)
                                    <div class="day timer-unit">
                                        <div class="d-flex timer-inner">
                                            <span class="number">0</span>
                                            <span class="number">0</span>
                                        </div>
                                        <div class="format">{{__('Days')}}</div>
                                    </div>
                                    <div class="hour timer-unit">
                                        <div class="d-flex timer-inner">
                                            <span class="number">0</span>
                                            <span class="number">0</span>
                                        </div>
                                        <div class="format">{{__('Hours')}}</div>
                                    </div>
                                    <div class="min timer-unit">
                                        <div class="d-flex timer-inner">
                                            <span class="number">0</span>
                                            <span class="number">0</span>
                                        </div>
                                        <div class="format">{{__('Minutes')}}</div>
                                    </div>
                                    <div class="sec timer-unit">
                                        <div class="d-flex timer-inner">
                                            <span class="number">0</span>
                                            <span class="number">0</span>
                                        </div>
                                        <div class="format">{{__('Seconds')}}</div>
                                    </div>
                                @endif
                                <div class="{{$auction->ending_date->unix() - now()->unix() >0 ? 'd-none' : ''}}"><span class="badge badge-danger py-2 fz-16 px-3">{{__('Expired')}}</span></div>
                            </div>
                        </div>
                    </div>
                    <!-- End: countdown -->

                </div>
                <!-- End: card details -->

            </div>
            <!-- End: card body -->

            <!-- Start: item details -->
            <div class="item-details d-block">

                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item bg-f5f5f5 py-3">
                        <span class="main-text card-money d-block">
                           <span
                               class="fz-14 font-weight-normal"> {{ $auction->currency_symbol }}</span> {{$auction->bid_initial_price}}
                        </span>
                        <span class="sub-text text-uppercase">{{__('Start At')}}</span>
                    </li>
                    <li class="nav-item bg-efefef py-3">
                        <span class="main-text d-block">
                            {{shipping_type($auction->shipping_type)}}
                        </span>
                        <span class="sub-text text-uppercase">{{__('Shipping')}}</span>
                    </li>
                    <li class="nav-item bg-f5f5f5 py-3">
                                <span
                                    class="main-text d-block">{{$auction->is_multiple_bid_allowed != null ? is_multiple_bid_allowed($auction->is_multiple_bid_allowed) : '' }}</span>
                        <span class="sub-text text-uppercase">{{__('Multi Bid')}}</span>
                    </li>
                </ul>

            </div>
            <!-- End: item details -->

        </div>
    </div>
    <!-- End: card -->
</div>
