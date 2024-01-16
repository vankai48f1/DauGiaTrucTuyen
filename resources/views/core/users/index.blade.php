@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                {{ $dataTable['filters'] }}
                {{ $dataTable['advanceFilters'] }}
                <div class="my-4">
                    @component('components.table',['class'=> 'lf-data-table'])
                        @slot('thead')
                            <tr class="auctioneer-primary-color text-light">
                                <th class="all">{{ __('Email') }}</th>
                                <th class="min-phone-l">{{ __('First Name') }}</th>
                                <th class="min-phone-l">{{ __('Last Name') }}</th>
                                <th class="min-phone-l">{{ __('User Group') }}</th>
                                <th class="min-phone-l">{{ __('Username') }}</th>
                                <th class="none">{{ __('Registered Date') }}</th>
                                <th class="text-center min-phone-l">{{ __('Status') }}</th>
                                <th class="text-right all no-sort">{{ __('Action') }}</th>
                            </tr>
                        @endslot

                        @foreach($dataTable['items'] as $key=>$user)
                            <tr>
                                <td>
                                    @if(has_permission('users.show'))
                                        <a href="{{ route('admin.users.show', $user->id) }}">{{ $user->email }}</a>
                                    @else
                                        {{ $user->email }}
                                    @endif
                                </td>
                                <td>{{ $user->profile->first_name }}</td>
                                <td>{{ $user->profile->last_name }}</td>
                                <td>{{  ucwords($user->assigned_role)}}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">{{ view_html($user->status ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>') }}</td>
                                <td class="lf-action text-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                            <a class="dropdown-item" href="{{ route('admin.users.show',$user->id)}}"><i
                                                    class="fa fa-eye"></i> {{ __('Show') }}</a>
                                            <a class="dropdown-item" href="{{ route('admin.users.edit',$user->id)}}"><i
                                                    class="fa fa-pencil-square-o fa-lg text-info"></i> {{ __('Edit Info') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.users.edit.status',$user->id)}}"><i
                                                    class="fa fa-pencil-square fa-lg text-info"></i> {{ __('Edit Status') }}
                                            </a>
                                            @if(has_permission('admin.users.wallets'))
                                            <a class="dropdown-item" href="{{ route('admin.users.wallets',$user->id)}}"><i
                                                    class="fa fa-list-ol fa-lg text-info"></i> {{ __('Wallets') }}
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
