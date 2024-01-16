@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                @include('seller.auction._auction_nav')

                <div class="my-4">
                    @component('components.table',['class'=> 'lf-data-table'])
                        @slot('thead')
                            <tr class="color-666">
                                <th class="all text-left">{{ __('Date') }}</th>
                                @if(auth()->check() && $auction->seller_id == optional(auth()->user()->seller)->id)
                                <th>{{ __('Bidder') }}</th>
                                @endif
                                <th class="all text-right">{{ __('Amount') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $bid)
                            <tr>
                                <td>{{ $bid->created_at->diffForHumans() }}</td>
                                @if(auth()->check() && $auction->seller_id == optional(auth()->user()->seller)->id)
                                <td>{{ $bid->user->profile->full_name }}</td>
                                @endif

                                <td class="text-right font-weight-bold">
                                    @if($bid->is_winner == ACTIVE_STATUS_ACTIVE)
                                        <span class="badge-success py-1 px-2 badge-pill fz-10 mr-2">{{ __('Winner') }}</span>
                                    @endif

                                    @if($bid->user_id == auth()->id())
                                        <span class="badge-success py-1 px-2 badge-pill fz-10 mr-2">{{ __('My Bid') }}</span>
                                    @endif
                                    <span class="color-default fz-16">{{$bid->amount}}</span>
                                    <span class="fz-12">{{ $bid->currency_symbol  }}</span>
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
