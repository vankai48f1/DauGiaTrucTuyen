@extends('layouts.master')
@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12 mb-4">
                @component('components.card',['type' => 'info'])
                    @slot('header')
                        <div class="row justify-content-between">
                            <div class="col align-items-center d-flex">
                                <h3 class="card-title">{{ $title }}</h3>
                            </div>
                            <div class="col">
                                <div class="card-tools">
                                    <a href="{{ route('kyc.admin.identity-review.index') }}" class="btn btn-sm btn-info float-right back-button">
                                        <i class="fa fa-reply"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endslot
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @if(!is_null($verification))
                                @component('components.table', ['class' => 'table-borderless table-striped table-sm mt-3'])
                                    <tr>
                                        <td class="col-6"><i class="mr-1 fa fa-user"></i> {{__('Name')}}
                                        </td>
                                        <td class="col-6">{{ $verification->user->profile->full_name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-6"><i class="mr-1 fa fa-check-circle"></i> {{__('Identification Type')}}</td>
                                        <td class="col-6">
                                            <span class="badge badge-{{config('commonconfig.identification_type.' . $verification->identification_type . '.color_class')}}">{{identification_type_with_id($verification->identification_type) }}</span>
                                        </td>
                                    </tr>
                                @endcomponent
                            @endif
                        </div>
                        <div class="col-md-10">
                            <div id="app">
                                <div v-viewer class="images d-flex clearfix">
                                    <div class="mx-auto">
                                        <template v-for="image in images">
                                            <img :src="image" class="image img-fluid p-3" :key="image">
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class=" py-4 text-center">

                                @if(has_permission('kyc.admin.identity-review.approve') && $verification->status !== VERIFICATION_STATUS_APPROVED)
                                    <a class="btn btn-info confirmation d-inline-block" data-alert="{{__('Are you sure?')}}"
                                       data-form-id="urm-{{$verification->id}}" data-form-method='put'
                                       href="{{ route('kyc.admin.identity-review.approve', ['id' => $verification->id]) }}">
                                        <i class="fa fa-check-circle-o"></i> {{ __('Approve') }}
                                    </a>
                                @endif

                                @if(has_permission('admin.users.show'))
                                    <a class="btn btn-light d-inline-block ml-2" target="_blank" href="{{route('admin.users.show', $verification->user_id)}}">
                                        <i class="fa fa-user-circle-o mr-2"></i>
                                        {{__('View User Profile')}}
                                    </a>
                                @endif

                                @if(has_permission('kyc.admin.identity-review.destroy'))
                                    <a class="btn btn-danger confirmation d-inline-block ml-2" data-alert="{{__('Are you sure?')}}"
                                       data-form-id="urm-{{$verification->id}}" data-form-method='delete'
                                       href="{{ route('kyc.admin.identity-review.destroy', $verification->id) }}">
                                        <i class="fa fa-trash-o"></i> {{ __('Decline') }}
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                @endcomponent
            </div>
        </div>
    </div>

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('public/vendor/v-viewer/viewer.css')}}" >
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

    </style>
@endsection

@section('script')
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{asset('public/vendor/v-viewer/viewer.js')}}"></script>
    <script src="{{asset('public/vendor/v-viewer/v-viewer.js')}}"></script>
    <script src="{{ asset('public/vendor/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script>
        Vue.use(VueViewer.default)
        console.log(VueViewer.default)
        var Main = {
            methods: {
                toggle() {

                }
            },
            data() {
                return {
                    images: [
                        '{{know_your_customer_images($verification->front_image)}}',
                        '{{!is_null($verification->back_image) ? know_your_customer_images($verification->back_image) : null }}'
                    ]
                }
            }
        }
        var App = Vue.extend(Main)
        new App().$mount('#app');

        (function($) {
            "use strict";

            $(window).on("load",function(){
                $('.m-scroller').mCustomScrollbar();
            });
        }) (jQuery);
    </script>
@endsection
