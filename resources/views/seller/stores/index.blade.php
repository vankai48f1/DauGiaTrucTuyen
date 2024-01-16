@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-50 pt-5">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="card custom-border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 align-self-center">
                                    <!-- Profile Image -->
                                    <img src="{{ get_seller_profile_image(auth()->user()->seller->image) }}"
                                         alt="{{ __('Profile Image') }}"
                                         class="img-rounded img-fluid">
                                </div>
                                <div class="col-xl-8 clearfix">
                                    <div class="row">
                                        <div class="col-md-6 order-2 order-md-1">
                                            <h3 class="font-weight-bold d-inline-block">{{auth()->user()->seller->name}}</h3>
                                        </div>
                                        <div class="col-md-6 col-12 order-1 mt-3 mt-md-0">
                                            <a class="btn fz-14 float-left float-lg-right btn-info" href="{{route('seller.store.edit')}}">{{__('Manage Store')}}</a>
                                        </div>
                                    </div>
                                    <div class="border-bottom d-block pb-3"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Start: personal information -->
                                                <div class="row py-3">
                                                    <div class="col">
                                                        {{auth()->user()->seller->description}}
                                                    </div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-4">
                                                        <i class="fa fa-phone mr-1 text-danger"></i>
                                                        {{__('Phone')}}
                                                    </div>
                                                    <div class="col">
                                                        : {{auth()->user()->seller->phone_number}}
                                                    </div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-4">
                                                        <i class="fa fa-envelope mr-1 text-danger"></i>
                                                        {{__('Email')}}
                                                    </div>
                                                    <div class="col">
                                                        : {{auth()->user()->seller->email}}
                                                    </div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-4">
                                                        <i class="fa fa-id-card-o mr-1 text-danger"></i>
                                                        {{__('Reference ID')}}
                                                    </div>
                                                    <div class="col">
                                                        : {{auth()->user()->seller->ref_id}}
                                                    </div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-4">
                                                        <i class="fa fa-circle-o mr-1 text-danger"></i>
                                                        {{__('Status')}}
                                                    </div>
                                                    <div class="col">
                                                        : <span class="mr-2 badge badge-{{ config('commonconfig.active_status.' . auth()->user()->seller->is_active . '.color_class' ) }}">
                                                            {{ active_status( auth()->user()->seller->is_active )}}
                                                        </span>

                                                        @if( auth()->user()->seller->is_active == ACTIVE_STATUS_INACTIVE )
                                                            <span class="small">
                                                                    {{ __('Verify address to make store active') }} <a
                                                                href="{{ route('kyc.seller.addresses.index') }}">{{ __('Verify Address') }}</a>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
        })(jQuery)
    </script>
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.css') }}">
@endsection
