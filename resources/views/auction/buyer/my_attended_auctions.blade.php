@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-50 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    @include('buyer_profile.profile_auction_content_nav')

                    <div class="tab-content profile-content" id="profileTabContent">
                        <div
                            class="tab-pane fade {{is_current_route(['buyer-attended-auction.index','buyer-winning-auction.index'], 'show active')}}">
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
                                                {{ __('You did not attend to any auction yet!') }}
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
        (function($){
            "use strict";

            $('.lf-counter').each(function (){
                let availableTime= +$(this).attr('data-time');
                if(availableTime && availableTime>0){
                    lfTimer(availableTime, $(this));
                }
            });
            function lfTimer(availableTime,item){
                if(availableTime>0){
                    setTimeout(
                        function(){
                            availableTime = availableTime-1;
                            let days = parseInt(availableTime/86400);
                            let restTime = availableTime - days*86400;
                            let hours = parseInt(restTime/3600);
                            restTime = restTime - hours*3600;
                            let minutes = parseInt(restTime/60);
                            let seconds = restTime - minutes*60;
                            spliter(days, item.find('.day'));
                            spliter(hours, item.find('.hour'));
                            spliter(minutes, item.find('.min'));
                            spliter(seconds, item.find('.sec'));

                            lfTimer(availableTime,item)
                        }, 1000
                    );
                }
                else{
                    item.find('.timer-unit').remove();
                    item.find('.d-none').removeClass('d-none');
                }
            }
            function spliter(digits, item){
                if(digits<10){
                    digits = '0'+digits;
                }
                else{
                    digits = digits.toString()
                }
                digits = Array.from(digits);
                let htmlData = '';
                $.each(digits,function (key, val){
                    htmlData = htmlData + '<span class="number">'+val+'</span>'
                })
                item.find('.timer-inner').html(htmlData)
            }
        })(jQuery)
    </script>
@endsection

@section('style-top')
    <link rel="stylesheet" href="{{ asset('public/vendor/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.css') }}">
@endsection
