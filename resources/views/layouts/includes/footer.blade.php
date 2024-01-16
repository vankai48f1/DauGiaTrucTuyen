<!-- ======= Start: footer section ======== -->
<footer>
    <div class="footer">
        <div class="py-4">
            <div class="container">

                <!-- Start: footer middle section -->
                <div class="footer-border">
                    <div class="p-b-50">
                        <div class="row">

                            <!-- Start: property cities -->
                            <div class="col-md-3 col-sm-12 p-t-50">
                                <h4 class="font-size-18 text-uppercase font-weight-normal mb-4">{{__('Popular Categories')}}</h4>

                                <!-- Start: property cities list -->
                                <div class="prop-city">
                                    <ul class="list">
                                        @foreach(get_popular_category(8) as $category )
                                            <li>
                                                <a class="text-uppercase" href="{{route('auction.home', ['category' => $category->slug])}}">{{$category->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- End: property cities list -->

                            </div>
                            <!-- End: property cities -->

                            <!-- Start: popular posts -->
                            <div class="col-md-3 col-sm-12 p-t-50">
                                <h4 class="font-size-18 text-uppercase font-weight-normal mb-4">{{__('Popular Auction')}}</h4>

                                <!-- Start: popular posts list -->
                                @foreach(get_popular_auction(2) as $auction)
                                    <div class="media">
                                        <img class="mr-3 lf-w-50px" src="{{auction_image(isset($auction->images[0]) && !empty($auction->images[0]) ? $auction->images[0] : '' )}}" alt="image">
                                        <div class="media-body">
                                            <h5><a href="{{route('auction.show', $auction->ref_id)}}">{{ Str::limit($auction->title, 15)}}</a></h5>
                                            <p class="color-999">{{!is_null($auction->created_at) ? $auction->created_at->diffForHumans()  : ''}}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- End: popular posts list -->

                            </div>
                            <!-- End: popular posts -->

                            <!-- Start: get in touch -->
                            <div class="col-md-3 col-sm-12 p-t-50">
                                <h4 class="font-size-18 text-uppercase font-weight-normal mb-4">{{ __('get in touch') }}</h4>

                                <div class="get-in-touch">
                                    <ul>
                                        @if(!empty(settings('business_address')))
                                        <li class="d-block">
                                            <i class="fa fa-map-marker mr-3"></i>
                                            {{settings('business_address')}}
                                        </li>
                                        @endif
                                        @if(!empty(settings('business_contact_number')))
                                        <li class="d-block">
                                            <i class="fa fa-phone"></i>
                                            {{settings('business_contact_number')}}
                                        </li>
                                        @endif
                                        @if(!empty(settings('admin_receive_email')))
                                        <li class="d-block">
                                            <i class="fa fa-envelope"></i>
                                            <a href="#">
                                                {{settings('admin_receive_email')}}
                                            </a>
                                        </li>
                                         @endif
                                    </ul>
                                </div>
                            </div>
                            <!-- End: get in touch -->

                            <!-- Start: get in touch -->
                            <div class="col-md-3 col-sm-12 p-t-50">
                                <h4 class="font-size-18 text-uppercase font-weight-normal mb-4">{{ __('Discover Links') }}</h4>

                                <div class="get-in-touch">
                                    <ul>
                                        <li class="d-block">
                                            <i class="fa fa-link"></i>
                                            <a href="/auction-rules">
                                                {{__('Auction Rules')}}
                                            </a>
                                        </li>

                                        <li class="d-block">
                                            <i class="fa fa-link"></i>
                                            <a href="/deposit-policy">
                                                {{__('Deposit Policy')}}
                                            </a>
                                        </li>

                                        <li class="d-block">
                                            <i class="fa fa-link"></i>
                                            <a href="/withdrawal-policy-page">
                                                {{__('Withdrawal Policy')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End: get in touch -->
                        </div>
                    </div>
                </div>
                <!-- End: footer middle section -->

                <!-- Start: footer bottom section -->
                <div class="footer-bottom">
                    <div class="row">

                        <!-- Start: copy right area -->
                        <div class="col-md-12">
                            <p>&copy; Copyright {{settings('copy_rights_year')}} All rights reserved By {{settings('rights_reserved')}}</p>
                        </div>
                        <!-- End: copy right area -->
                    </div>
                </div>
                <!-- End: footer bottom section -->
            </div>
        </div>
    </div>
</footer>
<!-- ======== End: footer section ========= -->
