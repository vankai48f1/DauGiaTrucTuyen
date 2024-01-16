@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container py-5">
        <!-- earning and currency boxes -->
        <div class="row">
            <!-- total earning -->
            <div class="col-lg-4 col-sm-6 my-2">
                <div class="position-relative">
                    <div class="cart-loader border" v-bind:class="{hide : hideTotalEarningLoader}">
                        <div class="lds-ellipsis m-auto">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="py-4 px-3 border text-center">
                        <p class="font-size-24 mb-0"><strong>@{{ totalEarning }} {{ $currency->symbol }}</strong></p>
                        <p class="mb-0 text-muted">{{ __('Total Earning') }}</p>
                    </div>
                </div>
            </div>
            <!-- this month earning -->
            <div class="col-lg-4 col-sm-6 my-2">
                <div class="position-relative">
                    <div class="cart-loader border" v-bind:class="{hide : hideTotalEarningLoader}">
                        <div class="lds-ellipsis m-auto">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="py-4 px-3 border text-center">
                        <p class="font-size-24 mb-0"><strong>@{{ currentMonthEarning }} {{ $currency->symbol }}</strong></p>
                        <p class="mb-0 text-muted">{{ __('This Month Earning') }}</p>
                    </div>
                </div>
            </div>

            <!-- Currency -->
            <div class="col-lg-4 col-sm-12 my-2">
                <div class="py-4 px-3 border text-left d-flex">
                    <div class="my-auto">
                        <img src="{{ currency_logo($currency->logo) }}"
                             alt="currency icon" class="img-65">
                    </div>
                    <div class="my my-auto ml-3">
                        <p class="font-size-24 mb-0"><strong>{{ $currency->symbol }}</strong></p>
                        <p class="mb-0 text-muted">{{ __('United State Dollar') }}</p>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-light"
                                data-toggle="dropdown">
                            <i class="fa  fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
{{--                            currencies--}}
                            <p class="dropdown-item-text font-size-12 mb-0">{{__('Select A Currency')}}</p>
                            @foreach($currencies as $currencyItem)
                                <a class="dropdown-item font-size-12 text-muted" href="{{ route('admin.dashboard.index', ['currency' => $currencyItem->symbol]) }}">{{ $currencyItem->symbol }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- earning table -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h4 class="mb-4">{{ __('Earning Table') }} ({{ now()->monthName . ' '. now()->year}})</h4>
                <div class="position-relative">
                    <div class="cart-loader border" v-bind:class="{hide : hideEarningTableLoader}">
                        <div class="lds-ellipsis m-auto">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <tr class="lf-bg-primary text-light">
                            <th>{{ __('Source') }}</th>
                            <th>{{ __('Earning') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Deposit Fee') }}</td>
                            <td>@{{ depositEarning }} {{ $currency->symbol }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Withdrawal Fee') }}</td>
                            <td>@{{ withdrawalEarning }} {{ $currency->symbol }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Auction Fee') }}</td>
                            <td>@{{ auctionEarning }} {{ $currency->symbol }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Bid Fee') }}</td>
                            <td>@{{ bidEarning }} {{ $currency->symbol }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Total') }} = </th>
                            <th>@{{ currentMonthEarning }} {{ $currency->symbol }}</th>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .cart-loader {
            display: flex;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000000;
            transition: 1s;
            opacity: 1;
            background: #e0e2e4;
        }
        .cart-loader.hide {
            opacity: 0;
            display: none;
        }
        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .lds-ellipsis div {
            position: absolute;
            top: 33px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #fff;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }
        .lds-ellipsis div:nth-child(1) {
            left: 8px;
            animation: lds-ellipsis1 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(2) {
            left: 8px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(3) {
            left: 32px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(4) {
            left: 56px;
            animation: lds-ellipsis3 0.6s infinite;
        }
        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }
        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(0);
            }
        }
        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(24px, 0);
            }
        }
    </style>
@endsection

@section('script')
    <script>
        "use strict";

        const app = new Vue({
            el: '#app',
            data: {
                totalEarning: 0,
                currentMonthEarning: 0,
                withdrawalEarning: 0,
                depositEarning: 0,
                auctionEarning: 0,
                bidEarning: 0,
                hideTotalEarningLoader: false,
                hideEarningTableLoader: false
            },
            mounted: function () {
                const instant = this;
                // load total and current month earning
                axios.get('{{ route('admin.dashboard.total-earning', ['currency' => $currency->symbol]) }}')
                    .then(function (response) {
                        response = response.data;
                        instant.totalEarning = response.data.totalEarning;
                        instant.currentMonthEarning = response.data.currentMonthEarning;

                        if (response.status == "{{RESPONSE_TYPE_ERROR}}"){
                            flashBox("{{RESPONSE_TYPE_ERROR}}", "{{ __('Something went wrong.') }}");
                        }
                    })
                    .catch(function (error) {
                        flashBox("{{RESPONSE_TYPE_ERROR}}", "{{ __('Something went wrong.') }}");
                    })
                    .then(function () {
                        instant.hideTotalEarningLoader = true;
                    });

                // load earning sources
                axios.get('{{ route('admin.dashboard.earning-source', ['currency' => $currency->symbol]) }}')
                    .then(function (response) {
                        response = response.data;
                        instant.withdrawalEarning = response.data.withdrawalEarning;
                        instant.depositEarning = response.data.depositEarning;
                        instant.auctionEarning = response.data.auctionEarning;
                        instant.bidEarning = response.data.bidEarning;
                    })
                    .catch(function (error) {
                        flashBox("{{RESPONSE_TYPE_ERROR}}", "{{ __('Something went wrong.') }}");
                    })
                    .then(function () {
                        instant.hideEarningTableLoader = true;
                    });
            }
        })
    </script>
@endsection
