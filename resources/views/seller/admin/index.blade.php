@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                {{ $dataTable['filters'] }}
                <div class="py-4">
                    @component('components.table',['class'=> 'lf-data-table'])
                        @slot('thead')
                            <tr class="auctioneer-primary-color text-light">
                                <th class="all">{{ __('Ref ID') }}</th>
                                <th class="all">{{ __('Store Name') }}</th>
                                <th class="min-phone-l">{{ __('Email') }}</th>
                                <th class="min-phone-l">{{ __('Phone') }}</th>
                                <th class="min-phone-l">{{ __('Active Status') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $store)
                            <tr>
                                <td>{{ $store->ref_id }}</td>
                                <td>{{ $store->name }}</td>
                                <td>{{ $store->email }}</td>
                                <td>{{ $store->phone_number }}</td>
                                <td>
                                    <span class="badge badge-{{ get_color_class($store->is_active, 'seller_account_status') }}">{{ seller_account_status($store->is_active) }}</span>
                                </td>

                                <td class="lf-action">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(has_permission('admin.stores.edit'))
                                                <a class="dropdown-item" href="{{ route('admin.stores.edit', $store->id)}}"><i
                                                        class="fa fa-pencil-square"></i> {{ __('Edit') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endcomponent
                </div>
                {{ $dataTable['pagination'] }}
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
