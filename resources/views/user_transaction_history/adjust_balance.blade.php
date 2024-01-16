@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                {{ $dataTable['filters'] }}
                {{ $dataTable['advanceFilters'] }}
                <div class="my-4">
                    @component('components.table',['class'=> 'lf-data-table'])
                        @slot('thead')
                            <tr class="auctioneer-primary-color text-light">
                                <th class="all">{{ __('Date') }}</th>
                                <th class="all text-right">{{ __('Actual Amount') }}</th>
                                <th class="all text-right">{{ __('Txn Type') }}</th>
                                <th class="min-phone-l text-right">{{ __('Ref ID') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $withdrawal)
                            <tr>
                                <td>{{ $withdrawal->created_at }}</td>
                                <td class="text-right">{{ $withdrawal->amount }} {{ $withdrawal->currency_symbol }}</td>
                                <td class="text-right"><span class="badge badge-info">{{ transaction_type($withdrawal->txn_type) }}</span></td>
                                <td class="text-right">{{ $withdrawal->ref_id }}</td>
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
