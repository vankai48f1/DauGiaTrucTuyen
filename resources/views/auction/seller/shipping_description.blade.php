@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)

@section('content')
    <!-- Start: Winner info -->
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    @include('seller.auction._auction_nav')

                    <div class="card mt-5">
                        <div class="card-body">
                            <h5 class="color-666 mb-3">{{__('Winner Address :')}}</h5>

                            <!-- Start: address card -->
                            <div class="card">
                                <div class="card-body address-card winner-parent">

                                    <div class="agent-info">
                                        <div class="personal-info mx-2 my-4">
                                            <ul>
                                                <li>
                                                            <span>
                                                                <i class="fa fa-user justify-content-center"></i>
                                                                {{__('Name')}} :
                                                            </span>
                                                    {{ $auction->address->name }}
                                                </li>
                                                <li>
                                                            <span>
                                                                <i class="fa fa-map-marker"></i>
                                                                {{__('Location')}} :
                                                            </span>
                                                    {{$auction->address->city}}
                                                    {{$auction->address->country->name}}
                                                </li>
                                                <li>
                                                            <span>
                                                                <i class="fa fa-phone"></i>
                                                                {{__('Phone')}} :
                                                            </span>
                                                    {{$auction->address->phone_number}}
                                                </li>
                                                <li>
                                                            <span>
                                                                <i class="fa fa-envelope"></i>
                                                                {{__('Post Code')}} :
                                                            </span>
                                                    {{$auction->address->post_code}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="winner-image position-absolute">
                                        <img class="img-fluid" src="{{asset('public/images/winner-badge.png')}}"
                                             alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- End: address card -->

                            <!-- Start: shipping instruction -->
                            <div class="m-4">
                                <h5 class="color-666 border-bottom pb-3">{{__('Shipping Instruction :')}}</h5>
                                <p class="mt-3">{{$auction->shipping_description}}</p>
                            </div>
                            <!-- End: shipping instruction -->

                            <div class="m-4">
                                <h5 class="color-666 mb-3">{{__('Shipping Status :')}}</h5>
                                <span
                                    class="badge badge-pill {{config('commonconfig.product_claim_status.' . ( !is_null($auction) ? $auction->product_claim_status : '' ) . '.color_class')}}">{{ product_claim_status($auction->product_claim_status)  }}</span>

                                @if($auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_NOT_DELIVERED_YET)
                                    <h5 class="color-666 mt-4">{{__('Please Submit Delivery Date :')}}</h5>
                                    <span
                                        class="color-999 d-block fz-12">{{__('Expected date of Product receiving')}}</span>
                                    {{ Form::open(['route'=>['seller.shipping-description.store', $auction->ref_id],'class'=>'form-horizontal cvalidate']) }}
                                    @method('put')

                                <!-- Start: delivery date -->
                                    <div class="form-row mt-3">
                                        <div class="col-md-4">
                                            {{ Form::label('delivery_date', 'Estimated Delivery Date') }}
                                            {{ Form::text('delivery_date', null, ['class'=> 'form-control datepicker', 'id' => 'delivery_date', 'placeholder' => __('Delivery Date')]) }}
                                            <span
                                                class="invalid-feedback">{{ $errors->first('delivery_date') }}</span>
                                        </div>
                                    </div>
                                    <!-- End: delivery date -->

                                    <button type="submit"
                                            class="btn btn-info mt-3">{{__('Submit Date')}}</button>

                                    {{ Form::close() }}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Winner info -->
@endsection

@section('script')
    <script src="{{ asset('public/vendor/moment.js/moment.min.js') }}"></script>
    <script src="{{ asset('public/vendor/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>
    <script type="text/javascript">
        (function ($) {
            "use strict";

            $('.cvalidate').cValidate();
            //Init jquery Date Picker
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: new Date(),
                useCurrent: false,
            });
        })(jQuery);
    </script>

@endsection

@section('style-top')
    @include('layouts.includes.list-css')

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
