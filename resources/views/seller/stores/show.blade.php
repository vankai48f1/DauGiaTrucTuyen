@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-50 pt-5">
        <div class="container">

            <div class="row">

                <div class="col-12">
                    <div class="card custom-border position-relative">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 align-self-center">
                                    <!-- Profile Image -->
                                    <img src="{{ get_seller_profile_image($seller->image) }}" alt="{{ __('Profile Image') }}"
                                         class="img-rounded img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <h3 class="font-weight-bold d-inline-block">{{$seller->name}}</h3>
                                    @if(!is_null($isAddressVerified))
                                        <i class="fa fa-check-circle text-success d-inline-block fz-26 ml-1"></i>
                                    @endif
                                    <div class="border-bottom pb-3">
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-10">

                                            <!-- Start: personal information -->
                                            <div class="agent-info">
                                                <div class="personal-info mt-4">
                                                    <ul>
                                                        <li class="mb-3">
                                                            {{$seller->description}}
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-phone"></i>
                                                                {{__('phone')}} :
                                                            </span>
                                                            {{$seller->phone_number}}
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-envelope"></i>
                                                                {{__('mail')}} :
                                                            </span>
                                                            {{$seller->email}}
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-envelope"></i>
                                                                {{__('Reference ID')}} :
                                                            </span>
                                                            {{$seller->ref_id}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- End: personal information -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(has_permission('disputes.specific') && $seller->id != optional(auth()->user()->seller)->id)
                            <div class="dispute-link position-absolute">
                                <a class="flex-sm-fill text-sm-center nav-link p-0" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="fa fa-th-list icon-round"></i>
                                </a>
                                <div class="address-dropdown-menu">
                                    <div class="dropdown-menu  drop-menu dropdown-menu-right">
                                        <a class="p-2 d-block"
                                           href="{{route('disputes.specific', [DISPUTE_TYPE_SELLER_ISSUE, $seller->ref_id])}}">
                                            {{__('Report Seller')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-12">

                    <div class="tab-content profile-content" id="profileTabContent">
                        <div class="tab-pane fade {{is_current_route('seller.store.show', 'show active')}}">
                            <div class="row">

                                <div class="col-12 mt-5">
                                    @component('components.card',['type' => 'info'])

                                        {{  $dataTable['filters'] }}
                                        {{  $dataTable['advanceFilters'] }}

                                        <div class="row">
                                        @forelse($dataTable['items'] as $auction)
                                            <!-- Start: card-->
                                                <div class="col-12">
                                                    @include('layouts.includes.auction-long-card')
                                                </div>
                                                <!-- End: card-->
                                            @empty
                                                <div class="col">
                                                    <p class="pt-2 text-center">{{ __("You didn't create any auction yet!") }}</p>
                                                </div>
                                            @endforelse
                                        </div>

                                        {{ $dataTable['pagination'] }}

                                    @endcomponent
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('layouts.includes.list-js')
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
        }) (jQuery);
    </script>
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.css') }}">
    <style>
        .dispute-link {
            right: 10px;
            top: 10px;
        }

        .dispute-link .drop-menu.show {
            width: 180px;
        }

        .dataTables_empty {
            text-align: center !important;
        }
    </style>
@endsection
