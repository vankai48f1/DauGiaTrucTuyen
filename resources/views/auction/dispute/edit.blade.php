@extends('layouts.master')
@section('title', $title)

@section('content')
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="card-body border">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="address-card">
                                <div class="agent-info">
                                    <div class="personal-info mx-2 my-4">
                                        @component('components.table', ['class' => 'table-borderless table-striped table-sm mt-5'])
                                            <tr>
                                                <td class="col-6"><i class="mr-1 fa fa-user"></i> {{__('Title :')}}
                                                </td>
                                                <td class="col-6">{{$dispute->title}}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-6"><i
                                                        class="mr-1 fa fa-address-card-o"></i> {{__('Dispute Status :')}}
                                                </td>
                                                <td class="col-6">
                                                    <span
                                                        class="badge d-inline {{config('commonconfig.dispute_status.' . ( !is_null($dispute) ? $dispute->dispute_status : '' ) . '.color_class')}}">{{ config('commonconfig.dispute_status.' . ( !is_null($dispute) ? $dispute->dispute_status : '' ) . '.text')}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-6"><i
                                                        class="mr-1 fa fa-phone"></i> {{__('Reference ID :')}}
                                                </td>
                                                <td class="col-6">{{!is_null($dispute) ? $dispute->ref_id : ''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-6"><i
                                                        class="mr-1 fa fa-location-arrow"></i> {{__('Dispute Type :')}}
                                                </td>
                                                <td class="col-6">
                                                    <span
                                                        class="badge d-inline {{config('commonconfig.dispute_type.' . ( !is_null($dispute) ? $dispute->dispute_type : '' ) . '.color_class')}}">{{ config('commonconfig.dispute_type.' . ( !is_null($dispute) ? $dispute->dispute_type : '' ) . '.text')}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-6"><i
                                                        class="mr-1 fa fa-file-text"></i> {{__('Description :')}}
                                                </td>
                                                <td class="col-6">
                                                    {{$dispute->description}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-6"><i
                                                        class="mr-1 fa fa-link"></i> {{__('Link :')}}
                                                </td>
                                                <td class="col-6">
                                                    @if($dispute->dispute_type == DISPUTE_TYPE_AUCTION_ISSUE)
                                                        <a href="{{route('auction.show',$disputed_link->ref_id)}}">{{__('Click Here To View')}}</a>
                                                    @endif
                                                    @if($dispute->dispute_type == DISPUTE_TYPE_SELLER_ISSUE)
                                                        <a href="{{route('seller.store.show',$disputed_link->ref_id)}}">{{__('Click Here To View')}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if($dispute->images != null)
                            <div id="app">
                                <div v-viewer class="images clearfix">
                                    <div class="my-2">
                                        <template v-for="image in images">
                                            <img :src="image" class="image p-3" :key="image">
                                        </template>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="py-4">
                            @if(has_permission('admin-change-dispute-status.update') && $dispute->dispute_status != DISPUTE_STATUS_SOLVED)
                                <a class="btn btn-info confirmation d-inline-block" data-alert="{{__('Are you sure?')}}"
                                   data-form-id="urm-{{$dispute->id}}" data-form-method='put'
                                   href="{{ route('admin-change-dispute-status.update', $dispute->id) }}">
                                    <i class="fa fa-check-circle-o"></i> {{ $dispute->dispute_status == DISPUTE_STATUS_PENDING ? 'On Investigation' : 'Solved'}}
                                </a>
                            @endif
                            @if(has_permission('admin-dispute-decline-status.update') && $dispute->dispute_status != DISPUTE_STATUS_SOLVED)
                                <a class="btn btn-danger confirmation d-inline-block"
                                   data-alert="{{__('Are you sure?')}}"
                                   data-form-id="urm-{{$dispute->id}}" data-form-method='put'
                                   href="{{ route('admin-dispute-decline-status.update', $dispute->id) }}">
                                    <i class="fa fa-check-circle-o"></i> {{ __('Decline')}}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('public/vendor/v-viewer/viewer.css')}}">
    <link rel="stylesheet" href="{{asset('public/vendor/mcustomscrollbar/jquery.mCustomScrollbar.min.css')}}">

    <style>
        .image {
            max-height: 400px;
            cursor: pointer;
            margin: 5px;
            display: inline-block;
        }

        .agent-info .agent-title {
            font-size: 28px;
            font-weight: bold;
            color: #ff214f;
            line-height: 1;
            text-transform: uppercase;
        }

        .agent-info .designation {
            font-size: 18px;
            color: #999;
            display: block;
            margin-top: 5px;
            text-transform: capitalize;
        }

        .agent-info .personal-info {
            font-family: "Poppins", sans-serif;
        }

        .agent-info .personal-info ul li {
            margin-bottom: 10px;
            text-transform: capitalize;
            color: #333 !important;
        }

        .agent-info .personal-info ul li span {
            width: 40%;
            text-align: left !important;
            display: inline-block;
            text-transform: capitalize;
        }

        .agent-info .personal-info ul li span i {
            margin-right: 5px;
            color: #ff214f;
        }

        .agent-info .single-share ul li:first-child {
            font-size: 18px;
            margin-right: 10px;
        }

        ul {
            list-style: none;
        }

        .agent-info .personal-info ul li span {
            width: 200px;
        }

    </style>
@endsection

@section('script')
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{asset('public/vendor/v-viewer/viewer.js')}}"></script>
    <script src="{{asset('public/vendor/v-viewer/v-viewer.js')}}"></script>
    <script src="{{ asset('public/vendor/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script>
        Vue.use(VueViewer.default);

        var Main = {
            methods: {
                toggle() {

                }
            },
            data() {
                return {
                    images: [
                        '{{dispute_image($dispute->images[0])}}',
                        '{{!empty($dispute->images[1]) ? dispute_image($dispute->images[1]) : null }}'
                    ]
                }
            }
        };
        var App = Vue.extend(Main);
        new App().$mount('#app');

        (function ($) {
            "use strict";

            $(window).on("load", function () {
                $('.m-scroller').mCustomScrollbar();
            });
        })(jQuery);
    </script>
@endsection
