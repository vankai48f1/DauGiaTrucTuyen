<!-- Start: comment form -->
@component('components.card',['type' => 'info', 'class' => 'card text-right mt-4'])

    @component('components.table',['class' => 'lf-data-table', 'id' => 'bid'])

        @slot('thead')
            <tr class="color-666">
                <th class="all text-left">{{ __('Date') }}</th>
                @if( !is_null(auth()->user()->seller) ? $auction->seller_id == auth()->user()->seller->id : false )
                    <th>{{ __('Bidder') }}</th>
                @endif
                <th class="all">{{ __('Amount') }}</th>
            </tr>
        @endslot

        @foreach($auction->bids as $bid)
            <tr>
                <td class="text-left">{{$bid->created_at }}</td>
                @if(!is_null(auth()->user()->seller) ? $auction->seller_id == auth()->user()->seller->id : false)
                    <td>{{$bid->user->username}}</td>
                @endif
                <td class="text-right font-weight-bold">
                    @if($bid->is_winner == ACTIVE_STATUS_ACTIVE)
                        <span class="badge-success py-1 px-2 badge-pill fz-10 mr-2">{{ __('Winner') }}</span>
                    @endif

                    @if($bid->user_id == auth()->id())
                        <span class="badge-success py-1 px-2 badge-pill fz-10 mr-2">{{ __('My Bid') }}</span>
                    @endif
                    <span class="color-default fz-16">{{$bid->amount}}</span>
                    <span class="fz-12">{{!is_null($auction->currency) ? $auction->currency->symbol : ''}}</span>
                </td>
            </tr>
        @endforeach

    @endcomponent
@endcomponent

