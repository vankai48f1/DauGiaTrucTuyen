@extends('layouts.master',['activeSideNav' => active_side_nav()])
@section('content')
    <!-- ::::::::::::::::::::::START PAGE HEAD ::::::::::::::::::::::::: -->
    <div class="p-b-100  p-t-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {{ Form::model($auction, ['route'=>[ 'admin.auctions.update', $auction->id], 'id' => 'auctionForm', 'files' => true, 'method' => 'put']) }}
                    @include('auction.admin._form', ['buttonText' => __('Update')])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <!-- ::::::::::::::::::::::::END PAGE HEAD ::::::::::::::::::::::::: -->

@endsection

@section('script')
    @include('layouts.includes.list-js')
    <!-- for button loader -->
    <script src="{{asset('public/plugins/select2/js/select2.js')}}"></script>
    <script src="{{ asset('public/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator.js')}}"></script>
    <script src="{{asset('public/plugins/cvalidator/cvalidator-language-en.js')}}"></script>

    <script type="text/javascript">
        new Vue({
            el: '#app',
            data: {
                showBidIncrement: "{{$auction->auction_type}}",
                showShippingDescription: "{{$auction->is_shippable}}",
            },
            methods: {
                auctionTypeHandler(event) {
                    this.showBidIncrement = event.target.value;
                },
                isShippableHandler(event) {
                    this.showShippingDescription = event.target.value;
                },
            }
        });

        function GetDynamicTextBox() {
            return '<div class="col-lg-4 single-image-preview">' +
                '<div class="fileinput fileinput-new" data-provides="fileinput">' +
                '<div class="fileinput fileinput-new" data-provides="fileinput">' +
                '<div class="fileinput-new img-thumbnail mb-3">' +
                '<img class="img" src="{{auction_image('preview.png')}}"  alt="">' +
                '</div>' +
                '<div class="fileinput-preview fileinput-exists mb-3 img-thumbnail"></div>' +
                '<div>' +
                '<span class="btn btn-sm btn-outline-success btn-file mr-2">' +
                '<span class="fileinput-new">Select</span>' +
                '<span class="fileinput-exists">Change</span>' +
                '{{ Form::file('images[]', ['class'=>'multi-input', 'id' => 'images'])}}' +
                '</span>' +
                '<a href="#" class="btn btn-sm btn-outline-danger fileinput-exists" data-dismiss="fileinput">Remove</a>' +
                '<a href="#" class="btn-outline-danger minus-btn btn remove"><i class="fa fa-minus"></i></a>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>'
        }

        $(document).ready(function () {
            "use strict";

            //Init jquery Date Picker
            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
            });

            // select2
            $("#meta_keywords").select2({
                tags: true,
                tokenSeparators: [',', ' '],
                maximumSelectionLength: 300
            });

            var count = {{count($auction->images)}};

            $(document).on("click", "#btnAdd", function () {
                if(count <= 9)
                {
                    $("#TextBoxContainer").append(GetDynamicTextBox());
                    count++

                    if(count == 10)
                    {
                        $(this).remove()
                    }
                }

            });

            $("body").on("click", ".remove", function (e) {
                e.preventDefault();
                $(this).closest(".single-image-preview").remove();
                count--
                if(count < 10 && $('#btnAdd').length === 0)
                {
                    $('#preview-multi-img').append('<button id="btnAdd" type="button" class="btn btn-info mt-3 btn-sm font-size-12">{{__('Add Next Image')}}</button>')
                }
            });

            $("body").on("click", ".multi-input", function (e) {
                $(this).siblings('.old_image').remove();
            });

            let formRules = $('#auctionForm').cValidate({
                rules: {
                    'title' : 'required|min:3|max:255',
                    'auction_type' : 'integer',
                    'category_id' : 'required|integer',
                    'starting_date' : 'date',
                    'ending_date' : 'required|date',
                    'bid_initial_price' : 'integer',
                    'bid_increment_dif' : 'required|integer',
                    'product_description' : 'required|min:3|max:5000',
                    'terms_description' : 'required|min:3|max:5000',
                    'images.*' : 'image',
                    'is_shippable' : 'required|integer',
                    'shipping_type' : 'required|integer',
                    'is_multiple_bid_allowed' : 'required|integer'
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
                valid_child_elements : "h1/h2/h3/h4/h5/h6/a[%itrans_na],table[thead|tbody|tfoot|tr|td],strong/b/p/div/em/i/td[%itrans|#text],body[%btrans|#text]",
                setup: function(editor) {
                    editor.on('change keyup focus', function(e) {
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
                valid_child_elements : "h1/h2/h3/h4/h5/h6/a[%itrans_na],table[thead|tbody|tfoot|tr|td],strong/b/p/div/em/i/td[%itrans|#text],body[%btrans|#text]",
                setup: function(editor) {
                    editor.on('change keyup focus', function(e) {
                        $('#terms_description').val(editor.getContent());
                        formRules.reFormat('terms_description');
                    });
                }
            });
        });
    </script>
@endsection

@section('style-top')
    @include('layouts.includes.list-css')
    <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{asset('public/vendor/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
    <style>

        .fileinput .img-thumbnail > img {
            height: 230px !important;
        }

        .minus-btn {
            padding: 3px 14px !important;
            margin-left: 5px !important;
            line-height: 23px !important;
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

