@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    {{ $dataTable['filters'] }}
                    {{ $dataTable['advanceFilters'] }}
                    <div class="my-4">
                        @component('components.table',['class'=> 'lf-data-table'])
                            @slot('thead')
                                <tr class="text-white text-center">
                                    <th class="all text-left pr-2">{{ __('Ref ID') }}</th>
                                    <th class="all text-left pr-2">{{ __('Symbol') }}</th>
                                    <th class="min-phone-l pr-2">{{ __('Payment Method') }}</th>
                                    <th class="min-phone-l pr-2">{{ __('Amount') }}</th>
                                    <th class="min-phone-l pr-2">{{ __('Status') }}</th>
                                    <th class="min-phone-l pr-2">{{ __('Created') }}</th>
                                    <th class="min-desktop-l">{{ __('Address') }}</th>
                                    <th class="min-desktop-l">{{ __('Txn ID') }}</th>
                                    <th class="min-desktop-l">{{ __('System Fee') }}</th>
                                    <th class="text-right all no-sort">{{ __('Action') }}</th>
                                </tr>
                            @endslot

                            @foreach($dataTable['items'] as $deposit)
                                <tr class="text-center position-relative">
                                    <td class="text-left"><span class="font-weight-bold">{{$deposit->ref_id}}</span></td>
                                    <td class="text-left">{{$deposit->currency_symbol}}</td>
                                    <td><span class="badge badge-{{config('commonconfig.payment_methods.' . ( !is_null($deposit) ? $deposit->payment_method : '' ) . '.color_class')}}"> {{ config('commonconfig.payment_methods.' . ( !is_null($deposit->payment_method) ? $deposit->payment_method : '') . '.text')}} </span></td>
                                    <td class="font-weight-bold text-success">{{$deposit->amount}} {{$deposit->currency_symbol}}</td>
                                    <td><span class="badge badge-{{config('commonconfig.payment_status.' . ( !is_null($deposit) ? $deposit->status : '' ) . '.color_class')}}"> {{ config('commonconfig.payment_status.' . ( !is_null($deposit->status) ? $deposit->status : '') . '.text')}} </span></td>
                                    <td>{{$deposit->created_at !== null ? $deposit->created_at->diffForHumans():''}}</td>
                                    <td>{{$deposit->address}}</td>
                                    <td>{{$deposit->payment_txn_id}}</td>
                                    <td>{{$deposit->system_fee}}</td>
                                    <td class="lf-action text-right">
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-sm btn-info dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-expanded="false"
                                            >
                                                <i class="fa fa-gear"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 role="menu">
                                                @if(has_permission('wallets.deposits.show'))
                                                    <a href="{{ route( 'wallets.deposits.show', [$deposit->currency_symbol, $deposit->id]) }}" class="dropdown-item">
                                                        <i class="fa fa-pencil"></i> {{ __('Show Detail') }}
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
    </div>
@endsection

@section('style')
    @include('layouts.includes.list-css')
@endsection

@section('script')
    @include('layouts.includes.list-js')
@endsection
