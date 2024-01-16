@extends('layouts.master',['activeSideNav' => active_side_nav()])
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
                                    <th class="all">{{ __('Name') }}</th>
                                    <th class="all">{{ __('Identification Type') }}</th>
                                    <th class="all">{{ __('Status') }}</th>
                                    <th class="all">{{ __('Create At') }}</th>
                                    <th class="all text-right">{{ __('Action') }}</th>
                                </tr>
                            @endslot

                            @foreach($dataTable['items'] as $verification)
                                <tr>
                                    <td>
                                        <a target="_blank" href="{{route('admin.users.show', $verification->user_id)}}">
                                            {{ $verification->user->profile->full_name}}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{config('commonconfig.identification_type.' . $verification->identification_type . '.color_class')}}">{{identification_type_with_id($verification->identification_type) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{config('commonconfig.verification_status.' . $verification->status . '.color_class')}}">{{verification_status($verification->status) }}</span>
                                    </td>
                                    <td>{{ $verification->created_at}}</td>
                                    <td class="lf-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown">
                                                <i class="fa fa-gear"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                @if(has_permission('kyc.admin.identity-review.show'))
                                                    <a class="dropdown-item" href="{{ route('kyc.admin.identity-review.show', $verification->id)}}"><i
                                                            class="fa fa-pencil-square-o fa-lg text-info"></i> {{ __('Review') }}
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

