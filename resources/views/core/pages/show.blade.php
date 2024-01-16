@extends('layouts.master', ['hideBreadcrumb' => $page->settings['hide_breadcrumb'], 'cmbPage' => $page])

@section('title', $page->title)

@section('content')
    <div class="cmb-content-wrapper" data-name="Main Wrapper" id="cmb-content-wrapper">
        {{ view_html(short_code($page->body)) }}
    </div>
@endsection

@section('style')
    <link data-link="cmb-style.css" href="{{ asset('public/plugins/cm-visual-editor/cmb-style.css') }}" id="cmb-default-style" rel="stylesheet">

    <link href="{{ asset('public/plugins/cm-visual-editor/vendor/grid/grid.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/plugins/cm-visual-editor/vendor/lightbox/lightbox.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('public/plugins/cm-visual-editor/vendor/animate/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/cm-visual-editor/vendor/animate/cmb-animate.css') }}">

    <link href="{{ asset('public/plugins/cm-visual-editor/visual-editor-element-style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugins/cm-visual-editor/vendor/fonts-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset("public/uploads/css/cm-visual-builder/style-{$page->id}.css") }}" rel="stylesheet">
@endsection

@section('script')
    <script>
        (function ($) {
            "use strict";

            $('.lf-counter').each(function () {
                let availableTime = +$(this).attr('data-time');
                if (availableTime && availableTime > 0) {
                    lfTimer(availableTime, $(this));
                }
            })

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
        })(jQuery)
    </script>
    <script src="{{ asset('public/plugins/cm-visual-editor/vendor/grid/grid.js') }}"></script>
    <script src="{{ asset('public/plugins/cm-visual-editor/slider.js') }}"></script>
    <script src="{{ asset('public/plugins/cm-visual-editor/vendor/lightbox/lightbox.js') }}"></script>
    <script src="{{ asset('public/plugins/cm-visual-editor/live-page.js') }}"></script>
@endsection
