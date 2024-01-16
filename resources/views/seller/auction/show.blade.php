@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $auction->title)
@section('content')

    <!-- ::::::::::::::::::::::START PAGE HEAD ::::::::::::::::::::::::: -->
    <div class="p-b-100 p-t-80">
        <div class="container">
            <div class="row">

                <!-- Start: property title details -->
                <div class="col-12">
                    @include('seller.auction._auction_nav')

                    <div class="card mb-4 rm-border">
                        <div class="property-title card-body px-0">

                            <!-- Start: property top -->
                            <div class="property-top">

                                <div class="row">
                                    <div class="col-lg-8 col-md-12">

                                        <!-- Start: property title -->
                                        <div class="item-name font-weight-bold">{{$auction->title}}</div>
                                        <!-- End: property title -->

                                        <!-- Start: property overview -->
                                        <div class="property-overview mt-1">
                                            <ul class="nav">
                                                <li class="color-999">
                                                    <i class="fa fa-flag"></i>
                                                    {{__('By')}} <a
                                                        href="{{route('seller.store.show', $auction->seller->ref_id)}}">{{ $auction->seller->name }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End: property overview -->

                                        <!-- Start: property overview -->
                                        <div class="property-overview mt-2">
                                            <ul class="nav">
                                                <li class="color-999">
                                                    <i class="fa fa-list-alt"></i>
                                                    <a href="{{route('auction.home', ['category' => $auction->category->slug])}}">
                                                        {{ $auction->category->name }}
                                                    </a>
                                                </li>
                                                <li class="color-999">
                                                    <i class="fa fa-clock-o"></i>
                                                    {{ $auction->ending_date->diffForHumans() }}
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End: property overview -->

                                    </div>

                                    <div class="col-lg-4 col-md-12">

                                        <!-- Start: property price -->
                                        <div class="property-price align-self-center">
                                            <h4 class="m-b-10 font-weight-bold text-capitalize">{{__('Bid Start From')}}</h4>
                                            <div class="color-999">
                                                <span>{{ $auction->currency_symbol }}</span> {{$auction->bid_initial_price}}
                                            </div>
                                            <span
                                                class="badge text-white fz-12 font-weight-normal badge-pill badge-{{config('commonconfig.auction_status.' . $auction->status . '.color_class')}}">
                                                {{ auction_status($auction->status) }}
                                            </span>

                                            @if(
                                                auth()->check() &&
                                                $auction->seller_id == optional(auth()->user()->seller)->id &&
                                                $auction->status == AUCTION_STATUS_DRAFT
                                            )
                                                <a class="btn btn-info btn-sm confirmation"
                                                   data-alert="{{__('Are you sure to start this auction? After starting auction you can not modify it.')}}"
                                                   data-form-id="urm-{{$auction->id}}" data-form-method='put'
                                                   href="{{ route('auction.start', $auction->id) }}"
                                                >
                                                    <i class="fa fa-play-circle-o pr-1"></i>{{ __('Start Auction') }}
                                                </a>
                                            @endif
                                        </div>
                                        <!-- End: property price -->

                                    </div>
                                </div>

                            </div>
                            <!-- End: property top -->

                        </div>
                    </div>
                </div>
                <!-- End: property title details -->

                <!-- Start: blog grid -->
                <div class="col-md-12 col-lg-7 order-lg-0">
                    <div class="m-md-top-50">

                        <!-- Start: properties slider -->
                        <div class="owl-six position-relative">

                            <!-- Start: main image -->
                            <div id="sync1" class="owl-carousel owl-theme">
                                @include('layouts.includes.slider_image')
                            </div>
                            <!-- End: main image -->

                            <!-- Start: image nav -->
                            <div id="sync2" class="owl-carousel owl-six-2 owl-theme">
                                @include('layouts.includes.slider_image')
                            </div>
                            <!-- End: image nav -->

                            @if(has_permission('disputes.specific') && $auction->seller_id != optional(auth()->user()->seller)->id)
                                <div class="dispute-link position-absolute">
                                    <a class="flex-sm-fill text-sm-center nav-link p-0" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false" href="#">
                                        <i class="fa fa-th-list icon-round"></i>
                                    </a>
                                    <div class="address-dropdown-menu">
                                        <div class="dropdown-menu  drop-menu dropdown-menu-right">

                                            <a class="p-2 d-block"
                                               href="{{route('disputes.specific', [DISPUTE_TYPE_AUCTION_ISSUE, $auction->ref_id])}}">
                                                {{__('Report Auction')}}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <!-- End: properties slider -->
                    </div>
                </div>
                <!-- End: blog grid -->

                <!-- Start: bidding section -->
                <div class="col-md-12 col-lg-5 order-lg-0">

                    @if($auction->status != AUCTION_STATUS_COMPLETED)
                    <div class="s-box mb-3">
                        <!-- Start: header -->
                        <div class="s-box-header">
                            <span> {{__('Ends')}} </span>
                            {{__('In')}}
                        </div>
                        <!-- End: header -->
                        <!-- Start: countdown -->
                    @include('layouts.includes.count-down')
                    <!-- End: countdown -->
                    </div>
                    @endif

                    <!-- Start: bidding section -->
                    <div class="s-box">

                        <!-- Start: header -->
                        <div class="s-box-header">
                            <span> {{__('Bidding')}} </span>
                            {{__('Section')}}
                        </div>
                        <!-- End: header -->

                        <!-- Start: item list -->
                        <div class="popular-cat">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{__('Auction Type ')}} :
                                    </span>
                                    <span
                                        class="badge badge-info">{{ auction_type($auction->auction_type) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{__('Multiple Bid Allowed ')}} :
                                    </span>
                                    <span
                                        class="badge badge-pill {{config('commonconfig.is_multi_bid_allowed.' . ( !is_null($auction) ? $auction->is_multiple_bid_allowed : ACTIVE_STATUS_ACTIVE ) . '.color_class')}}">{{ config('commonconfig.is_multi_bid_allowed.' . ( !is_null($auction) ? $auction->is_multiple_bid_allowed : ACTIVE_STATUS_ACTIVE ) . '.text')}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{__('Bid Fees ')}} :
                                    </span>
                                    <span class="badge badge-info badge-pill">{{ bidFees($auction->auction_type)}}</span>
                                </li>
                            </ul>

                            @auth
                                @if( isset($myLastBid) && $myLastBid)
                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            {{__('Your Last Bid :')}}
                                        </span>
                                            <span class="badge border color-666 badge-pill"> <span
                                                    class="mr-1 font-weight-normal">{{$auction->currency_symbol}}</span>
                                                {{ $myLastBid->amount }}</span>
                                        </li>
                                    </ul>
                                @endif
                            @endauth

                            <ul class="list-group mt-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold color-666">
                                        <span id="pusher-text">
                                            {{ isset($highestBid) && $highestBid ? __('Next Minimum Bid Amount') : __('Minimum Bid Amount') }}
                                        </span>
                                    </span>

                                    <span class="badge bg-info text-white badge-pill">
                                        <span class="mr-1 font-weight-normal">
                                            {{$auction->currency->symbol}}
                                        </span>
                                        <span
                                            id="pusher-amount">
                                            {{ isset($highestBid) && $highestBid ? ($highestBid->amount + $auction->bid_increment_dif) : $auction->bid_initial_price}}
                                        </span>
                                    </span>

                                </li>
                            </ul>

                            @auth
                                @if(
                                        $currentBalance &&
                                        optional(auth()->user()->seller)->id != $auction->seller_id &&
                                        auth()->user()->assigned_role != USER_ROLE_ADMIN
                                    )
                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class=" text-success">
                                                {{__('Your Current Balance')}} :
                                            </span>
                                            <span class="badge border badge-success badge-pill">
                                                <span class="mr-1 font-weight-normal">
                                                    {{$auction->currency_symbol}}
                                                </span>

                                                    {{$currentBalance->balance}}
                                            </span>
                                        </li>
                                    </ul>
                                @endif
                            @endauth

                        </div>
                        <!-- End: item list -->

                        @auth

                                @if(
                                    $auction->status == AUCTION_STATUS_RUNNING &&
                                    $auction->seller->user_id != auth()->id() &&
                                    auth()->user()->assigned_role != USER_ROLE_ADMIN
                                )
                                    @if(settings('is_id_verified') && auth()->user()->is_id_verified == INACTIVE)
                                        <ul class="list-group mt-3">
                                            <li class="list-group-item text-center">
                                                <a href="{{ route('kyc.identity.index') }}" class="text-warning text-center">
                                                    {{__('ID Verification is required to bid')}}
                                                </a>
                                            </li>
                                        </ul>

                                    @elseif(settings('is_address_verified') && auth()->user()->is_address_verified == INACTIVE)
                                        <ul class="list-group mt-3">
                                            <li class="list-group-item text-center">
                                                <a href="{{ route('kyc.addresses.index') }}" class="text-warning text-center">
                                                    {{__('Address Verification is required to bid')}}
                                                </a>
                                            </li>
                                        </ul>
                                    @elseif($auction->is_multiple_bid_allowed != ACTIVE && $myLastBid)
                                        <ul class="list-group mt-3">
                                            <li class="list-group-item text-center">
                                                <span class="text-danger text-center">
                                                    {{__('Multiple bid is not allowed for this auction.')}}
                                                </span>
                                            </li>
                                        </ul>
                                    @else

                                    <div class="list-group mt-3">
                                        <div class="list-group-item py-4">
                                        {{ Form::open(['route'=>['bid.store', $auction->id],'class'=>'form-horizontal cvalidate']) }}
                                        @method('post')

                                        <!-- Start: auction main content -->
                                            <div class="form-group">
                                                <span class="d-flex justify-content-center">
                                                    <span class="input-number-decrement">–</span>
                                                {{ Form::text('amount', null, ['class' => 'input-number color-666', 'id' => 'amount', 'min'=>'0' ]) }}
                                                <span class="input-number-increment">+</span>
                                                </span>
                                                <span class="invalid-feedback d-block">{{ $errors->first('amount') }}</span>
                                            </div>
                                            <!-- End: auction main content -->

                                            <button value="Submit" type="submit"
                                                    class="btn lf-custom-btn w-100 float-right has-spinner"
                                                    id="two">{{__('Bid Your Amount')}}</button>

                                            {{ Form::close() }}
                                        </div>
                                    </div>

                                    @endif

                                @endif

                        @endauth
                    </div>
                    <!-- End: bidding section -->

                </div>
                <!-- End: bidding section -->
                <!-- Start: Social Media Share -->
                <div class="col-md-12">
                    @include('seller.auction._share')
                </div>
                <!-- End: Social Media Share -->

            <!-- Start: description area -->
                <div class="col-12">
                    <!-- Start: property details body -->
                    <div class="single-blog mt-4">

                        <!-- Start: property tab -->
                        <div class="custom-profile-nav">

                            <!-- Start: tab -->
                            <nav>

                                <!-- Start: tab nav -->
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="description" data-toggle="tab"
                                       href="#descrip" role="tab" aria-controls="descrip"
                                       aria-selected="true">{{__('Product Description')}}</a>
                                    @if(!is_null($auction->terms_description))
                                        <a class="nav-item nav-link" id="features" data-toggle="tab" href="#featu"
                                           role="tab" aria-controls="featu"
                                           aria-selected="false">{{__('Term Description')}}</a>
                                    @endif
                                </div>
                                <!-- Start: tab nav -->

                            </nav>
                            <!-- End: tab -->

                            <!-- Start: property tab body -->
                            <div class="tab-content" id="nav-tabContent">

                                <!-- Start: description body -->
                                <div class="tab-pane fade show active" id="descrip" role="tabpanel"
                                     aria-labelledby="description">

                                    <!-- Start: description -->
                                    <div class="mt-4">
                                        <p class="single-blog-details text-justify">
                                            {{view_html($auction->product_description)}}
                                        </p>
                                    </div>
                                    <!-- End: description -->

                                </div>
                                <!-- End: description body -->

                            @if(!is_null($auction->terms_description))
                                <!-- Start: features body -->
                                    <div class="tab-pane fade" id="featu" role="tabpanel" aria-labelledby="features">

                                        <!-- Start: features -->
                                        <div class="mt-4">
                                            <p class="single-blog-details text-justify">
                                                {{view_html($auction->terms_description)}}
                                            </p>
                                        </div>
                                        <!-- End: features -->

                                    </div>
                                    <!-- End: features body -->
                                @endif

                            </div>
                            <!-- End: property tab body -->

                        </div>
                        <!-- End: property tab -->


                    </div>
                    <!-- End: property details body -->
                </div>
                <!-- End: description area -->

            </div>
        </div>
    </div>
    <!-- ::::::::::::::::::::::::END PAGE HEAD ::::::::::::::::::::::::: -->

@endsection

@section('meta')
    @include('seller.auction._meta_tags')
@endsection

@section('script')
    <script src="{{ asset('public/vendor/owl_carousel/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('public/vendor/moment.js/moment.min.js') }}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/vendor/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>
    <script type="text/javascript">
        (function ($) {
            "use strict";

            let user = @json(auth()->user());
            $('.cvalidate').cValidate();
            //Init jquery Date Picker
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });
            $('.toggle').click(function () {
                $('#target').toggle();
            });

            var sync1 = $("#sync1");
            var sync2 = $("#sync2");
            var slidesPerPage = 4; //globaly define number of elements per page
            var syncedSecondary = true;

            sync1.owlCarousel({
                items: 1,
                autoplayTimeout: 7000,
                smartSpeed: 2000,
                nav: false,
                autoplay: true,
                dots: false,
                loop: true,
                responsiveRefreshRate: 200,
            }).on('changed.owl.carousel', syncPosition);

            sync2
                .on('initialized.owl.carousel', function () {
                    sync2.find(".owl-item").eq(0).addClass("current");
                })
                .owlCarousel({
                    items: slidesPerPage,
                    dots: false,
                    nav: false,
                    autoplayTimeout: 7000,
                    smartSpeed: 2000,
                    slideSpeed: 500,
                    slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                    responsiveRefreshRate: 100
                }).on('changed.owl.carousel', syncPosition2);

            sync2.on("click", ".owl-item", function (e) {
                e.preventDefault();
                var number = $(this).index();
                sync1.data('owl.carousel').to(number, 300, true);
            });

            function syncPosition(el) {
                //if you set loop to false, you have to restore this next line
                let owlItems = $(el.currentTarget).find('.owl-item');
                //var current = el.item.index;
                let clonedItem = 0;
                for(let i=0; i<owlItems.length;i++){
                    if(!owlItems.eq(i).hasClass('cloned')){
                        break;
                    }
                    clonedItem++;
                }
                let current = el.item.index - clonedItem;

                //if you disable loop you have to comment this block
                /*var count = el.item.count - 1;
                var current = Math.round(el.item.index - (el.item.count / 2) - .5);

                if (current < 0) {
                    current = count;
                }
                if (current > count) {
                    current = 0;
                }*/

                //end block

                sync2
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(current)
                    .addClass("current");
                var onscreen = sync2.find('.owl-item.active').length - 1;
                var start = sync2.find('.owl-item.active').first().index();
                var end = sync2.find('.owl-item.active').last().index();

                if (current > end) {
                    sync2.data('owl.carousel').to(current, 100, true);
                }
                if (current < start) {
                    sync2.data('owl.carousel').to(current - onscreen, 100, true);
                }
            }

            function syncPosition2(el) {
                if (syncedSecondary) {
                    var number = el.item.index;
                    sync1.data('owl.carousel').to(number, 100, true);
                }
            }

            let amountDiff = "{{ $auction->bid_increment_dif }}";
        }) (jQuery);

    </script>
    @if($auction->status == AUCTION_STATUS_RUNNING)
        <script>
            (function ($) {
                "use strict";

                $('.lf-counter').each(function () {
                    let availableTime = +$(this).attr('data-time');
                    if (availableTime && availableTime > 0) {
                        lfTimer(availableTime, $(this));
                    }
                })

                function lfTimer(availableTime, item) {
                    if (availableTime > 0) {
                        setTimeout(
                            function () {
                                availableTime = availableTime - 1;
                                let days = parseInt(availableTime / 86400);
                                let restTime = availableTime - days * 86400;
                                let hours = parseInt(restTime / 3600);
                                restTime = restTime - hours * 3600;
                                let minutes = parseInt(restTime / 60);
                                let seconds = restTime - minutes * 60;
                                spliter(days, item.find('.day'));
                                spliter(hours, item.find('.hour'));
                                spliter(minutes, item.find('.min'));
                                spliter(seconds, item.find('.sec'));

                                lfTimer(availableTime, item)
                            }, 1000
                        );
                    } else {
                        item.find('.timer-unit').remove();
                        item.find('.d-none').removeClass('d-none');
                    }
                }

                function spliter(digits, item) {
                    if (digits < 10) {
                        digits = '0' + digits;
                    } else {
                        digits = digits.toString()
                    }
                    digits = Array.from(digits);
                    let htmlData = '';
                    $.each(digits, function (key, val) {
                        htmlData = htmlData + '<span class="number">' + val + '</span>'
                    })
                    item.find('.timer-inner').html(htmlData)
                }
            })(jQuery)
        </script>
    @endif
@endsection

@section('style-top')
    @include('layouts.includes.list-css')
    <link rel="stylesheet" href="{{asset('public/vendor/owl_carousel/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('public/vendor/owl_carousel/css/owl.theme.default.min.css')}}">

    <style>
        .card.rm-border {
            border: 0 !important;
        }

        .agent-info .personal-info ul li span {
            width: 40%;
        }

        .dispute-link {
            right: 10px;
            top: 10px;
            z-index: 99;
            font-size: 14px;
            color: #666;
            border-radius: 40px;
            background: rgba(255, 255, 255, .8);
        }

        .dispute-link a {
            font-size: 14px;
            color: #666;
        }

        .dispute-link .drop-menu.show {
            width: 190px !important;
        }

        #target {
            display: none;
        }

        .Hide {
            display: none;
        }

        .address-dropdown {
            top: 0;
            right: 0;
        }

        .winner-parent {
            position: relative;
            overflow: hidden;
        }

        .winner-image {
            top: -10px;
            right: 40px;
            width: 60px;
            z-index: 999;
        }

        .timer {
            display: flex !important;
            justify-content: center;
        }

        .owl-six #sync2 .owl-item:first-child .item {
            margin-left: 0 !important;
        }

        .owl-six #sync2 .owl-item:last-child .item {
            margin-right: 0 !important;
        }
    </style>
@endsection

