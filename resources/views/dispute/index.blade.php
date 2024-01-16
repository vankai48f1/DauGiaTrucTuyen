@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <!-- ::::::::::::::::::::::START PAGE HEAD ::::::::::::::::::::::::: -->
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {{$dataTable['filters']}}
                    {{ $dataTable['advanceFilters'] }}

                    <div class="my-4">
                        @component('components.table',['class'=> 'lf-data-table'])
                            @slot('thead')
                                <tr class="auctioneer-primary-color text-light">
                                    <th class="min-phone-l">{{ __('Report Title') }}</th>
                                    <th class="min-phone-l">{{ __('Reported On') }}</th>
                                    <th class="min-phone-l">{{ __('Report Status') }}</th>
                                    <th class="min-phone-l">{{ __('Created') }}</th>
                                </tr>
                            @endslot

                            @foreach($dataTable['items'] as $key=>$dispute)
                                <tr class="position-relative {{$dispute->read_at ? '' : 'bg-notification'}}">
                                    <td>{{ $dispute->title}}</td>
                                    <td> <span class="badge {{config('commonconfig.dispute_type.' . ( !is_null($dispute) ? $dispute->dispute_type : '' ) . '.color_class')}}">{{ config('commonconfig.dispute_type.' . ( !is_null($dispute) ? $dispute->dispute_type : '' ) . '.text')}}</span></td>

                                    <td> <span class="badge {{config('commonconfig.dispute_status.' . ( !is_null($dispute) ? $dispute->dispute_status : '' ) . '.color_class')}}">{{ config('commonconfig.dispute_status.' . ( !is_null($dispute) ? $dispute->dispute_status : '' ) . '.text')}}</span></td>
                                    <td>{{ !is_null($dispute->created_at) ? $carbon->parse($dispute->created_at)->diffForHumans() : ''}}</td>
                                </tr>
                            @endforeach
                        @endcomponent
                    </div>

                    {{$dataTable['pagination']}}
                </div>
            </div>
        </div>
    </div>
    <!-- ::::::::::::::::::::::::END PAGE HEAD ::::::::::::::::::::::::: -->
@endsection

@section('style')
    @include('layouts.includes.list-css')
@endsection

@section('script')
    @include('layouts.includes.list-js')
@endsection
