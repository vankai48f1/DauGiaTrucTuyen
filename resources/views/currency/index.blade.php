@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                {{ $dataTable['filters'] }}
                <div class="py-4">
                    @component('components.table',['class'=> 'lf-data-table'])
                        @slot('thead')
                            <tr class="auctioneer-primary-color text-light">
                                <th class="all">{{ __('Logo') }}</th>
                                <th class="all">{{ __('Name') }}</th>
                                <th class="min-phone-l">{{ __('Symbol') }}</th>
                                <th class="min-phone-l">{{ __('Type') }}</th>
                                <th class="min-phone-l">{{ __('Active Status') }}</th>
                                <th class="none">{{ __('Deposit Status') }}</th>
                                <th class="none">{{ __('Min Deposit') }}</th>
                                <th class="none">{{ __('Withdrawal Status') }}</th>
                                <th class="none">{{ __('Min Withdrawal') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $key=>$currency)
                            <tr>
                                <td>
                                    <img class="img-table" src="{{ currency_logo($currency->logo) }}" alt="logo">
                                </td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td><span class="badge badge-info">{{ currency_types($currency->type) }}</span></td>
                                <td>
                                    <span class="py-1 px-2 badge badge-{{ config('commonconfig.active_status.' . $currency->is_active . '.color_class') }}">{{ active_status($currency->is_active) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="py-1 px-2 badge badge-{{ config('commonconfig.active_status.' . $currency->deposit_status . '.color_class') }}">{{ active_status($currency->deposit_status) }}
                                    </span>
                                </td>

                                <td>{{ $currency->min_withdrawal }} {{ $currency->symbol }}</td>

                                <td>
                                    <span class="py-1 px-2 badge badge-{{ config('commonconfig.active_status.' . $currency->withdrawal_status . '.color_class') }}">{{ active_status($currency->withdrawal_status) }}
                                    </span>
                                </td>

                                <td>{{ $currency->min_withdrawal }} {{ $currency->symbol }}</td>

                                <td class="lf-action">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(has_permission('admin.currencies.edit'))
                                                <a class="dropdown-item" href="{{ route('admin.currencies.edit',$currency->symbol)}}"><i
                                                        class="fa fa-pencil-square-o fa-lg text-info"></i> {{ __('Edit') }}
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
