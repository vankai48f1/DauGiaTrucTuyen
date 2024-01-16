@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-100 p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    @include('user.profile.personal_info.avatar')
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        @include('user.profile.personal_info.profile_nav')
                        <div class="p-4 bg-white border lf-toggle-border-color">
                            <div class="col-lg-12">
                                @component('components.table', ['class' => 'table-borderless table-striped table-sm'])
                                <tr>
                                    <td class="col-6 mr-3"><i class="mr-1 fa fa-check-circle"></i> {{__('Verification Status')}}</td>
                                    <td class="col-6">
                                        <span class="badge mr-3 badge-{{config('commonconfig.verification_status.' . $identity->status . '.color_class')}}">{{verification_status($identity->status)}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-6 mr-3"><i class="mr-1 fa fa-id-card"></i> {{__('Verification Type')}}</td>
                                    <td class="col-6">
                                        <span class="color-666">{{identification_type_with_id($identity->verification_type)}}</span>
                                    </td>
                                </tr>
                                @endcomponent
                                @if( !is_null($identity) )
                                    <h3 class="mb-1 mt-4 text-center">{{__('Front Image')}} :</h3>
                                    <div class="d-flex">
                                        <img class="img-fluid mx-auto mt-3 front-img" src="{{know_your_customer_images($identity->front_image)}}">
                                    </div>
                                    @if(isset($identity->back_image))
                                            <h3 class="mb-1 mt-4 text-center">{{__('Back Image')}} :</h3>
                                        <div class="d-flex">
                                            <img class="img-fluid mx-auto mt-3 front-img" src="{{know_your_customer_images($identity->back_image)}}">
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('profile-verification-with-id.create') }}" class="btn text-center btn-info fz-14 d-inline-block border-0">{{ __('Verify Your Identity') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style-top')
    <style>
        .front-img {
            max-height: 300px
        }
    </style>
@endsection
