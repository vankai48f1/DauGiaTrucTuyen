@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('title', $title)
@section('content')
    <div class="p-b-100 p-t-50">
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
                            {{ Form::open(['route'=>'kyc.seller.addresses.store', 'id'=> 'create-address-from']) }}
                            @include('kyc.seller.address._form')
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
    <script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>

    <script>
        (function ($) {
            'use strict';

            $('#create-address-from').cValidate({
                rules: {
                    'name': 'required|max:55',
                    'address': 'required|string|max:255',
                    'phone_number': 'required|max:25',
                    'post_code': 'required|string|max:25',
                    'city': 'required|string:max:55',
                    'country_id': 'required|integer',
                    'state_id': 'required|integer',
                }
            });
        }) (jQuery);

        new Vue({
            el: '#app',
            data: {
                states: [],
                selectedState: "{{ old('state_id', isset($address) ? $address->state->id : '' ) }}",
                selectedCountryId: "{{ old('country_id', isset($address) ? $address->country->id : '' ) }}",
                disableStateDom: false,
                isLoading: false
            },

            methods: {
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
        });
    </script>
@endsection
