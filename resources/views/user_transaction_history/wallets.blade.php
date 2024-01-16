@extends('layouts.master',['activeSideNav' => active_side_nav()])

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">

                {{$dataTable['filters']}}

                <div class="my-4">

                    @component('components.table',['class' => 'lf-data-table'])

                        @slot('thead')
                            <tr class="auctioneer-primary-color text-light">
                                <th class="all text-left">{{ __('Currency') }}</th>
                                <th class="min-phone-l">{{ __('On Order') }}</th>
                                <th class="min-phone-l">{{ __('Balance') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $wallet)
                            <tr class="text-center position-relative">
                                <td class="text-left"><span
                                        class="font-weight-bold">{{$wallet->currency_symbol}}</span>
                                </td>
                                <td>{{$wallet->on_order}}</td>
                                <td class="font-weight-bold text-success">{{$wallet->balance}}</td>
                                <td class="lf-action">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(has_permission('admin.users.wallet.deposits'))
                                                <a class="dropdown-item"
                                                   href="{{route('admin.users.wallet.deposits', ['user' => $userId, 'wallet' => $wallet->id])}}">
                                                    <i class="fa fa-list mr-2"></i>
                                                    {{__('Deposit History')}}
                                                </a>
                                            @endif

                                            @if(has_permission('admin.users.wallet.withdrawals'))
                                                <a class="dropdown-item"
                                                   href="{{route('admin.users.wallet.withdrawals', ['user' => $userId, 'wallet' => $wallet->id])}}">
                                                    <i class="fa fa-list mr-2"></i>
                                                    {{__('Withdrawal History')}}
                                                </a>
                                            @endif

                                            @if(has_permission('admin.users.wallet.adjustments'))
                                                <a class="dropdown-item"
                                                   href="{{route('admin.users.wallet.adjustments', ['user' => $userId, 'wallet' => $wallet->id])}}">
                                                    <i class="fa fa-list mr-2"></i>
                                                    {{__('Adjustment History')}}
                                                </a>
                                            @endif

                                            @if(has_permission('admin.users.wallets.adjust-amount'))
                                                <a class="dropdown-item"
                                                   href="{{route('admin.users.wallets.adjust-amount.create', ['user' => $userId, 'wallet' => $wallet->id])}}">
                                                    <i class="fa fa-adjust mr-2"></i>
                                                    {{__('Adjust Amount')}}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    @endcomponent

                </div>

                {{ $dataTable['pagination'] }}
            </div>
        </div>
    </div>
@endsection

@section('style-top')
    @include('layouts.includes.list-css')
    <link rel="stylesheet" href="{{asset('public/css/table_replace.css')}}">
@endsection

@section('script')
    @include('layouts.includes.list-js')
    <script>
        (function ($) {
            "use strict";

            $('.cm-filter-toggler').on('click', function () {
                $('.cm-filter-container').slideToggle();
            })
        })(jQuery)
    </script>
@endsection
