@extends('layouts.master')
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
                                <tr class="auctioneer-primary-color text-light">
                                    <th class="all">{{ __('Seller') }}</th>
                                    <th class="min-phone-l">{{ __('Title') }}</th>
                                    <th class="min-phone-l">{{ __('Type') }}</th>
                                    <th class="min-phone-l">{{ __('Winner') }}</th>
                                    <th class="min-phone-l">{{ __('Product Claim Status') }}</th>
                                    <th class="none">{{ __('Start Date') }}</th>
                                    <th class="none">{{ __('End Date') }}</th>
                                    <th class="text-right all no-sort">{{ __('Action') }}</th>
                                </tr>
                            @endslot

                            @foreach($dataTable['items'] as $auction)
                                <tr>
                                    <td>
                                        <a href="{{ route('seller.store.show', $auction->seller->ref_id) }}">{{ $auction->seller->name }}</a>
                                    </td>
                                    <td>{{ Str::limit($auction->title, 20)}}</td>
                                    <td>{{ auction_type($auction->auction_type) }}</td>
                                    <td>
                                        @if(!is_null($auction->winnerBid))
                                            <a href="{{ route('admin.users.show', $auction->winnerBid->user_id) }}">{{ $auction->winnerBid->user->username }}</a>
                                        @endif
                                    </td>
                                    <td>
                                    <span
                                        class="badge {{config('commonconfig.product_claim_status.' . $auction->product_claim_status. '.color_class')}}">{{ product_claim_status($auction->product_claim_status) }}</span>
                                    </td>
                                    <td>{{ $auction->starting_date }}</td>
                                    <td>{{ $auction->ending_date }}</td>
                                    <td class="lf-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown">
                                                <i class="fa fa-gear"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                @if(has_permission('admin.auctions.show'))
                                                    <a class="dropdown-item" href="{{ route('admin.auctions.show', $auction->id)}}"><i
                                                            class="fa fa-pencil-square-o fa-lg text-info"></i> {{ __('Show') }}
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
    </div>
@endsection

@section('style')
    @include('layouts.includes.list-css')
@endsection

@section('script')
    @include('layouts.includes.list-js')
@endsection
