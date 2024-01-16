@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('content')

    <!-- ::::::::::::::::::::::START PAGE HEAD ::::::::::::::::::::::::: -->
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    @if(!is_null($isAddressVerified) && $seller->is_active == ACTIVE)
                        {{ Form::open(['route'=>'auction.store', 'id' => 'auctionForm', 'files' => true]) }}
                        @include('seller.auction._form', ['buttonText' => __('Create')])
                        {{ Form::close() }}
                    @else
                        <div class="card py-5">
                            <div class="card-body text-center auction-form p-5">
                                <h2 class="color-666 font-weight-bold">{{__('Access Denied !')}}</h2>
                                <p class="color-999 fz-16 mt-2">{{__('Please check if your')}} <span
                                        class="font-weight-bold">{{__('account is active')}}</span> {{__('and your address is')}}
                                    <span class="font-weight-bold">{{__('verified')}}</span>.</p>
                                <a class="btn btn-secondary d-inline-block mt-4"
                                   href="{{route('seller.store.index')}}">{{__('Go Back')}}</a>
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
    @include('layouts.includes.list-js')
    <script src="{{asset('public/plugins/select2/js/select2.js')}}"></script>
    <!-- for button loader -->
    <script src="{{ asset('public/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>

    <script type="text/javascript">
        new Vue({
            el: '#app',
            data: {
                showBidIncrement: false,
                showShippingDescription: true,
            },
            methods: {
                auctionTypeHandler(event) {
                    this.showBidIncrement = event.target.value === "{{ AUCTION_TYPE_HIGHEST_BIDDER }}";
                },
                isShippableHandler(event) {
                    this.showShippingDescription = event.target.value === "{{ ACTIVE }}";
                },
            }
        });

        (function ($) {
            "use strict";

            //Init jquery Date Picker
            $('#start_time').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: new Date(),
                useCurrent: false,
            });

            $('#end_time').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: false,
                minDate: new Date().setDate(new Date().getDate() + 1),
            });

            $("#start_time").on("dp.change", function (e) {
                let minDate = new Date(e.date);
                let maxDate = new Date(e.date);
                minDate.setDate(minDate.getDate() + 1);
                maxDate.setDate(maxDate.getDate() + 90);
                $('#end_time').data("DateTimePicker").minDate( minDate );
                $('#end_time').data("DateTimePicker").maxDate( maxDate );
            });
            $("#end_time").on("dp.change", function (e) {
                let date = new Date(e.date);
                date.setDate(date.getDate() - 1);
                $('#start_time').data("DateTimePicker").maxDate( date );
            });

            // select2
            $("#meta_keywords").select2({
                tags: true,
                tokenSeparators: [',', ' '],
                maximumSelectionLength: 300
            })

            var count = 0

            $(document).on("click", "#btnAdd", function () {
                if (count < 9) {
                    $("#TextBoxContainer").append(GetDynamicTextBox());
                    count++

                    if (count == 9) {
                        $(this).remove()
                    }
                }

            });

            $("body").on("click", ".remove", function () {
                $(this).closest("div").remove();
                count--
                if (count == 1) {
                    $('#preview-multi-img').append('<button id="btnAdd" type="button" class="btn btn-info mt-3 btn-sm font-size-12">{{__('Add Next Image')}}</button>')
                }
            });

            function GetDynamicTextBox() {
                return '<div class="col-lg-4">' +
                    '<div class="fileinput fileinput-new" data-provides="fileinput">' +
                    '<div class="fileinput fileinput-new" data-provides="fileinput">' +
                    '<div class="fileinput-new img-thumbnail mb-3">' +
                    '<img class="img" src="{{know_your_customer_images('preview.png')}}"  alt="">' +
                    '</div>' +
                    '<div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>' +
                    '<div>' +
                    '<span class="btn btn-sm btn-outline-success btn-file mr-2">' +
                    '<span class="fileinput-new">Select</span>' +
                    '<span class="fileinput-exists">Change</span>' +
                    '{{ Form::file('images[]', [old('images'),'class'=>'multi-input', 'id' => 'images'])}}' +
                    '</span>' +
                    '<a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">Remove</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<td><button type="button" class="btn btn-danger remove"><i class="fa fa-minus"></i></button></td>' +
                    '</div>'
            }

            let formRules = $('#auctionForm').cValidate({
                rules: {
                    'title': 'required|min:3|max:255',
                    'auction_type': 'required|integer',
                    'category_id': 'required|integer',
                    'starting_date': 'required|date',
                    'ending_date': 'required|date',
                    'bid_initial_price': 'required|integer',
                    'bid_increment_dif': 'required|integer',
                    'product_description': 'required|min:3|max:5000',
                    'terms_description': 'required|min:3|max:5000',
                    'images': 'required',
                    'is_shippable': 'required|integer',
                    'shipping_type': 'required|integer',
                    'is_multiple_bid_allowed': 'required|integer',
                    'meta_description': 'max:255',
                    'meta_keywords': 'array',
                    'meta_keywords.*': 'required',
                }
            });
            tinymce.init({
                selector: '#product_description',
                menubar: false,
                plugins: 'link image code lists textcolor colorpicker table hr',
                toolbar: 'bold italic link image alignleft aligncenter alignright  forecolor backcolor code table',
                relative_urls: false,
                mobile: {
                    menubar: false,
                    toolbar: 'bold italic link image alignleft aligncenter alignright code',
                },
                valid_child_elements: "h1/h2/h3/h4/h5/h6/a[%itrans_na],table[thead|tbody|tfoot|tr|td],strong/b/p/div/em/i/td[%itrans|#text],body[%btrans|#text]",
                setup: function (editor) {
                    editor.on('change keyup focus', function (e) {
                        $('#product_description').val(editor.getContent());
                        formRules.reFormat('product_description');
                    });
                }
            });

            tinymce.init({
                selector: '#terms_description',
                menubar: false,
                plugins: 'link image code lists textcolor colorpicker table hr',
                toolbar: 'bold italic link image alignleft aligncenter alignright  forecolor backcolor code table',
                relative_urls: false,
                mobile: {
                    menubar: false,
                    toolbar: 'bold italic link image alignleft aligncenter alignright code',
                },
                valid_child_elements: "h1/h2/h3/h4/h5/h6/a[%itrans_na],table[thead|tbody|tfoot|tr|td],strong/b/p/div/em/i/td[%itrans|#text],body[%btrans|#text]",
                setup: function (editor) {
                    editor.on('change keyup focus', function (e) {
                        $('#terms_description').val(editor.getContent());
                        formRules.reFormat('terms_description');
                    });
                }
            });

        }) (jQuery);
    </script>
@endsection

@section('style-top')
    @include('layouts.includes.list-css')
    <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
    <style>

        .minus-btn {
            padding: 3px 14px !important;
            margin-left: 5px !important;
            line-height: 23px !important;
        }

        .fileinput .img-thumbnail > img {
            height: 200px !important;
        }

        .fileinput .img-thumbnail {
            position: relative;
        }

        .card {

            box-shadow: 0 0 15px 1px #efefef;
            border: 1px solid rgba(142, 142, 142, 0.23);

        }

    </style>
@endsection

