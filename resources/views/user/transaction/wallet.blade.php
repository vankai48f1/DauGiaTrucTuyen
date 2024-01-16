@extends('layouts.master',['activeSideNav' => active_side_nav()])

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    {{$dataTable['filters']}}
                </div>

                <div class="my-4">

                    @component('components.table',['class' => 'lf-data-table'])

                        @slot('thead')
                            <tr class="auctioneer-primary-color text-light">
                                <th class="all text-left">{{ __('Currency') }}</th>
                                @if( auth()->user()->assigned_role != USER_ROLE_ADMIN && auth()->user()->is_superadmin != ACTIVE )
                                    <th class="min-phone-l text-center">{{ __('On Order') }}</th>
                                @endif

                                @if(  auth()->user()->assigned_role == USER_ROLE_SELLER )
                                    <th class="min-phone-l text-center">{{ __('Pending Balance') }}</th>
                                @endif
                                <th class="min-phone-l text-center">{{ __('Balance') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $wallet)
                            <tr class="text-center position-relative">
                                <td class="text-left"><span
                                        class="font-weight-bold">{{$wallet->currency_symbol}}</span>
                                </td>
                                @if( auth()->user()->assigned_role != USER_ROLE_ADMIN && auth()->user()->is_superadmin != ACTIVE )
                                    <td>{{$wallet->on_order}}</td>
                                @endif
                                @if(  auth()->user()->assigned_role == USER_ROLE_SELLER )
                                    <th>{{ $wallet->pending_amount > 0 ? $wallet->pending_amount : number_format($wallet->pending_amount, 2, '.', '') }}</th>
                                @endif
                                <td class="font-weight-bold text-success">{{$wallet->balance}}</td>
                                <td class="lf-action">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(has_permission('wallets.deposits.create'))
                                                <a class="dropdown-item"
                                                   href="{{route('wallets.deposits.create', $wallet->currency_symbol)}}">
                                                    <i class="fa fa-credit-card mr-2"></i>
                                                    {{__('Deposit')}}
                                                </a>
                                            @endif

                                            @if(has_permission('wallets.withdrawals.create'))
                                                <a class="dropdown-item"
                                                   href="{{route('wallets.withdrawals.create', $wallet->currency_symbol)}}">
                                                    <i class="fa fa-money mr-2"></i>
                                                    {{__('Withdraw')}}
                                                </a>
                                            @endif

                                            @if(has_permission('wallets.deposits.index'))
                                                <a class="dropdown-item"
                                                   href="{{route('wallets.deposits.index', $wallet->currency_symbol)}}">
                                                    <i class="fa fa-list mr-2"></i>
                                                    {{__('Deposit History')}}
                                                </a>
                                            @endif

                                            @if(has_permission('wallets.withdrawals.index'))
                                                <a class="dropdown-item"
                                                   href="{{route('wallets.withdrawals.index', $wallet->currency_symbol)}}">
                                                    <i class="fa fa-list mr-2"></i>
                                                    {{__('Withdrawal History')}}
                                                </a>
                                            @endif

                                            @if(has_permission('admin.dashboard.index') && auth()->user()->is_super_admin == ACTIVE)
                                                <a class="dropdown-item"
                                                   href="{{route('admin.dashboard.index', $wallet->currency_symbol)}}">
                                                    <i class="fa fa-credit-card mr-2"></i>
                                                    {{__('Earning History')}}
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
        })(jQuery);
    </script>
@endsection
