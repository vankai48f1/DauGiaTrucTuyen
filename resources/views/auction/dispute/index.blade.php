@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    {{$dataTable['filters']}}
                    {{$dataTable['advanceFilters']}}
                    @component('components.table',['class'=> 'lf-data-table'])
                        @slot('thead')
                            <tr class="auctioneer-primary-color text-light">
                                <th class="min-phone-l">{{ __('Dispute Title') }}</th>
                                <th class="min-phone-l">{{ __('Disputed On') }}</th>
                                <th class="min-phone-l">{{ __('Dispute Status') }}</th>
                                <th class="min-phone-l">{{ __('Created') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $key=>$dispute)
                            <tr>
                                <td class="{{$dispute->read_at ? '' : 'text-success'}}">{{ $dispute->title}}</td>
                                <td> <span class="badge {{config('commonconfig.dispute_type.' . ( !is_null($dispute) ? $dispute->dispute_type : '' ) . '.color_class')}}">{{ config('commonconfig.dispute_type.' . ( !is_null($dispute) ? $dispute->dispute_type : '' ) . '.text')}}</span></td>

                                <td> <span class="badge {{config('commonconfig.dispute_status.' . ( !is_null($dispute) ? $dispute->dispute_status : '' ) . '.color_class')}}">{{ config('commonconfig.dispute_status.' . ( !is_null($dispute) ? $dispute->dispute_status : '' ) . '.text')}}</span></td>

                                <td>{{ !is_null($dispute->created_at) ? $carbon->parse($dispute->created_at)->diffForHumans() : ''}}</td>
                                <td class="lf-action text-light">
                                    <div class="btn-group">
                                        <button class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(has_permission('admin-dispute.edit'))
                                                <a class="dropdown-item" href="{{ route('admin-dispute.edit', $dispute->id)}}"><i
                                                        class="fa fa-pencil-square-o fa-lg text-info"></i> {{ __('Show') }}
                                                </a>
                                            @endif
                                            @if($dispute->read_at && has_permission('admin-dispute.mark-as-unread'))
                                                <a class="dropdown-item" href="{{ route('admin-dispute.mark-as-unread',$dispute->id) }}"><i
                                                        class="fa fa-dot-circle-o text-red"></i> {{ __('Mark as unread') }}
                                                </a>
                                            @else
                                                <a class="dropdown-item" href="{{ route('admin-dispute.mark-as-read',$dispute->id) }}"><i
                                                        class="fa fa-dot-circle-o text-green"></i> {{ __('Mark as read') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    @endcomponent
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
    <script>
        (function($){
            "use strict";

            $('.cm-filter-toggler').on('click',function(){
                $('.cm-filter-container').slideToggle();
            })
        })(jQuery)
    </script>
@endsection
