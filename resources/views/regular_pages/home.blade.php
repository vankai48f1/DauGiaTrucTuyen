@extends('layouts.master',['hideBreadcrumb'=> true, 'hideNotice'=> true, 'transparentHeader'=> true,'inversedLogo' => false, 'fixedSideNav'=>false, 'activeSideNav' => active_side_nav()])
@section('style')
    <style>
        @media all and (max-width:575px){
            .skill-box {
                transform: translateY(0) !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="section-top pt-5 home-section-top">
        <div class="container py-5">
            <div class="banner-header">
                <div class="row">
                    <div class="col-12">
                        <div class="top-banner">
                            <div class="row align-items-center text-center">
                                <div class="col-md-12 mb-2">
                                    <div class="top-banner-text px-lg-5 text-justify mb-3">
                                        <h1 class="text-center text-info pt-4">NEXT LEVEL LARAVEL</h1>
                                        <p class="text-center mb-3 m-auto text-white home-text-style">Laraframe enhanced the laravel functionalities the way it can be used easier and faster with built in functionalities</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="top-banner-img">
                                        <img src="{{ asset('public/images/home/website.png') }}" alt=""
                                             class="img-fluid img-opacity">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-4">
                <div class="cmb-auction-item">
                    <img src="https://cdn.pixabay.com/photo/2016/11/29/05/45/astronomy-1867616__340.jpg"
                         alt="sd" class="auction-thumbnail">
                    <div class="cmb-item-content">
                        <h3>Lorem ipsum dolor consectet.</h3>
                        <div class="cmb-user my-1 text-muted">
                            <i class="fa fa-user-circle-o mr-2"></i> username
                        </div>
                        <div class="cmb-auction-date my-3 text-muted">END IN : <span class="font-size-16">30day 27hr 20m</span></div>
                        <div class="cmb-auction-terms">
                            <div class="cmb-price text-center">
                                <p class="font-size-16 font-weight-bold text-success">51USD</p>
                                <p class="text-muted">START AT</p>
                            </div>
                            <div class="cmb-shipping mx-auto text-center">
                                <p class="font-size-16 font-weight-bold">FREE</p>
                                <p class="text-muted">SHIPPING</p>
                            </div>
                            <div class="cmb-multi-bid ml-auto text-center">
                                <p class="font-size-16 font-weight-bold">YES</p>
                                <p class="text-muted">MULTI BID</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cmb-auction-item">
                    <img src="https://cdn.pixabay.com/photo/2016/11/29/05/45/astronomy-1867616__340.jpg"
                         alt="sd" class="auction-thumbnail">
                    <div class="cmb-item-content">
                        <h3>Lorem ipsum dolor consectet.</h3>
                        <div class="cmb-user my-1 text-muted">
                            <i class="fa fa-user-circle-o mr-2"></i> username
                        </div>
                        <div class="cmb-auction-date my-3 text-muted">END IN : <span class="font-size-16">30day 27hr 20m</span></div>
                        <div class="cmb-auction-terms">
                            <div class="cmb-price text-center">
                                <p class="font-size-16 font-weight-bold text-success">51USD</p>
                                <p class="text-muted">START AT</p>
                            </div>
                            <div class="cmb-shipping mx-auto text-center">
                                <p class="font-size-16 font-weight-bold">FREE</p>
                                <p class="text-muted">SHIPPING</p>
                            </div>
                            <div class="cmb-multi-bid ml-auto text-center">
                                <p class="font-size-16 font-weight-bold">YES</p>
                                <p class="text-muted">MULTI BID</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cmb-auction-item">
                    <img src="https://cdn.pixabay.com/photo/2016/11/29/05/45/astronomy-1867616__340.jpg"
                         alt="sd" class="auction-thumbnail">
                    <div class="cmb-item-content">
                        <h3>Lorem ipsum dolor consectet.</h3>
                        <div class="cmb-user my-1 text-muted">
                            <i class="fa fa-user-circle-o mr-2"></i> username
                        </div>
                        <div class="cmb-auction-date my-3 text-muted">END IN : <span class="font-size-16">30day 27hr 20m</span></div>
                        <div class="cmb-auction-terms">
                            <div class="cmb-price text-center">
                                <p class="font-size-16 font-weight-bold text-success">51USD</p>
                                <p class="text-muted">START AT</p>
                            </div>
                            <div class="cmb-shipping mx-auto text-center">
                                <p class="font-size-16 font-weight-bold">FREE</p>
                                <p class="text-muted">SHIPPING</p>
                            </div>
                            <div class="cmb-multi-bid ml-auto text-center">
                                <p class="font-size-16 font-weight-bold">YES</p>
                                <p class="text-muted">MULTI BID</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('style')
    <style>
        .home-section-top {
            background: rgb(41, 57, 79);
        }

        .img-opacity {
            opacity: 0.1;
        }

        .home-text-style {
            max-width: 500px;
            line-height: 1.5;
            margin-top: 40px !important;
        }
    </style>
@endsection
