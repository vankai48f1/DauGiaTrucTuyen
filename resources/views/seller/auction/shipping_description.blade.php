@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('content')

    <!-- ::::::::::::::::::::::START PAGE HEAD ::::::::::::::::::::::::: -->
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    @include('seller.auction._auction_nav')

                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-success text-center font-weight-bold mb-3">{{__('Congratulations you won the Auction!')}}</h4>
                            <div class="card">
                                <div class="card-body address-card">
                                    <div class="row">
                                        <div class="col-lg-3 align-self-center">
                                            <img class="img-fluid" src="{{auction_image(isset($auction->images[0]) && !empty($auction->images[0]) ? $auction->images[0] : '')}}"
                                                 alt="">
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="agent-info">
                                                <div class="personal-info mx-2 my-4">
                                                    <ul>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-product-hunt"></i>
                                                                {{__('Auction')}} :
                                                            </span>
                                                            <a class="font-weight-bold color-666"
                                                               href="{{route('auction.show', $auction->ref_id)}}">{{$auction->title}}</a>
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-user-circle-o"></i>
                                                                {{__('seller')}} :
                                                            </span>
                                                            <a class="font-weight-bold"
                                                               href="{{route('seller.store.show', $auction->seller->ref_id)}}">{{$auction->seller->name}}</a>
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-phone"></i>
                                                                {{__('phone')}} :
                                                            </span>
                                                            {{$auction->seller->phone_number}}
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-envelope"></i>
                                                                {{__('email')}} :
                                                            </span>
                                                            {{$auction->seller->email}}
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-money"></i>
                                                                {{__('you offered')}} :
                                                            </span>
                                                            <strong
                                                                class="text-success fz-16">{{$auction->currency->symbol}} {{$winner->amount}}</strong>
                                                        </li>
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-check-circle"></i>
                                                                {{__('Shipping Status')}} :
                                                            </span>

                                                            <span
                                                                class="badge badge-pill w-auto {{config('commonconfig.product_claim_status.' . ( !is_null($auction) ? $auction->product_claim_status : '' ) . '.color_class')}}">{{ config('commonconfig.product_claim_status.' . ( !is_null($auction) ? $auction->product_claim_status : '' ) . '.text')}}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($auction->status == AUCTION_STATUS_COMPLETED)
                                        <div class="default-badge">
                                            {{__('Auction Completed')}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-4">
                    @if(is_null($auction->address_id))
                        <div class="card">
                            <div class="card-body was-validated custom-validate" id="addressOn">
                                <h5 class="color-999 mb-3 border-bottom pb-3">
                                    <span class="font-weight-bold color-default"> {{__('Select an address')}} </span>
                                    {{__('you want to receive the product at')}} :
                                </h5>

                                <div class="row mb-3">
                                    <div class="col-lg-6 my-1">
                                        <button class="btn font-weight-bold color-999 bg-custom-gray p-5 w-100 fz-20"
                                                :class="{'active-color' : showExistingAddress }"
                                                @click="onClickExistingAddress">{{__('Existed Address')}}</button>
                                    </div>
                                    <div class="col-lg-6 my-1">
                                        <button class="btn font-weight-bold color-999 bg-custom-gray p-5 w-100 fz-20"
                                                :class="{'active-color' : showNewAddress}"
                                                @click="onClickNewAddress">{{__('New Address')}}</button>
                                    </div>
                                </div>

                            {{ Form::open(['route'=>['shipping-description.update', $auction->ref_id],'class'=>'form-horizontal edit-profile-form','id' => 'addressInfo']) }}
                            @method('post')

                            <!-- Existed addresses -->
                                <div v-show="showExistingAddress">
                                    @forelse($addresses as $address)
                                        <div class="card custom-validate-hover my-3">
                                            <div class="custom-control custom-radio mb-3">
                                                {{Form::radio('address_id', old('address_id', $address->id), false, ['class' => 'custom-control-input',  'id' => 'checkerId'. $loop->iteration] )}}
                                                <label class="custom-control-label"
                                                       for="checkerId{{$loop->iteration}}"></label>
                                            </div>
                                            <div class="card-body address-card">
                                                <div class="agent-info">
                                                    <div class="personal-info mx-2 my-4">
                                                        <ul>
                                                            <li>
                                                                <span>
                                                                    <i class="fa fa-user"></i>
                                                                    {{__('name')}} :
                                                                </span>
                                                                {{$address->name}}
                                                            </li>
                                                            <li>
                                                                <span>
                                                                    <i class="fa fa-map-marker"></i>
                                                                    {{__('location')}} :
                                                                </span>
                                                                {{$address->city}}
                                                                {{$address->country->name}}
                                                            </li>
                                                            <li>
                                                                <span>
                                                                    <i class="fa fa-phone"></i>
                                                                    {{__('phone')}} :
                                                                </span>
                                                                {{$address->phone_number}}
                                                            </li>
                                                            <li>
                                                                <span>
                                                                    <i class="fa fa-envelope"></i>
                                                                    {{__('post code')}} :
                                                                </span>
                                                                {{$address->post_code}}
                                                            </li>
                                                            <li>
                                                                <span>
                                                                    <i class="fa fa-check-circle"></i>
                                                                    {{__('Verification Status')}} :
                                                                </span>

                                                                <span
                                                                    class="d-inline badge badge-{{config('commonconfig.verification_status.' .  $address->is_verified  . '.color_class')}}"> {{verification_status($address->is_verified) }} </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @if($address->is_default == ACTIVE_STATUS_ACTIVE)
                                                    <div class="default-badge">
                                                        {{$address->is_default == ACTIVE_STATUS_ACTIVE ? 'Default Address' : ''}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div
                                            class="text-center fz-16 py-3 px-3 bg-custom-gray">{{__('You do not have any address, please submit an address first')}}</div>
                                    @endforelse
                                </div>

                                <!-- New address form -->
                                <div v-show="showNewAddress">

                                    <div class="card custom-validate-hover my-3">
                                        <div class="card-body address-card p-t-50">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{Form::label('name', __('Name :'), ['class' => 'text-muted'])}}
                                                        {{Form::text('name', null, ['class' => 'form-control' ] )}}
                                                        <span
                                                            class="invalid-feedback">{{ $errors->first('name') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        {{Form::label('phone_number', __('Contact Number :'),['class' => 'text-muted'])}}
                                                        {{Form::text('phone_number', null, ['class' => 'form-control'] )}}
                                                        <span
                                                            class="invalid-feedback">{{ $errors->first('phone_number') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        {{Form::label('address', __('Street Address :'),['class' => 'text-muted'])}}
                                                        {{Form::text('address', null, ['class' => 'form-control',] )}}
                                                        <span
                                                            class="invalid-feedback">{{ $errors->first('address') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        {{Form::label('country', __('Country :'),['class' => 'text-muted'])}}
                                                        {{ Form::select('country_id', $countries, null, ['class'=> 'custom-select country', 'v-on:change'=> "onChange(".'$event'.")", 'id' => 'country_id', 'placeholder' => __('Select Country')]) }}
                                                        <span
                                                            class="invalid-feedback">{{ $errors->first('country_id') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        {{Form::label('post_code', __('Zip / Post Code :'),['class' => 'text-muted'])}}
                                                        {{Form::text('post_code', null, ['class' => 'form-control', 'id' => 'post_code'] )}}
                                                        <span
                                                            class="invalid-feedback">{{ $errors->first('post_code') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        {{Form::label('city', __('City :'),['class' => 'text-muted'])}}
                                                        {{Form::text('city', null, ['class' => 'form-control',  'id' => 'city' ] )}}
                                                        <span
                                                            class="invalid-feedback">{{ $errors->first('city') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="{{ 'state_id' }}"
                                                               class="control-label text-muted required">
                                                            {{ __('State :') }}
                                                            <span v-show="isLoading">
                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </span>
                                                        </label>

                                                        <div class="form-group">
                                                            <select class="custom-select" name="state_id"
                                                                    :disabled="disableStateDom">
                                                                <option>{{__('Select State')}}</option>
                                                                <option :selected="selectedState === index"
                                                                        v-for="(state, index) in states" :value="index">
                                                                    @{{
                                                                    state }}
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <span
                                                            class="invalid-feedback">{{ $errors->first('state_id') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delivery instruction form -->
                                <div class="card my-3">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="{{ 'delivery_instruction' }}"
                                                   class="control-label color-666 fz-16 required">{{__('Any')}} <span
                                                    class="color-666 font-weight-bold">{{__('Delivery Instruction')}}</span> {{__('To Seller')}}
                                                : <span class="d-block fz-12">({{__('Optional')}})</span> </label>
                                            {{Form::textarea('delivery_instruction', null, ['class' => 'form-control', 'id' => 'delivery_instruction','rows' => 3 ] )}}
                                            <span
                                                class="invalid-feedback">{{ $errors->first('delivery_instruction') }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{ Form::submit('Submit Address',['class'=>'btn btn-info px-4 mt-2']) }}

                                {{ Form::close() }}

                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3 color-666"><span class="color-default"> {{__('Product')}}</span> {{__('you will be sent
                                    at')}} <span class="color-default"> {{__('this address')}} </span> :</h5>
                                <div class="card custom-validate-hover my-3">
                                    <div class="card-body address-card">
                                        <div class="agent-info">
                                            <div class="personal-info mx-2 my-4">
                                                <ul>
                                                    <li>
                                                <span>
                                                    <i class="fa fa-user"></i>
                                                    {{__('name ')}}:
                                                </span>
                                                        {{$productReceivingAddress->name}}
                                                    </li>
                                                    <li>

                                                <span>
                                                    <i class="fa fa-map-marker"></i>
                                                    {{__('location')}} :
                                                </span>
                                                        {{$productReceivingAddress->city}}
                                                        {{$productReceivingAddress->country->name}}
                                                    </li>
                                                    <li>
                                                <span>
                                                    <i class="fa fa-phone"></i>
                                                    {{__('phone')}} :
                                                </span>
                                                        {{$productReceivingAddress->phone_number}}
                                                    </li>
                                                    <li>
                                                <span>
                                                    <i class="fa fa-envelope"></i>
                                                    {{__('post code')}} :
                                                </span>
                                                        {{$productReceivingAddress->post_code}}
                                                    </li>
                                                    <li>
                                                <span>
                                                    <i class="fa fa-check-circle"></i>
                                                    {{__('Verification Status')}} :
                                                </span>
                                                        <span
                                                            class="badge d-inline-block w-auto badge-pill pr-2 text-white font-weight-normal badge-{{config('commonconfig.verification_status.' . ( $productReceivingAddress->is_verified !== VERIFICATION_STATUS_APPROVED ? VERIFICATION_STATUS_UNVERIFIED  : $productReceivingAddress->is_verified) . '.color_class')}}"> {{verification_status($productReceivingAddress->is_verified) }} </span>
                                                    </li>
                                                    @if( !empty($productReceivingAddress->delivery_instruction) )
                                                        <li>
                                                        <span>
                                                            <i class="fa fa-list-alt"></i>
                                                            {{__('My Delivery Instruction')}} :
                                                        </span>

                                                            {{ $productReceivingAddress->delivery_instruction }}

                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @if($productReceivingAddress->is_default == ACTIVE_STATUS_ACTIVE)
                                            <div class="default-badge">
                                                {{$productReceivingAddress->is_default == ACTIVE_STATUS_ACTIVE ? 'Default Address' : ''}}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Start: shipping instruction -->
                                @if(!empty($auction->shipping_description))
                                    <div class="mt-4">
                                        <h5 class="color-333 mb-3">{{__('Shipping instruction :')}}</h5>
                                        <p class="mt-3 color-666">{{$auction->shipping_description}}</p>
                                    </div>
                                @endif
                            <!-- End: shipping instruction -->

                                <!-- Start: shipping instruction -->
                                @if(!is_null($auction->delivery_date) && $auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_ON_SHIPPING)
                                    <div class="mt-4">
                                        <h5 class="color-333 mb-3">{{__('Estimated Delivery Date')}} :</h5>
                                        <span class="mt-3 fz-20 font-weight-bold">{{ $auction->delivery_date }}</span>
                                    </div>

                                    <!-- End: shipping instruction -->
                                    <h5 class="color-333 mt-4">{{__('Have you received the product yet?')}}</h5>
                                    <span
                                        class="d-block fz-12 color-666">{{__('Please let us know if you have received the product.')}}</span>
                                    <a class="dropdown-item confirmation btn btn-info bg-success border-0 d-inline-block mt-3 w-auto"
                                       data-alert="{{__('Are you sure?')}}"
                                       data-form-id="urm-{{$auction->id}}" data-form-method='put'
                                       href="{{ route('buyer.confirm-delivery', $auction->ref_id) }}">
                                        <i class="fa fa-check-circle mr-2"></i>
                                        {{__('Yes')}}
                                    </a>
                                @endif

                                @if(
                                    !is_null($auction->delivery_date) &&
                                     $carbon->parse($auction->delivery_date) < now() &&
                                    now() < $reportWithIn &&
                                    !in_array($auction->product_claim_status, [AUCTION_PRODUCT_CLAIM_STATUS_DISPUTED, AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED ])
                                )
                                    <h5 class="color-333 mt-4">{{__('If You have not received the product in time, Please Report Here.')}}</h5>
                                    <a class="btn btn-info border-0 d-inline-block mt-3"
                                       href="{{route('disputes.specific', [DISPUTE_TYPE_SHIPPING_ISSUE, $auction->ref_id])}}">
                                        <i class="fa fa-trash-o mr-2"></i>
                                        {{__('Report')}}
                                    </a>
                                    <span class="mt-3 color-666 fz-12 d-block"> <span
                                            class="font-weight-bold color-666">{{__('Note :')}}</span> {{__('If it is late then the given time by seller, please contact with him/her for more details.')}}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- ::::::::::::::::::::::::END PAGE HEAD ::::::::::::::::::::::::: -->

@endsection

@section('script')
    <script>
        "use strict";

        var app = new Vue({
            el: '#addressInfo',
            el: "#addressOn",
            data: {
                states: [],
                selectedState: "{{ old('state_id') }}",
                selectedCountryId: "{{ old('country_id') }}",
                disableStateDom: false,
                isLoading: false,
                showExistingAddress: false,
                showNewAddress: false,
            },

            methods: {
                onClickExistingAddress(e) {
                    this.showExistingAddress = !this.showExistingAddress;
                    this.showNewAddress = false;
                },
                onClickNewAddress(e) {
                    this.showNewAddress = !this.showNewAddress;
                    this.showExistingAddress = false;
                },
                onChange: function (event) {
                    this.getStates(event.target.value);
                },
                getStates: function (countryId) {
                    this.disableStateDom = true;
                    this.isLoading = true;
                    const thisApp = this
                    let url = "{{route('ajax.get-states', 99999)}}";
                    url = url.replace(99999, countryId);

                    axios.get(url)
                        .then(function (response) {
                            thisApp.states = response.data.states;
                        })
                        .catch(function (error) {
                            flashBox('error', "{{ __('Failed to load states! Please try again.') }}");
                        })
                        .finally(function () {
                            thisApp.disableStateDom = false;
                            thisApp.isLoading = false;
                        });
                }
            },

            mounted() {
                if (parseInt(this.selectedCountryId) && this.selectedCountryId > 0) {
                    this.getStates(this.selectedCountryId);
                }
            }
        })
    </script>
@endsection

@section('style-top')
    <style>
        .agent-info .personal-info ul li span {
            width: 20%;
            text-align: left !important;
            display: inline-block;
            text-transform: capitalize;
        }

        .active-color {
            background-color: #46AB2B;
            color: #fff !important;
        }

        .custom-validate-hover .custom-radio .custom-control-input {
            width: 100%;
            height: 100%;
            z-index: 99;
            cursor: pointer;
        }

        .was-validated .custom-select:valid, .was-validated .form-control:valid {
            border-color: #ced4da;
        }

        .form-group input,
        .form-group select {
            position: relative;
            z-index: 99;
        }

        .custom-validate .custom-radio .custom-control-input ~ .custom-control-label::after {
            font-family: 'FontAwesome';
            content: "\f00c";
            font-size: 20px;
            z-index: 99;
            width: 100% !important;
            background: #d0d0d0;
            height: 100%;
            position: relative;
            border-radius: 40px;
            padding: 5px 10px;
            color: #fff;
        }

        .custom-validate-hover .custom-radio .custom-control-input {
            width: 100%;
            height: 100%;
            z-index: 99;
            cursor: pointer;
        }
    </style>
@endsection

