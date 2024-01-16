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

                        @component('components.card',['type' => 'info', 'class'=> 'border-top-0 py-4 px-3'])
                            {{ Form::model($address,['route' => ['address.update', $address->id], 'class' => 'cvalidate', 'id' => 'addressInfo']) }}
                            @method('put')

                            @include('user.profile.personal_info.address._form')

                            {{ Form::close() }}
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/js/cvalidator.min.js') }}"></script>

    <script>
        var app = new Vue({
            el: '#addressInfo',
            data: {
                states : [],
                selectedState : "{{ old('state_id', isset($address) ? $address->state->id : '' ) }}",
                selectedCountryId : "{{ old('country_id', isset($address) ? $address->country->id : '' ) }}",
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
                    axios.post("{{route('ajax.get-states')}}", {
                        country_id: countryId
                    })
                        .then(function (response) {
                            thisApp.states = response.data.states;
                            console.log(thisApp.states)
                        })
                        .catch(function (error) {
                            alert('Failed to load states! Please try again.');
                        })
                        .finally(function () {
                            thisApp.disableStateDom = false;
                            thisApp.isLoading = false;
                        });
                }
            },

            mounted(){
                if( parseInt(this.selectedCountryId) && this.selectedCountryId > 0 )
                {
                    this.getStates(this.selectedCountryId);
                }
            }
        })

        (function ($) {
            "use strict";

            $('.cvalidate').cValidate();
        });
    </script>
@endsection
