@extends('layouts.master')
@section('title', $title)
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                @include('core.profile.avatar')
            </div>
            <div class="col-md-9">
                <div class="border text-muted clearfix py-3 px-3">
                    <h5 class="float-left">{{ view_html(__('Basic Details of :user', ['user' => '<strong>' . $user->profile->full_name . '</strong>'])) }}</h5>
                    <div class="float-right">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-info btn-sm back-button"><i class="fa fa-reply"></i></a>
                    </div>
                </div>
                <div class="p-0 border border-top-0">
                    <div class="table-responsive mt-3">
                        @component('components.table', ['type' => 'striped borderless'])
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <td>{{ $user->profile->full_name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('User Role') }}</th>
                                <td>{{ \Illuminate\Support\Str::title($user->assigned_role) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Email') }}</th>
                                <td>{{ $user->email }} <span
                                        class="badge badge-{{ config('commonconfig.email_status.' . $user->is_email_verified . '.color_class') }}">{{ email_status($user->is_email_verified) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Username') }}</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Address') }}</th>
                                <td>{{ $user->profile->address }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Account Status') }}</th>
                                <td>
                                <span
                                    class="badge badge-{{ config('commonconfig.account_status.' . $user->status . '.color_class') }}">{{ account_status($user->status) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Financial Status') }}</th>
                                <td>
                                <span
                                    class="badge badge-{{ config('commonconfig.financial_status.' . $user->is_financial_active . '.color_class') }}">{{ financial_status($user->is_financial_active) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Maintenance Access Status') }}</th>
                                <td>
                                <span
                                    class="badge badge-{{ config('commonconfig.maintenance_accessible_status.' . $user->is_accessible_under_maintenance . '.color_class') }}">{{ maintenance_accessible_status($user->is_accessible_under_maintenance) }}</span>
                                </td>
                            </tr>
                        @endcomponent
                    </div>
                    <div class="bg-light text-muted mb-3 clearfix py-3 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="btn btn-sm btn-info btn-sm-block">{{ __('Edit Information') }}</a>
                                <a href="{{ route('admin.users.edit.status', $user->id) }}"
                                   class="btn btn-sm btn-warning btn-sm-block">{{ __('Edit Status') }}</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('admin.users.index') }}"
                                   class="btn btn-sm btn-info btn-sm-block">{{ __('View All Users') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
