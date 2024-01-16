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
                                <th class="all">{{ __('Seller') }}</th>
                                <th class="min-phone-l">{{ __('Title') }}</th>
                                <th class="min-phone-l">{{ __('Type') }}</th>
                                <th class="none">{{ __('Product Claim Status') }}</th>
                                <th class="none">{{ __('Created') }}</th>
                                <th class="min-phone-l">{{ __('Start Date') }}</th>
                                <th class="min-phone-l">{{ __('End Date') }}</th>
                                <th class="min-phone-l">{{ __('Status') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $auction)
                            <tr>
                                <td>
                                    <a href="{{ route('seller.store.show', $auction->seller->ref_id) }}">{{ $auction->seller->name }}</a>
                                </td>
                                <td>{{ Str::limit($auction->title, 20)}}</td>
                                <td>
                                    <span
                                        class="py1 px-2 badge badge-{{config('commonconfig.auction_type.' . $auction->auction_type. '.color_class')}}">{{ auction_type($auction->auction_type) }}</span>

                                </td>
                                <td><span
                                        class="badge {{config('commonconfig.product_claim_status.' . ( !is_null($auction) ? $auction->product_claim_status : '' ) . '.color_class')}}">{{ config('commonconfig.product_claim_status.' . ( !is_null($auction) ? $auction->product_claim_status : '' ) . '.text')}}</span>
                                </td>

                                <td>{{ $auction->created_at }}</td>
                                <td>{{ $auction->starting_date }}</td>
                                <td>{{ $auction->ending_date }}</td>
                                <td>
                                    <span class="badge badge-{{config('commonconfig.auction_status.' . $auction->status . '.color_class')}}">{{auction_status($auction->status) }}</span>
                                </td>
                                <td class="lf-action">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                            @if(has_permission('auction.show'))
                                                <a class="dropdown-item" target="_blank" href="{{ route('auction.show', $auction->ref_id)}}"><i
                                                        class="fa fa-eye fa-lg text-info"></i> {{ __('Show') }}
                                                </a>
                                            @endif

                                            @if(has_permission('admin.auctions.edit'))
                                                <a class="dropdown-item" href="{{ route('admin.auctions.edit', $auction->id)}}"><i
                                                        class="fa fa-pencil-square-o fa-lg text-info"></i> {{ __('Edit') }}
                                                </a>
                                            @endif

                                            @if(
                                                has_permission('admin.auctions.show') &&
                                                $auction->status == AUCTION_STATUS_COMPLETED &&
                                                $auction->product_claim_status != AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED
                                            )
                                                <a class="dropdown-item confirmation" data-alert="{{__('Are you sure?')}}"
                                                   data-form-id="urm-{{$auction->id}}" data-form-method='put'
                                                   href="{{ route('admin-release-money.update', $auction->id)}}">
                                                    <i class="fa fa-check-circle-o"></i> {{ __('Release Money') }}
                                                </a>
                                            @endif
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endcomponent
                </div>
                {{$dataTable['pagination']}}
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
