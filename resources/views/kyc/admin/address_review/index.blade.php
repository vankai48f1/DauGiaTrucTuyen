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
                                    <th class="all">{{ __('Address') }}</th>
                                    <th class="min-phone-l">{{ __('Phone Number') }}</th>
                                    <th class="all">{{ __('Status') }}</th>
                                    <th class="min-phone-l">{{ __('Post Code') }}</th>
                                    <th class="min-phone-l">{{ __('City') }}</th>
                                    <th class="min-phone-l">{{ __('Created At') }}</th>
                                    <th class="all">{{ __('Action') }}</th>
                                </tr>
                            @endslot

                            @foreach($dataTable['items'] as $verification)
                                <tr>
                                    <td>{{ $verification->address->name}}</td>
                                    <td>{{ $verification->address->address }}</td>
                                    <td>{{ $verification->address->phone_number }}</td>
                                    <td>
                                        <span class="badge badge-{{config('commonconfig.verification_status.' . $verification->status . '.color_class')}}">{{verification_status($verification->status) }}</span>
                                    </td>
                                    <td>{{ $verification->address->post_code }}</td>
                                    <td>{{ $verification->address->city }}</td>
                                    <td>{{ $verification->address->created_at }}</td>
                                    <td class="lf-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown">
                                                <i class="fa fa-gear"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                @if(has_permission('kyc.admin.address-review.show'))
                                                    <a class="dropdown-item" href="{{ route('kyc.admin.address-review.show', $verification->id)}}"><i
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

