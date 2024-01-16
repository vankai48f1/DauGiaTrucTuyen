@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-50 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    @include('buyer_profile.profile_auction_content_nav')

                    <div class="tab-content profile-content" id="profileTabContent">
                        <div class="tab-pane fade {{is_current_route(['buyer-attended-auction.index','buyer-winning-auction.index'], 'show active')}}">
                            <div class="row">

                                <div class="col-12">
                                @component('components.card', ['class' =>'border-top-0'])
                                    {{  $dataTable['filters'] }}
                                    {{ $dataTable['advanceFilters'] }}

                                    @forelse($dataTable['items'] as $auction)

                                        <!-- Start: card-->
                                            <div class="col-12">
                                                @include('layouts.includes.auction-long-card')
                                            </div>
                                            <!-- End: card-->

                                        @empty
                                            <div class="text-center py-4">
                                                {{ __('You did not won any auction yet!') }}
                                            </div>
                                        @endforelse

                                        {{ $dataTable['pagination'] }}
                                    @endcomponent
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('layouts.includes.list-js')
    <script>
        "use strict";

        new Vue({
            el: '#app'
        });
    </script>
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.css') }}">
@endsection
