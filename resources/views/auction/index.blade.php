@extends('layouts.master', ['activeSideNav' => active_side_nav()])

@section('content')
    <div class="p-b-100 p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{$dataTable['filters']}}
                        {{$dataTable['advanceFilters']}}
                    </div>

                    <div class="row">
                        @foreach($dataTable['items'] as $auction)
                            @include('layouts.includes.auction-card')
                        @endforeach
                    </div>
                    {{$dataTable['pagination']}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style-top')
    @include('layouts.includes.list-css')
    <style>
        .custom-card {
            border: 0;
            background: #f0f0f0;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #fff !important;
            background-color: #ff214f !important;
            border-color: #ff214f !important;
        }

        .pagination .page-link {
            padding: 8px 20px !important;
            color: #10cea1 !important;
            border: 1px solid #10cea1 !important;
        }

        .custom-card .card-body {
            display: none !important;
            border: 0;
            background: #f0f0f0;
        }

        .custom-card .card-header {
            border: 1px solid #e3e3e3;
            background: #fff !important;
        }

        .custom-card .card-footer {
            border: 0;
            padding: 0;
            margin-top: 25px;
            background: #f0f0f0;
        }

        .cm-filter-wrapper h6 {
            margin-bottom: 10px;
        }

        .cm-filter-container .btn-info {
            background: #ff214f;
            border-color: #ff214f;
        }

        .cm-filter-wrapper label {
            color: #666;
        }
    </style>
@endsection

@section('script')
    @include('layouts.includes.list-js')
    <script>
        new Vue({
            el: '#app'
        });

        (function ($) {
            "use strict";

            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            $('.cm-filter-toggler').on('click', function () {
                $('.cm-filter-container').slideToggle();
            });

            $('.lf-counter').each(function () {
                let availableTime = +$(this).attr('data-time');
                if (availableTime && availableTime > 0) {
                    lfTimer(availableTime, $(this));
                }
            });

            function lfTimer(availableTime, item) {
                if (availableTime > 0) {
                    setTimeout(
                        function () {
                            availableTime = availableTime - 1;
                            let days = parseInt(availableTime / 86400);
                            let restTime = availableTime - days * 86400;
                            let hours = parseInt(restTime / 3600);
                            restTime = restTime - hours * 3600;
                            let minutes = parseInt(restTime / 60);
                            let seconds = restTime - minutes * 60;
                            spliter(days, item.find('.day'));
                            spliter(hours, item.find('.hour'));
                            spliter(minutes, item.find('.min'));
                            spliter(seconds, item.find('.sec'));

                            lfTimer(availableTime, item)
                        }, 1000
                    );
                } else {
                    item.find('.timer-unit').remove();
                    item.find('.d-none').removeClass('d-none');
                }
            }

            function spliter(digits, item) {
                if (digits < 10) {
                    digits = '0' + digits;
                } else {
                    digits = digits.toString()
                }
                digits = Array.from(digits);
                let htmlData = '';
                $.each(digits, function (key, val) {
                    htmlData = htmlData + '<span class="number">' + val + '</span>'
                })
                item.find('.timer-inner').html(htmlData)
            }
        })(jQuery);
    </script>
@endsection
