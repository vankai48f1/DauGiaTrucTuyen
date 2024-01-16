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
                        <div class="p-4 bg-white border lf-toggle-border-color">
                            @forelse($addresses as $address)
                                <div class="address-card border lf-toggle-border-color bg-grey-light p-3 mb-3">
                                    <div class="address-dropdown">
                                        <a class="flex-sm-fill text-sm-center nav-link p-0" data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false" href="#">
                                            <i class="fa fa-th-list icon-round"></i>
                                        </a>
                                        <div class="address-dropdown-menu">
                                            <div class="dropdown-menu  drop-menu dropdown-menu-right">
                                                @if($address->is_verified == VERIFICATION_STATUS_UNVERIFIED )
                                                    @if(has_permission('kyc.seller.addresses.edit'))
                                                        <a class="dropdown-item"
                                                           href="{{route('kyc.seller.addresses.edit', $address->id)}}">
                                                            <i class="fa fa-edit mr-2"></i>
                                                            {{__('Edit')}}
                                                        </a>
                                                    @endif

                                                    @if(has_permission('kyc.seller.addresses.destroy') && $address->is_default == INACTIVE)
                                                        <a class="dropdown-item confirmation"
                                                           data-alert="{{__('Are you sure to delete this address?')}}"
                                                           data-form-id="urm-{{$address->id}}" data-form-method='delete'
                                                           href="{{ route('kyc.seller.addresses.destroy', $address->id) }}">
                                                            <i class="fa fa-trash-o mr-2"></i>
                                                            {{__('Delete')}}
                                                        </a>
                                                    @endif

                                                    @if(has_permission('kyc.seller.addresses.toggle-default-status') && $address->is_default == INACTIVE)
                                                        <a class="dropdown-item confirmation"
                                                           data-alert="{{__('Are you sure to change the default status?')}}"
                                                           data-form-id="urm-{{$address->id}}" data-form-method='put'
                                                           href="{{ route('kyc.seller.addresses.toggle-default-status', ['id' => $address->id]) }}"
                                                        >
                                                            <i class="fa fa-check-square mr-2"></i>
                                                            {{__('Make Default')}}
                                                        </a>
                                                    @endif

                                                    @if(has_permission('kyc.seller.addresses.verification.create'))
                                                        <a class="dropdown-item"
                                                           href="{{route('kyc.seller.addresses.verification.create', $address->id)}}">
                                                            <i class="fa fa-map-marker mr-2"></i>
                                                            {{__('Verify This Address')}}
                                                        </a>
                                                    @endif
                                                @elseif($address->is_verified == VERIFICATION_STATUS_PENDING)
                                                    @if(has_permission('kyc.seller.addresses.verification.show'))
                                                        <a class="dropdown-item"
                                                           href="{{route('kyc.seller.addresses.verification.show', [$address->id, $address->knowYourCustomer->id])}}">
                                                            <i class="fa fa-map-marker mr-2"></i>
                                                            {{__('View Document')}}
                                                        </a>
                                                    @endif
                                                @else
                                                    <span>{{__('No action available')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="agent-info">
                                        <div class="personal-info mx-2 my-4 mb-5">
                                            @include('kyc.user.address._address_table')
                                        </div>
                                    </div>

                                    @if($address->is_default == ACTIVE)
                                        <div class="default-badge">
                                            {{ __('Default Address') }}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <h5 class="mb-3 font-weight-bold text-center border lf-toggle-border-color p-3 mt-4 bg-grey-light">
                                    {{__("You did not add any address yet!")}}
                                </h5>
                            @endforelse

                            <div class="text-center mt-4">
                                <a href="{{ route('kyc.seller.addresses.create') }}" class="btn-sm btn-success">
                                    {{ __('Add New Address') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


