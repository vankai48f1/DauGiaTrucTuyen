@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    @include('seller.stores.manage_store.avatar')
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        @include('seller.stores.manage_store.store_nav')

                        @component('components.card', ['type' => 'info', 'class'=> 'border-top-0'])
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive-sm">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th>{{ __('Name') }}</th>
                                                    <td>{{auth()->user()->seller->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Email') }}</th>
                                                    <td>{{ auth()->user()->seller->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Username') }}</th>
                                                    <td>{{ auth()->user()->seller->phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Account Status') }}</th>
                                                    <td>
                                                        <span class="badge badge-{{ config('commonconfig.seller_account_status.' . auth()->user()->seller->is_active . '.color_class') }}">{{ seller_account_status(auth()->user()->seller->is_active) }}</span>
                                                        @if(auth()->user()->seller->is_active == INACTIVE)
                                                            <span class="fz-12 color-999">{{__('(To active your store please verify your store address)')}}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @slot('footer')
                                <a href="{{ route('seller.store.edit', auth()->user()->seller->id) }}" class="btn fz-14 btn-secondary ">{{ __('Edit Information') }}</a>
                            @endslot
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
