@extends('layouts.master',['activeSideNav' => active_side_nav()])

@section('content')
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row">
                <!-- Start: Highest Bidder Auction-->
                <div class="col-12">
                    <div class="m-y-50 position-relative">
                        <div class="fz-26 font-weight-bold color-999 global-custom-header"> <span class="text-warning">Highest Bidder </span>Auction</div>
                        <div class="d-block">
                            <div class="fz-16 text-right position-relative">
                                <span class="link-border"></span>
                                <div class="link-area">
                                    <span class="color-666">{{__('Rules')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rules-area">
                        <p class="color-666">
                            {{__('Highest bidder auction will be created by seller so the rest of auctions. Minimum bid amount will be given by auction creator. After creating auction any user who is')}} <span class="color-default font-weight-bold">{{__('registered as a buyer')}}</span> {{__('will be able to join in this auction before the given time is over. Bidding list will be displayed in the auction bidding history. Whenever buyer post an offer, no buyer will be allowed to post any lower amount. End of the auction the highest bidder')}} <span class="color-default font-weight-bold"> {{__('will be chosen as the winner')}}</span>.
                        </p>
                        <div class="winner mt-3">
                            <ul>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">Highest bidder will win the auction.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">Seller will decide the starting bid amount / minimum bid amount.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">No one will be able to bid less amount than the existing highest bid amount.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">Auction Creator will decide how many times a buyer will be able to bid</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">Only <span class="color-default font-weight-bold">“Highest bidder amount”</span> and <span class="color-default font-weight-bold">“Number of bidder”</span> will be shown in bidding history.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Start: Highest Bidder Auction-->

                <!-- Start: Blind Bidder Auction-->
                <div class="col-12">
                    <div class="m-y-50 position-relative">
                        <div class="fz-26 font-weight-bold color-999 global-custom-header"> <span class="text-success">{{__('Blind Bidder')}} </span>{{__('Auction')}}</div>
                        <div class="d-block">
                            <div class="fz-16 text-right position-relative">
                                <span class="link-border"></span>
                                <div class="link-area">
                                    <span class="color-666">{{__('Rules')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rules-area">
                        <p class="color-666">
                            {{__('Blind Bidder is similar as highest bidder but')}} <span class="color-default font-weight-bold"> {{__('only difference')}} </span> {{__('is bidding amount will not be shown in bidding history of the auction')}} <span class="color-default font-weight-bold"> {{__('Highest bidder')}} </span> {{__('will win the auction here also')}}.
                        </p>
                        <div class="winner mt-3">
                            <ul>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Highest bidder will win the auction')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Seller will decide the starting bid amount / minimum bid amount')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Auction Creator will decide how many times a buyer will be able to bid')}}</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Bidding history will stay hidden')}}.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Start: Blind Bidder Auction-->

                <!-- Start: Unique Bidder Auction-->
                <div class="col-12">
                    <div class="m-y-50 position-relative">
                        <div class="fz-26 font-weight-bold color-999 global-custom-header"> <span class="text-info">{{__('Unique Bidder')}} </span>{{__('Auction')}}</div>
                        <div class="d-block">
                            <div class="fz-16 text-right position-relative">
                                <span class="link-border"></span>
                                <div class="link-area">
                                    <span class="color-666">{{__('Rules')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rules-area">
                        <p class="color-666">
                            {{__('Unique bidding also will not show the bidding history. The winner will be selected by the specific rules of it')}}. <span class="color-default font-weight-bold">{{__('Lowest unique bidder')}}</span> {{__('will win the auction')}}.
                        </p>
                        <div class="winner mt-3">
                            <ul>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Seller will announce minimum bidding amount. No one will able to bid less')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Bidding history will stay hidden')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Lowest unique bidder will win the auction')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('For second bid amount will be adjusted with last bids')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('If bid is a set or multiple then the winner will be chosen from lowest multiple bidder the one who bid first')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('There will be no bid increment difference')}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Start: Unique Bidder Auction-->

                <!-- Start: Vickrey Bidder Auction-->
                <div class="col-12">
                    <div class="m-y-50 position-relative">
                        <div class="fz-26 font-weight-bold color-999 global-custom-header"> <span class="text-success">{{__('Vickrey')}} </span>{{__('Auction')}}</div>
                        <div class="d-block">
                            <div class="fz-16 text-right position-relative">
                                <span class="link-border"></span>
                                <div class="link-area">
                                    <span class="color-666">{{__('Rules')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rules-area">
                        <p class="color-666">
                            {{__('A Vickrey auction is a type of')}} <span class="color-default font-weight-bold">{{__('sealed-bid auction')}} </span>. {{__('Bidders submit written bids without knowing the bid of the other people in the auction. The highest bidder wins but')}} <span class="color-default font-weight-bold">{{__('the price paid is the second-highest bid')}}</span>.
                        </p>
                        <div class="winner mt-3">
                            <ul>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Highest bidder will win the auction')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Winner will pay the equal amount of the second highest bidder')}}.</span>
                                </li>
                                <li>
                                    <i class="fa fa-chevron-circle-right mr-3 color-default"></i>
                                    <span class="bg-rules">{{__('Bidding history will stay hidden')}}.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Start: Vickrey Bidder Auction-->
            </div>
        </div>
    </div>
@endsection

@section('style-top')
    <style>
        .bg-rules {
            background-color: #e8e8e8 !important;
        }
    </style>
@endsection
