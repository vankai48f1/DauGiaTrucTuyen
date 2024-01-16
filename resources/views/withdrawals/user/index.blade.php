@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{ $dataTable['filters'] }}
                    {{ $dataTable['advanceFilters'] }}
                </div>
                <div class="my-4">
                    @component('components.table',['class'=> 'lf-data-table'])
                        @slot('thead')
                            <tr class="text-white text-center">
                                <th class="all text-left pr-2">{{ __('Ref ID') }}</th>
                                <th class="all pr-2">{{ __('Payment Method') }}</th>
                                <th class="min-phone-l pr-2">{{ __('Amount') }}</th>
                                <th class="min-phone-l pr-2">{{ __('Status') }}</th>
                                <th class="all pr-2">{{ __('Created') }}</th>
                                <th class="min-desktop-l">{{ __('Address') }}</th>
                                <th class="min-desktop-l">{{ __('Txn ID') }}</th>
                                <th class="min-desktop-l">{{ __('System Fee') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $key=>$withdrawal)
                            <tr class="text-center position-relative">
                                <td class="text-left"><span class="font-weight-bold">{{$withdrawal->ref_id}}</span></td>
                                <td><span class="badge {{config('commonconfig.payment_methods.' . ( !is_null($withdrawal) ? $withdrawal->payment_method : '' ) . '.color_class')}}"> {{ config('commonconfig.payment_methods.' . ( !is_null($withdrawal->payment_method) ? $withdrawal->payment_method : '') . '.text')}} </span></td>
                                <td class="font-weight-bold text-success">{{$withdrawal->amount}}</td>
                                <td><span class="badge badge-{{config('commonconfig.payment_status.' . ( !is_null($withdrawal) ? $withdrawal->status : '' ) . '.color_class')}}"> {{ config('commonconfig.payment_status.' . ( !is_null($withdrawal->status) ? $withdrawal->status : '') . '.text')}} </span></td>
                                <td>{{$withdrawal->created_at !== null ? $withdrawal->created_at->diffForHumans():''}}</td>
                                <td>{{$withdrawal->address}}</td>
                                <td>{{$withdrawal->payment_txn_id}}</td>
                                <td>{{$withdrawal->system_fee}}</td>
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
                                            @if(has_permission('wallets.withdrawals.show'))
                                                <a href="{{ route( 'wallets.withdrawals.show', [$withdrawal->currency_symbol, $withdrawal->id]) }}" class="dropdown-item">
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
@endsection

@section('style')
    @include('layouts.includes.list-css')
@endsection

@section('script')
    @include('layouts.includes.list-js')
@endsection
