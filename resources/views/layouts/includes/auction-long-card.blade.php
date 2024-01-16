<div class="card mt-4 p-3 overflow-hidden position-relative">
    <div class="row no-gutters">

        <div class="col-xl-3 align-self-center">
            <div class="card-view overflow-hidden p-0 position-relative">
                <a class="p-0" href="{{route('auction.show', $auction->ref_id)}}">
                    <img class="img-fluid p-0"
                         src="{{auction_image( isset($auction->images[0]) && !empty($auction->images[0]) ? $auction->images[0] : '')}}"
                         alt="Card image cap">
                </a>
                <span class="py1 px-2 auction-long-card-badge badge badge-{{config('commonconfig.auction_type.' . $auction->auction_type. '.color_class')}}">{{ auction_type($auction->auction_type) }}</span>
                @if(isset($auction->is_winner))
                    <div class="winner-tag text-uppercase"></div>
                @endif
            </div>
        </div>
        <div class="col-xl-5 mt-3 mt-lg-0">
            <div class="card-body py-0">
                <a href="{{route('auction.show', $auction->ref_id)}}">
                    <h3 class="card-title mt-0 long-card-title text-truncate font-weight-bold color-333">{{$auction->title}}</h3>
                </a>
                <div class="mt-3 align-middle text-muted">
                    {{ __('Category') }} :
                    <a class="d-inline-block font-weight-bold mb-0 fz-14" href="{{route('auction.home', ['category' => $auction->category->slug])}}">{{$auction->category->name}}</a>
                </div>

                <div class="align-middle text-muted">
                    {{ __('Initial Price') }} :
                    <span
                        class="ml-2 color-default align-middle initial-price-text  fz-40 font-weight-bold"> {{$auction->bid_initial_price}} </span>
                    <span
                        class="ml-0 fz-16 align-middle font-weight-bold color-333"> {{$auction->currency_symbol}} </span>
                </div>
                @if($auction->status != AUCTION_STATUS_COMPLETED)
                    <div class="mt-2">
                        @include('layouts.includes.count-down')
                    </div>
                @endif

                @if($auction->seller_id == optional(auth()->user()->seller)->id && $auction->status == AUCTION_STATUS_COMPLETED)
                    <div class="claim-area mt-2">
                        @if(is_null($auction->address_id) && $auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_NOT_DELIVERED_YET)
                            <button class="btn btn-info fz-14 " href="javascript:;" disabled>
                                {{__("Awaiting for winner's delivery address approval")}}
                            </button>
                        @elseif($auction->address_id && $auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_NOT_DELIVERED_YET)
                            <a href="{{ route('seller.shipping-description.create', $auction->ref_id) }}" class="btn btn-info fz-14">
                                {{__('Waiting for shipping')}}
                            </a>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_DISPUTED)
                            <button class="btn btn-danger fz-14" href="javascript:;" disabled>
                                {{__('Reported by Buyer')}}
                            </button>
                            <span class="d-block color-999 fz-12 mt-1">{{__('Please wait till admin resolve the report')}}</span>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_ON_SHIPPING)
                            <button class="btn btn-primary fz-14" href="javascript:;" disabled>
                                {{__('On shipping')}}
                            </button>
                            <span class="d-block color-999 fz-12 mt-1">{{__('Please wait till winner response')}}</span>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_PENDING)
                            <button class="btn btn-warning fz-14 " href="javascript:;" disabled>
                                {{__('Awaiting for delivery confirmation by winner')}}
                            </button>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED)
                            <button class="btn btn-secondary fz-14" href="javascript:;" disabled>{{__('Claimed')}}</button>
                        @elseif($today > $carbon->parse($auction->delivery_date))
                            <a class="btn btn-success text-white fz-14 confirmation"
                               data-alert="{{__('Are you sure you want to release your money?')}}"
                               data-form-id="urm-{{$auction->id}}"
                               data-form-method='put'
                               href="{{ route('release.seller.money', $auction->id) }}">
                                {{__('Claim Money')}}
                            </a>
                        @else
                        @endif
                    </div>


                @elseif(
                    $auction->status == AUCTION_STATUS_COMPLETED  &&
                    isset($auction->is_winner) &&
                    $auction->is_winner == ACTIVE
                )
                    <div class="claim-area mt-2">
                        @if(is_null($auction->address_id) && $auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_NOT_DELIVERED_YET)
                            @if(has_permission('shipping-description.create'))
                            <a href="{{ route('shipping-description.create', $auction->ref_id) }}" class="btn btn-info fz-14 " href="javascript:;">
                                {{__("Add Shipping address")}}
                            </a>
                            @endif

                        @elseif($auction->address_id && $auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_NOT_DELIVERED_YET)
                            <button class="btn btn-info fz-14" href="javascript:;" disabled>
                                {{__('Preparing to be shipped')}}
                            </button>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_DISPUTED)
                            <button class="btn btn-danger fz-14" href="javascript:;" disabled>
                                {{__('Disputed')}}
                            </button>
                            <span class="d-block color-999 fz-12 mt-1">{{__('Please wait till admin resolve the report')}}</span>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_ON_SHIPPING)
                            <button class="btn btn-primary fz-14" href="javascript:;" disabled>
                                {{__('On shipping')}}
                            </button>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_PENDING)
                            <button class="btn btn-warning fz-14 " href="javascript:;" disabled>
                                {{__('Awaiting for your receiving confirmation')}}
                            </button>
                        @elseif($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED)
                            <button class="btn btn-secondary fz-14" href="javascript:;" disabled>{{__('Received')}}</button>
                        @else
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-12 mt-3 mt-lg-0 align-self-center">
            <div class="card timer-wrapper mb-2">
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="timer-d-wrapper">
                                <span class="timer-d text-center float-left">
                                    {{ $auction->starting_date->format('d') }}
                                </span>
                                <span class="timer-m-y">
                                    <span
                                        class="timer-m">{{ $auction->starting_date->format('M') }}</span>
                                    <span
                                        class="timer-y">{{ $auction->starting_date->format('yy') }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-7 col-12 d-flex">
                            <div
                                class="fz-13 font-weight-bold align-items-center d-flex color-666">
                                {{__('Starting Date')}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card timer-wrapper mb-2">
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="timer-d-wrapper">
                                    <span class="timer-d-ending text-center float-left">
                                        {{ $auction->ending_date->format('d') }}
                                    </span>
                                <span class="timer-m-y">
                                    <span
                                        class="timer-m">{{ $auction->ending_date->format('M') }}</span>
                                    <span
                                        class="timer-y">{{ $auction->ending_date->format('yy') }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-7 col-12 d-flex">
                            <div
                                class="fz-13 font-weight-bold align-items-center d-flex color-666">
                                {{__('Ending Date')}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card timer-wrapper mb-2">
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item color-666 fz-13 font-weight-bold px-0 d-flex justify-content-between align-items-center">
                            {{ __('Status') }} :
                            <span
                                class="py-1 px-2 badge badge-{{config('commonconfig.auction_status.' .  $auction->status . '.color_class')}}">{{ auction_status($auction->status)  }}</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

    @if(
        (
            $auction->status == AUCTION_STATUS_COMPLETED &&
            auth()->check() &&
            isset($auction->is_winner)
         )
         ||
        (
            auth()->check() &&
            $auction->seller_id == optional(auth()->user()->seller)->id &&
            $auction->status == AUCTION_STATUS_DRAFT
        )
    )
        <div class="seller-card-dropdown">
            <a class="flex-sm-fill text-sm-center nav-link p-0"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" href="#">
                <i class="fa fa-ellipsis-v px-2 pt-2 color-999"></i>
            </a>

            <div class="address-dropdown-menu">
                <div class="dropdown-menu  drop-menu dropdown-menu-right">
                    @if($auction->status == AUCTION_STATUS_DRAFT)
                        @if(has_permission('auction.start'))
                            <a class="dropdown-item confirmation"
                               data-alert="{{__('Are you sure to start this auction? After starting auction you can not modify it.')}}"
                               data-form-id="urm-{{$auction->id}}"
                               data-form-method='put'
                               href="{{ route('auction.start', $auction->id) }}">
                                <i class="fa fa-play-circle-o mr-2"></i>
                                {{__('Start')}}
                            </a>
                        @endif

                        @if(has_permission('auction.edit'))
                            <a class="dropdown-item"
                               href="{{ route('auction.edit', $auction->id) }}">
                                <i class="fa fa-edit mr-2"></i>
                                {{__('Edit')}}
                            </a>
                        @endif

                    @elseif(has_permission('shipping-description.create') && $auction->status == AUCTION_STATUS_COMPLETED && isset($auction->is_winner))
                        <a class="dropdown-item"
                           href="{{ route('shipping-description.create', $auction->ref_id) }}">
                            <i class="fa fa-edit mr-2"></i>
                            {{$auction->is_address ? __('Shipping Details') : __('Add Shipping Details')}}
                        </a>
                    @else
                        {{__('No action available')}}
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>
