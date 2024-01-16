@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <?php $title_name = ucwords(preg_replace('/[-_]+/', ' ', $type)); ?>
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-sm-4 col-md-3">
                <div class="accordion app-settings-accordion" id="appSettingsAccordion">
                    <div class="bg-light p-3 border border-bottom-0">
                        <h4 class="color-666">{{ __('Application Settings') }}</h4>
                    </div>
                    <ul class="nav nav-pills flex-column lf-toggle-bg-card border lf-toggle-border-color border">
                        @foreach($settings['settingSections'] as $key=>$value)
                            @if(!empty($value['sub-settings']))
                                <li class="nav-item border-bottom lf-toggle-border-color">
                                    <a class="nav-link"
                                       href="#collapse_{{ \Illuminate\Support\Str::slug($key) }}"
                                       data-toggle="collapse">
                                        <i class="fa {{ $value['icon'] }} mr-1"
                                           aria-hidden="true"></i>
                                        {{ ucwords(preg_replace('/[-_]+/',' ',$key)) }}
                                        <i class="fa fa-caret-down fa-pull-right"></i>
                                    </a>
                                    <ul class="collapse {{ $key == $type? 'show': '' }} lf-toggle-bg-settings-submenu"
                                        id="collapse_{{ Str::slug($key) }}" data-parent="#appSettingsAccordion">
                                        @foreach($value['sub-settings'] as $itemKey => $item)
                                            <li class="nav-item {{ (array_key_last($value['sub-settings']) != $itemKey)? 'border-bottom lf-toggle-border-color': '' }}">
                                                <a class="nav-link {{ ($sub_type == $item)? 'active': '' }}"
                                                   href="{{route('application-settings.edit',['type'=>$key, 'sub_type' => $item])}}">
                                                    {{ ucwords(preg_replace('/[-_]+/', ' ', $item)) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-sm-8 col-md-9">
                @component('components.form_box')
                    @slot('title', ucwords(preg_replace('/[-_]+/', ' ', $sub_type)).' '.__('Settings'))
                    {{ Form::open(['route'=>['application-settings.update','type'=> $type, 'sub_type' => $sub_type], 'method'=>'PUT','files'=>true]) }}
                    {{ $settings['html'] }}
                    <div class="form-group row mb-0">
                        <div class="offset-md-4 col-md-8">
                            {{ Form::submit(__('Update Setting',['settingName' =>$title_name]),['class'=>'btn btn-info']) }}
                            {{ Form::button('<i class="fa fa-undo"></i>',['class'=>'btn btn-sm btn-danger', 'type' => 'reset']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet"
          href="{{ asset('public/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    <style>
        .app-settings-accordion .nav-link {
            padding: 12px 15px;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script>
        (function ($) {
            "use strict";

            $('.form-control').on('change', function () {
                let value = $(this).val();
                let index = 'data-' + $(this).closest('[data-name]').attr('data-name');
                let row = $('[' + index + ']');
                if (row.length > 0) {
                    row.each(function () {
                        console.log($(this).attr(index).includes('|' + value + '|'), value)
                        if ($(this).attr(index).includes('|' + value + '|')) {
                            $(this).removeClass('d-none');
                        } else {
                            $(this).addClass('d-none');
                        }
                    });
                }
            });
        })(jQuery);
    </script>
@endsection
